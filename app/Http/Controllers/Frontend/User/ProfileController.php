<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Profile;
use App\Models\FavSp;
use App\Models\Auth\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Feedback;


use App\Models\Spskill;
use App\Models\Skill;
use App\Models\Currency;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */

    /*public function index()
    {   
        $user = Auth::user();
        $Spskills = Spskill::where('user_id',$user->id)->paginate(15);
        
        $Spavailability = Spavailability::where('user_id',$user->id)->first();

        $Photogallary = Photogallary::where('user_id',$user->id)->paginate(10);
        $Photogallarycount = Photogallary::where('user_id',$user->id)->count();
        
        $timeslot = array();
        if(!empty($Spavailability)){
            $timeslot = json_decode($Spavailability->timeslot);
        }
        return view('frontend.user.account',compact('Spskills','Spavailability','timeslot','Photogallary','Photogallarycount'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }*/

    public function update(UpdateProfileRequest $request)
    {   
        
       
        $data = $this->validate($request, [
            'slug'=>'unique:users|min:4',                                       
        ]);
        

        $output = $this->userRepository->update(
            $request->user()->id,
            $request->only('is_sp','first_name', 'last_name', 'email', 'avatar_type', 'avatar_location','slug'),
            $request->has('avatar_location') ? $request->file('avatar_location') : false,
            $request->get('avtar_image') ? $request->get('avtar_image') :false,
            $request->get('remove_profile_image')

        );

        $profile = new Profile;
        if(!empty($request->get('profile_id'))){
            $profile = Profile::find($request->get('profile_id'));
        }

        $dir = public_path()."/spbanner/".$request->user()->id;
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $previous_banner_image = $profile->banner_image;
        $fileName = "";

        if(!empty($request->get('is_sp')) && $request->get('is_sp') == 1){

            if(!empty($request->files) && !empty($request->file('banner_image'))) {
                $fileName = time().'.'.request()->banner_image->getClientOriginalExtension();
                $profile->banner_image=$fileName;
            }

            if(!empty($request->remove_profile_banner)){
                $fpath = 'spbanner/'.$request->user()->id.'/'.$previous_banner_image;
                File::delete($fpath);
                $profile->banner_image="";
            }

            // if(!empty($request->get('avtar_image'))){                
            //     $imageData = $request->get('avtar_image');
            //     $fileName =  'profilepic.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                
            //     Image::make($request->get('avtar_image'))->save(public_path('/storage/avatars/').$fileName);
            // }

            
            $profile->user_id=$request->user()->id;
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
            
            if($profile->save())
            {
                if(!empty($request->files) && !empty($request->file('banner_image'))) 
                {  
                    $fileimage = $request->file('banner_image');                
                    $fileimage->move($dir ."/", $fileName);                     
                    if($previous_banner_image != '')
                    {                    
                        $fpath = 'spbanner/'.$request->user()->id.'/'.$previous_banner_image;
                        File::delete($fpath);
                    }              
                }
            }           
            
        }

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(__('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('frontend.user.account')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }

    public function AjaxValidation(UpdateProfileRequest $request){

        $data = $this->validate($request, [
            'slug'=>'unique:users|min:4',                                       
        ]);
    }

    public function updaterole(){
        die("ASDfdas");
    }

    public function checkSlug(Request $request){
        $slug = $request->get('slug');
        $userSlug = $this->userRepository->getRelatedSlugs($slug);       
        echo $userSlug;        
        die;
    }


    public function AddToFav($user_id){

        $data['status']=0;
        $data['message']=__('strings.new.please_login');
        $user = Auth::user();

        if(empty($user))
            return response()->json(compact('data'));

        $FavSp  = FavSp::where('user_id','=',$user->id)->where('fav_user_id','=',$user_id)->first();

        //exit($FavSp->count());
        //echo "<pre>";print_r($FavSp);echo "</pre>";
        //die($FavSp->id);
        if(!empty($FavSp)){
            //die("ASdfadsf");
           
            $FavSp->delete();
           // die("ADSf");
           $data['status']=1; 
           $data['remove_fav']=1; 
           $data['message']=__('strings.new.remove_to_fav_list'); 
        }else{
            $FavSp = new FavSp;
            $FavSp->user_id = $user->id;
            $FavSp->fav_user_id = $user_id;
            $FavSp->save();
            $data['status']=1; 
            $data['add_fav']=1; 
            $data['message']=__('strings.new.add_to_fav_list'); 
            
        }

        return response()->json(compact('data'));

    }


    public function favsp(){

        $loged = Auth::user();
        $datas = DB::table('fav_sp')
        ->select([
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.avatar_type',
            'users.avatar_location',
            'users.slug',
            'users.updated_at as updated_at',
            'profile.phone',
            'profile.about',
            'profile.address',
            'profile.city',
            'profile.state',
            'profile.country',
            'profile.pincode',
            'profile.latitude',
            'profile.longitudes',            
        ])
        ->leftjoin('profile', 'profile.user_id', '=', 'fav_sp.fav_user_id')
        ->leftjoin('users', 'users.id', '=', 'fav_sp.fav_user_id')       
        ->where('fav_sp.user_id', '=',$loged->id)          
        //->orderBy('users.id', 'DESC') 
        ->paginate(2);

        $setting['total'] = $datas->total();
        $setting['perpage'] = 2;

        $result = array();
        if(!empty($datas)){
            $i=0;
            foreach ($datas as $key => $value) {

               $userAverageRating = Feedback::user_average_rating($value->user_id);
               $userAverageRating = round($userAverageRating); 
               $user = User::find($value->user_id);
               $isOnline = $user->isOnline();
               $last_login = $user->updated_at->diffForHumans();
               //$diffForHumans = User::find($value->user_id)->diffForHumans();
               $result[$i]['user_id'] = $value->user_id;
               $result[$i]['rating'] = $userAverageRating;
               $result[$i]['isOnline'] = 0;
               $result[$i]['able_to_send_message'] = 0;
               

               
               if(!empty($loged)){
                    if(!($loged->id == $value->user_id))
                        $result[$i]['able_to_send_message'] = 1;
               }


               if($isOnline)
                    $result[$i]['isOnline'] = 1;

                if($value->avatar_type == "gravatar"){
                    $result[$i]['sp_image']= "/storage/avatars/dummy.png";
                }else if ($value->avatar_type == "storage"){
                    if($value->avatar_location){
                        $result[$i]['sp_image']="/storage/".$value->avatar_location;                    
                    } else {
                        $result[$i]['sp_image']= "/storage/avatars/dummy.png";
                    }
                }else{
                    $social_Account = SocialAccount::where('user_id','=',$value->user_id)->where('provider','=',$value->avatar_type)->first();
                    if(!empty($social_Account))
                        $result[$i]['sp_image']=$social_Account->avatar;
                }

                // $Spskills = Spskill::where('user_id',$value->user_id)->get();
                // if(!empty($Spskills)){
                //     $j=0;
                //     foreach ($Spskills as $key => $Spskill) {
                //        // echo "<pre>";print_r($Spskill->skill->avatar);echo"</pre>";
                //         $result[$i]['sp_skill_images'][$j++]="/storage/skills/".$Spskill->skill->avatar;
                //
                // }
                $result[$i]['sp_name']=$value->first_name ." ".$value->last_name;
                $result[$i]['sp_about']=$value->about;
                $result[$i]['sp_slug']=$value->slug;
                $result[$i]['sp_last_login']=$last_login;
                
                
                $result[$i]['email']=$value->email;
                $result[$i]['address']=$value->address;
                $result[$i]['city']=$value->city;
                $result[$i]['state']=$value->state;
                $result[$i]['country']=$value->country;
                $result[$i]['latitude']=$value->latitude;
                $result[$i]['longitudes']=$value->longitudes;
                $result[$i]['phone']=$value->phone;              
                
                $i++;
               
            }
        }        
        return response()->json(compact('result','setting'));        
    }


    public function switchuser(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $convert_to = $request->get('convert_to');  

        $user_val = User::where(['id'=>$user_id])->first();
        if($convert_to == 'sp'){
            $user_val->is_sp = 1;
            if($user_val->update()){
                $data['msg'] = 'Successfully Switch to Service Provider';
                $data['status'] = 1;
            }else{
                $data['msg'] = 'Error to Switch as Service Provider';
                $data['status'] = 0;
            }
        }else{
            $user_val->is_sp = 0;
            if($user_val->update()){
                $data['msg'] = 'Successfully Switch to Customer';
                $data['status'] = 1;
            }else{
                $data['msg'] = 'Error to Switch as Customer';
                $data['status'] = 0;
            }
        }

        echo json_encode($data); exit();
    }

    public function removeConfirmationCode(){
        $user = Auth::user();
        if(!empty($user->confirmation_code)){
            $user->confirmation_code = "";
            $user->update();
        }
        echo json_encode(1); exit();
    }
}