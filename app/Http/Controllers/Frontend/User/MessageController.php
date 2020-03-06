<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Auth\User;
use App\Models\Message;
use App\Models\Conversation;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\PrivateMessageSent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\SocialAccount;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function private()
    {
        return view('frontend.private');
    }
    
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }
   
    public function privateMessages(User $user)
    {   


        // onclick make all message read make read 
        $update = Message::where('receiver_id' ,'=',auth()->id())->where('user_id','=',$user->id)->where('readStatus','=',0)->update(['readStatus' => 1]);
        // $update->readStatus = 1;
        // $update->save();
        // $privateCommunication= Message::where(['user_id'=> auth()->id(), 'receiver_id'=> $user->id])
        // ->orWhere(function($query) use($user){
        //     $query->where(['user_id' => $user->id, 'receiver_id' => auth()->id()]);
        // })
        // ->get();

       //echo auth()->id();
      // echo "//".$user->id;
        $privateCommunication= Message::Orwhere(function($query) use($user){
            $query->Where(['user_id' => $user->id, 'receiver_id' => auth()->id()]);
            
            $query->orwhere(function($query) use($user){
                $query->Where(['user_id' => auth()->id(), 'receiver_id' =>$user->id ]);

            });

        })->where('deleted_by',"!=" ,auth()->id())
        //->toSql();
        ->get();
        

        $user_image="/storage/avatars/dummy.png";
        if($user->avatar_type == "gravatar"){
            $user_image= "/storage/avatars/dummy.png";
        }else if ($user->avatar_type == "storage"){
            if(!empty($user->avatar_location)){
                $user_image="/storage/".$user->avatar_location;
            } else {
                $user_image= "/storage/avatars/dummy.png";
            }
        }else{
            $social_Account = SocialAccount::where('user_id','=',$user->user_id)->where('provider','=',$user->avatar_type)->first();
            if(!empty($social_Account)){
                $user_image=$social_Account->avatar;
            } else {
                $user_image= "/storage/avatars/dummy.png";
            }
        }
        $user['imaged']=$user_image;
        $other['total_message'] = $privateCommunication->count();
        $other['is_sp'] = 0;
        $other['slug'] = "";

        $other['is_online'] = 0;
        if($user->isOnline()){
            $other['is_online']= 1;
        }
        if($user->is_sp){
            $other['is_sp'] = 1;
            $other['profile_url'] = "/profile/".$user->slug;
        }

        
        return response()->json(compact('privateCommunication','user','other'));
        return $privateCommunication;
    }

    public function sendMessage(Request $request){

        if(request()->has('file')){
            $filename = request('file')->store('chat');
            $message=Message::create([
                'user_id' => request()->user()->id,
                'image' => $filename,
                'receiver_id' => request('receiver_id')
            ]);
        }else{
            $message = auth()->user()->messages()->create(['message' => $request->message]);

        }

        broadcast(new MessageSent(auth()->user(),$message->load('user')))->toOthers();        
        return response(['status'=>'Message sent successfully','message'=>$message]);
    }

    public function sendPrivateMessage(Request $request,User $user){


        $user_to = $user->id;
        $myID = Auth::user()->id;

        //check if conversation already started or not
        $checkCon1 = DB::table('conversation')->where('user_one',$myID)
        ->where('user_two',$user_to)->get(); // if loggedin user started conversation
        $checkCon2 = DB::table('conversation')->where('user_two',$myID)
        ->where('user_one',$user_to)->get(); // if loggedin recviced message first
        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());
        $conID=0;
        if(count($allCons)!=0){
            $conID = $allCons[0]->id;
            $conversation = Conversation::find($conID)->touch();
            //$conversation->touch()->update();
        }
        if(request()->has('file')){
            $fileavtar = $request->file('file');
            $ext = $fileavtar->getClientOriginalExtension();
            $filename = $fileavtar->getClientOriginalName();
            $avatar = time().$filename; 
            $dir = public_path()."/storage/chat/";
            $fileavtar->move($dir ."/", $avatar);

            //$filename = request('file')->store('chat');
            $message=Message::create([
                'user_id' => request()->user()->id,
                'image' => "/chat/".$avatar,
                'receiver_id' => $user->id,
                'conversation_id' => $conID,                    
            ]);                       
        }else{
            $input=$request->all();
            $input['receiver_id']=$user->id;
            $input['receiver_id']=$user->id;
            $input['conversation_id']=$conID;
            $message=auth()->user()->messages()->create($input);
        }

        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();
        
        return response(['status'=>'Message private sent successfully','message'=>$message]);

    }

    public function sendQuickMessage(Request $request,User $user){

        $msg = $request->message;
        $user_to = $user->id;
        $myID = Auth::user()->id;

        //check if conversation already started or not
        $checkCon1 = DB::table('conversation')->where('user_one',$myID)
        ->where('user_two',$user_to)->get(); // if loggedin user started conversation
        $checkCon2 = DB::table('conversation')->where('user_two',$myID)
        ->where('user_one',$user_to)->get(); // if loggedin recviced message first
        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());

        if(count($allCons)!=0){

            // old conversation
            $conID_old = $allCons[0]->id;
            //insert data into messages table
                $input=$request->all();
                $input['receiver_id']=$user->id;
                $input['conversation_id']=$conID_old;         
                $message=auth()->user()->messages()->create($input);
                $conversation = Conversation::find($conID_old)->touch();
        }else {
            // new conversation
                $conversation = new Conversation;
                $conversation->user_one =$myID ; // customer
                $conversation->user_two =$user_to;  // service
                $conversation->save(); 
                
                $input=$request->all();
                $input['receiver_id']=$user->id;        
                $input['conversation_id']=$conversation->id;        
                $message=auth()->user()->messages()->create($input);
        }
        
        //check if conversation already started or not

        // if servicve provider is offline then only send mail also...
        if(!$user->isOnline()){
            $data = [];
            $data['html'] = '
                <p><strong>Hello '.$user->first_name.' '.$user->last_name.',</strong></p>
                <p>A new message from <strong>'.Auth::user()->first_name.' '.Auth::user()->last_name.'</strong> has been arrived, please be online on '.config('app.url').'<p>
                <p>&nbsp;</p>
                <p>Message: </p>
                <p>'.$msg.'</p>
            ';
            Mail::send('frontend.mail.offlineMessage', $data, function($mail_msg) use($user, $data) {
                $mail_msg->subject("Helpii - New message arrived!");
                $mail_msg->from(config('mail.from.address'), config('mail.from.name'));
                $mail_msg->to($user->email, $user->first_name." ".$user->last_name);
            });
        }

        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();        
        return response(['status'=>'Message private sent successfully','message'=>$message]);
    }

    public function getUsers(){

            $Conversation = Conversation::where('conversation.user_two', Auth::user()->id)->orwhere('conversation.user_one', Auth::user()->id)
                ->orderBy('conversation.updated_at', 'DESC')->paginate(50);
            //echo "<pre>";print_r($Conversation);die("ASDf");
            $result = array();
            $i=0;
            $loged_user_id = Auth::user()->id;
            $with_user="";
            if(!empty($Conversation)){
                foreach ($Conversation as $key => $value) { 
                    if($value->user_one != $loged_user_id){
                        $with_user = $value->user_one;
                    }
                    if($value->user_two !=$loged_user_id){
                        $with_user = $value->user_two;
                    }
                    $user = User::find($with_user);
                    if(empty($user)) continue;
                    $count = Message::where('receiver_id' ,'=',Auth::user()->id)
                    ->where('user_id','=',$with_user)->where('readStatus','=',0)->get();
                    $result[$i]['unread_message'] = $count->count();
                    $result[$i]['id'] = $user->id;
                    $result[$i]['name'] = $user->first_name . " ".$user->last_name ;
                    $result[$i]['email'] = $user->email;
                    $result[$i]['isOnline'] = 0;
                    $isOnline = $user->isOnline();
                    if($isOnline)
                        $result[$i]['isOnline'] = 1;
                    if($user->avatar_type == "gravatar"){
                        $result[$i]['sp_image']= "/storage/avatars/dummy.png";
                    }elseif($user->avatar_type == "storage"){
                        if($user->avatar_location){
                            $result[$i]['sp_image'] = "/storage/".$user->avatar_location;
                        } else {
                            $result[$i]['sp_image']= "/storage/avatars/dummy.png";
                        }
                    }else{
                        $social_Account = SocialAccount::where('user_id','=',$user->user_id)->where('provider','=',$user->avatar_type)->first();
                        if(!empty($social_Account))
                            $result[$i]['sp_image']=$social_Account->avatar;
                    }
                    $i++;
                }
            }

            return $result;
    }
    public function SearchUsers($search){
            
            // this is fixed because alwasy customer start chat with sp
                $allUsers1 =array();
                
                $allUsers1 = DB::table('users')
                ->Join('conversation','users.id','conversation.user_one')
                ->where('conversation.user_two', Auth::user()->id)
                ->where(function($query ) use ($search){
                    if(!empty($search)){
                        $query->where('users.first_name', 'like',$search . '%')->orWhere('users.last_name', 'like', $search . '%');
                    }
                })->get([
                    'users.id as user_id',
                ]);
                $allUsers2 =array();
              
               
                //return $allUsers1;
                
                $allUsers2 = DB::table('users')
                ->Join('conversation','users.id','conversation.user_two')
                ->where('conversation.user_one', Auth::user()->id)
                ->where(function($query ) use ($search){
                    if(!empty($search)){
                        $query->where('users.first_name', 'like',$search . '%')->orWhere('users.last_name', 'like', $search . '%');
                    }
                })->get([
                    'users.id as user_id',
                ]);
          


            // $users = DB::table('users')
            // ->Join('conversation','users.id','conversation.user_one')
            // ->where('conversation.user_two', Auth::user()->id)
            // ->orwhere('conversation.user_one', Auth::user()->id)
            // ->where(function($query ) use ($search){
            //     $query->where('users.first_name', 'like',$search . '%')->orWhere('users.last_name', 'like', $search . '%');
            // })
            // ->orderBy('conversation.updated_at', 'DESC')->get([
            //     'users.id as user_id',
            // ]);


            $users =  array_merge($allUsers1->toArray(), $allUsers2->toArray());

            // $users = Message::where('receiver_id' ,'=',Auth::user()->id)
            // ->orderBy('created_at', 'DESC')
            // ->get()
            // ->unique('receiver_id');
            
            $result = array();
            $i=0;
            foreach ($users as $key => $value) {               
                $user = User::find($value->user_id);
                // count unread message 
                $count = Message::where('receiver_id' ,'=',Auth::user()->id)
                ->where('user_id','=',$value->user_id)->where('readStatus','=',0)->get();
                $result[$i]['unread_message'] = $count->count();        
                //$result[$i]['conversation_id'] = $user->id;
                $result[$i]['id'] = $user->id;
                $result[$i]['name'] = $user->first_name . " ".$user->last_name ;
                $result[$i]['email'] = $user->email;
                $result[$i]['isOnline'] = 0;
                $isOnline = $user->isOnline();
                if($isOnline)
                    $result[$i]['isOnline'] = 1;

                //echo $value->avatar_type;
                // echo "<pre>";print_r($user);echo "</pre>";
                if($user->avatar_type == "gravatar"){
                    $result[$i]['sp_image']= "/storage/avatars/dummy.png";
                }elseif($user->avatar_type == "storage"){
                    $result[$i]['sp_image']="/storage/".$user->avatar_location;                    
                }else{
                    $social_Account = SocialAccount::where('user_id','=',$user->user_id)->where('provider','=',$user->avatar_type)->first();
                    if(!empty($social_Account))
                        $result[$i]['sp_image']=$social_Account->avatar;
                }
                $i++;
            }

            return $result;
    }

    public function countPrivateMessage($receiver_id,$for_user){
        $count = Message::where('receiver_id' ,'=',$receiver_id)
        ->where('user_id','=',$for_user)->where('readStatus','=',0)->get();
        return $count->count();        
    }
    public function ReadPrivateMessage($receiver_id,$for_user){
        $count = Message::where('receiver_id' ,'=',$receiver_id)
        ->where('user_id','=',$for_user)->where('readStatus','=',0)->get();
        return $count->count();        
    }

    public function ClearPrivateMessage($for_user){


        $privateCommunication = Message::where(['user_id'=> auth()->id(), 'receiver_id'=> $for_user])
        ->orWhere(function($query) use($for_user){
            $query->where(['user_id' => $for_user, 'receiver_id' => auth()->id()]);
        })
        ->get();

        $delete_message =array();
        if(!empty($privateCommunication)){
            foreach ($privateCommunication as $key => $value) {
                
                // find which msg delete permenantly
                if($value->deleted_by > 0 && $value->deleted_by !=auth()->id() ){
                    $delete_message[] = $value->id;
                }

            }

            // delete all message if clear by both user
            //echo "<pre>";print_r($delete_message);echo "</pre>";
            if(!empty($delete_message)){
               // echo implode(",",$delete_message);
                //die("ASDf");
                DB::table("messages")->whereIn('id',$delete_message)->delete();
            }
            //  update all message 
            

            $privateCommunication = Message::where(['user_id'=> auth()->id(), 'receiver_id'=> $for_user])
            ->orWhere(function($query) use($for_user){
                $query->where(['user_id' => $for_user, 'receiver_id' => auth()->id()]);
            })->update(['deleted_by' => auth()->id()]);

        }

        return response(['status'=>'1','message'=>"delete succesfully",'loged'=>auth()->id(),'delete_for'=>$for_user]);

    }

    public function download($imagename='')
    {       
        $file=public_path()."/storage/chat/".$imagename;
        return Response::download($file);
    }

    
   
}
