<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\View\View;
use App\Models\Skill;
use App\Models\Spskill;
use App\Models\Auth\User;
use App\Models\Currency;
use App\Models\Profile;
use App\Models\Auth\PasswordHistory;
use App\Repositories\Backend\Auth\UserRepository;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use App\Models\Message;

class ServiceproviderController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function index(Request $request)
    {  
        $serviceprovider = User::where('is_sp','=', 1);         
        $searchbyfirstName ="";
        $searchbylastName ="";
        $searchbyEmail="";        

        if(!empty($request->get('first_name')) || !empty($request->get('last_name')) || !empty($request->get('email')))
        {
            $searchbyfirstName = $request->get('first_name');           
            $searchbylastName = $request->get('last_name');
            $searchbyEmail = $request->get('email');

             if(!empty($searchbyEmail)){                
               $serviceprovider = $serviceprovider->where('email','like','%'.$searchbyEmail.'%');
            } 
           
            if(!empty($searchbyfirstName)){    
                     
               $serviceprovider = $serviceprovider->where('first_name','like','%'.$searchbyfirstName.'%');               
            } 

            if(!empty($searchbylastName))
            {
               $serviceprovider = $serviceprovider->where('last_name','like','%'.$searchbylastName.'%');
            } 

           
        }

        $serviceprovider = $serviceprovider->latest()->paginate(10);

        Breadcrumbs::for('admin.serviceprovider', function ($trail) {
            $trail->push(__('strings.new.serviceprovider'), route('admin.serviceprovider'));
        });
                 
        return view('backend.serviceprovider.index',compact('serviceprovider','searchbyfirstName','searchbylastName','searchbyEmail'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function Create(Request $request ,$id='' ) {
        //User Code

        $model = new User();
        $model1 = new Profile();
        // echo "<pre>";
        // print_r($model);die;

        $spskill = array();
        
        //SP Skill Code
        // $model1 = new Spskill;
        // $user = User::GetAll();        
        // $Currency = Currency::GetAll();        
        // $skills[""]=__('strings.new.select_skill');

        Breadcrumbs::for('admin.serviceprovider.create', function ($trail) {
            $trail->push(__('strings.new.serviceprovider'), route('admin.serviceprovider.create'));
        });
        
        return view('backend.serviceprovider.create',compact('model','model1','id','spskill'));
    }

    

    public function edit($id){
        
        $model = User::where('id', '=', $id)->first(); 
        $model1 = Profile::where('user_id', '=', $id)->first();       
        $spskill = Spskill::where('user_id',$id)->orderBy('id', 'desc')->paginate(10);

        Breadcrumbs::for('admin.serviceprovider.edit', function ($trail,$id) {
            $trail->push(__('strings.new.serviceprovider'), route('admin.serviceprovider.edit',$id ) );
        });
        
        return view('backend.serviceprovider.create',compact('model','model1','id','spskill'))->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    

    public function Store(Request $request){
        // Service Provider basic details Code Start
        $user_id = $request->get('id');
        $avatar_image = "";
        $fileName = "";
        $fileName1 = "";
        if(empty($request->get('id'))) {
            $rules = [            
                'first_name'        => 'required',
                'last_name'         => 'required',
                'email'             => 'required',
                'email'             => 'email',
                'email'             => Rule::unique('users')
            ];
        } else {
           $rules = [            
                'first_name'        => 'required',
                'last_name'         => 'required',
                'email'             => 'required',
                'email'             => 'email'
            ]; 
        }

        $messages = [            
            'first_name.required'   => 'First Name cannot be blank.',
            'last_name.required'    => 'Last Name cannot be blank.',
            'email.required'        => 'Email cannot be blank.',                      
        ];

        $data = $this->validate($request, $rules, $messages);

        $profile = Profile::where('user_id', $user_id)->first();
        if(empty($profile)){
            $profile = new Profile();
        }

        if(!empty($request->get('id'))) {
            $user_update = User::find($user_id);
            $user_update->first_name=$request->get('first_name');
            $user_update->last_name=$request->get('last_name');
            $user_update->email=$request->get('email');
            $user_update->active=($request->get('active')) ? $request->get('active') : 0;
        
            if((!empty($request->file('avatar_location'))) && (!empty($request->get('avatar_image')))) {
                $avatar_image = $request->get('avatar_image');
                $fileName =  time() . explode('/', explode(':', substr($avatar_image, 0, strpos($avatar_image, ';')))[1])[1];
                $user_update->avatar_location='avatars/'.$fileName;
                $user_update->avatar_type = $request->get('avatar_type');
            }

            if($user_update->save()) {
                if((!empty($request->file('avatar_location'))) && (!empty($request->get('avatar_image')))) {
                    Image::make($avatar_image)->save(public_path('/storage/avatars/').$fileName);
                    $previous_avatar_image = $request->get('previous_avatar_image');
                    if(!empty($request->get('previous_avatar_image'))) {
                        $fpath = public_path('/storage/').$previous_avatar_image;
                        File::delete($fpath);
                    }
                }
            }
        } else {            
            $data_user=array();
            $roles=array();
            $roles[0]="user";
            $data_user["first_name"]=$request->get('first_name');
            $data_user["last_name"]=$request->get('last_name');
            $data_user["email"]=$request->get('email');
            $data_user["password"]=$request->get('password');
            $data_user["active"]=($request->get('active')) ? $request->get('active') : 0;
            $data_user["confirmed"]=1;

            $avatar_location="";            
            $user_id="";

            if((!empty($request->file('avatar_location'))) && (!empty($request->get('avatar_image')))) {
                $avatar_image = $request->get('avatar_image');
                $fileName =  time() . explode('/', explode(':', substr($avatar_image, 0, strpos($avatar_image, ';')))[1])[1];
                $avatar_location='avatars/'.$fileName;                
            }
            
            $data_user["avatar_location"]=$avatar_location;            
            $data_user["avatar_type"]=$request->get('avatar_type');
            $data_user["roles"]=$roles;
            $data_user["is_sp"]=1;

            $user = $this->userRepository->create($data_user);
            if($user) {
                if((!empty($request->file('avatar_location'))) && (!empty($request->get('avatar_image')))) {
                    Image::make($avatar_image)->save(public_path('/storage/avatars/').$fileName);
                    $previous_avatar_image = $request->get('previous_avatar_image');
                    if(!empty($request->get('previous_avatar_image'))) {
                        $fpath = public_path('/storage/').$previous_avatar_image;
                        File::delete($fpath);
                    }
                }
                $user_id=$user->id;
            }          
        }

        // Service Provider Profile details Code Start
        $dir = public_path()."/spbanner/".$user_id;
        if(!file_exists($dir)){
            mkdir($dir, 0755, true);
        }

        if(!empty($request->files) && !empty($request->file('banner_image'))) {
            $fileName1 = time().'.'.request()->banner_image->getClientOriginalExtension();
            $profile->banner_image=$fileName1;
        }

        $profile->user_id=$user_id;
        $profile->phone=$request->get('phone');
        $profile->experience=$request->get('experience');
        $profile->about=$request->get('about');
        $profile->address=$request->get('address');        
        $profile->city=$request->get('city');
        $profile->state=$request->get('state');
        $profile->country=$request->get('country');
        $profile->pincode=$request->get('pincode');
        $profile->latitude=$request->get('latitude');
        $profile->longitudes=$request->get('longitudes');            
        $profile->facebook=$request->get('facebook');
        $profile->twitter=$request->get('twitter');
        $profile->linkedin=$request->get('linkedin');
        $profile->instagram=$request->get('instagram');

        if($profile->save()) {
            if(!empty($request->files) && !empty($request->file('banner_image'))) {
                $fileimage = $request->file('banner_image');                
                $fileimage->move($dir ."/", $fileName1); 
                $previous_banner_image = $request->get('previous_banner_image');
                if(!empty($request->get('previous_banner_image'))){
                    $fpath = 'spbanner/'.$user_id.'/'.$previous_banner_image;
                    File::delete($fpath);
                }               
            }
        }
             
        if(!empty($request->get('id'))){
            return redirect()->route('admin.serviceprovider')->withFlashSuccess(__('strings.new.update_message'));
        }

        return redirect()->route('admin.serviceprovider')->withFlashSuccess(__('strings.new.insert_message'));
        
    }

    public function destroy($id)
    {  
        $user = User::find($id);
        $user->Profile()->forcedelete();
        $user->Spskill()->delete();
        $user->SocialAccount()->delete();
        $user->Spavailability()->delete();
        $user->Photogallary()->delete();        
        $user->fromUserRating()->delete();
        $user->toUserRating()->delete();       
        $user->conversationUserOne()->delete();
        $user->conversationUserTwo()->delete();
        $user->mainuserofFavourite()->delete();
        $user->favouriteUser()->delete();

        Message::where('user_id', '=', $user->id)->delete();
        Message::where('receiver_id', '=', $user->id)->delete();

        if(!empty($_POST['action']) && $_POST['action'] == "remain_as_customer"){
            $user->is_sp = 0;
            $user->update();
        } else {
            PasswordHistory::where('user_id', '=', $id)->delete();             
            $user->forcedelete();
            // $user->delete();
        }
        
        return redirect()->route('admin.serviceprovider')->withFlashSuccess(__('strings.new.delete_message'));
    }
}
