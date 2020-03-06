<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;




use App\Helpers\Auth\Auth;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;

use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Frontend\Auth\UserSessionRepository;
use Cache;
use carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ads;



/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {   
        $advtisement = Ads::where('pagename','homepage')->where('status',1)->get()->toArray();
        $ads=array();
        foreach ($advtisement as $key => $value) {
            switch ($value['position']) {
                case 'top':
                    $ads['top']=$value;                   
                    break;
                case 'bottom':
                    $ads['bottom']=$value;                    
                    break;

                case 'left':
                    $ads['left']=$value;                    
                    break;

                case 'right':
                    $ads['right']=$value;                   
                    break;
                
            }
        }
        return view('frontend.index',compact('ads'))->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    public function users()
    {
        return User::all();
    }


    public function search()
    {
        return view('frontend.search');
    }

    public function about()
    {
        $advtisement = Ads::where('pagename','aboutus')->where('status',1)->get()->toArray();
        $ads=array();
        foreach ($advtisement as $key => $value) {
            switch ($value['position']) {
                case 'top':
                    $ads['top']=$value;                   
                    break;
                case 'bottom':
                    $ads['bottom']=$value;                    
                    break;

                case 'left':
                    $ads['left']=$value;                    
                    break;

                case 'right':
                    $ads['right']=$value;                   
                    break;
                
            }
        }

        return view('frontend.about',compact('ads'));
    }
    public function service()
    {
        $advtisement = Ads::where('pagename','servicepage')->where('status',1)->get()->toArray();
        $ads=array();
        foreach ($advtisement as $key => $value) {
            switch ($value['position']) {
                case 'top':
                    $ads['top']=$value;                   
                    break;
                case 'bottom':
                    $ads['bottom']=$value;                    
                    break;

                case 'left':
                    $ads['left']=$value;                    
                    break;

                case 'right':
                    $ads['right']=$value;                   
                    break;
                
            }
        }
        return view('frontend.service',compact('ads'));
    }

    public function notification(){
        $data=array();
        $data['total_notification']=0;
        $html = "";
        $html = "<ul class='dropdown-menu' role='menu' aria-labelledby='notifi-menu'>";
        $html.="<li class='notification-li'>";  
        $html .= "<span>".__('strings.new.no_new_notification')."</span>";  
        $html .= "</li>";
        $html .= "</ul>";
        $data['html'] = $html;

        if(\Auth::check()){
            $html = "";

            $loged = auth()->user();
            $query = "SELECT COUNT(readStatus) as unread , user_id as userId FROM `messages` WHERE receiver_id=$loged->id and readStatus=0 GROUP BY user_id";
            $UnreadMessage = DB::select($query);

            if(!empty($UnreadMessage)){
                $data['total_notification'] = count($UnreadMessage);
                
                foreach ($UnreadMessage as $key => $value) {
                    $user = user::find($value->userId);

                    $image = "/storage/avatars/dummy.png";

                    if($user->avatar_type == "gravatar"){
                        $image = "/storage/avatars/dummy.png";
                    }else if ($user->avatar_type == "storage"){
                        if($user->avatar_location){
                            $image = "/storage/".$user->avatar_location;
                        } else {
                            $image = "/storage/avatars/dummy.png";
                        }
                    }else{
                        $social_Account = SocialAccount::where('user_id','=',$user->id)->where('provider','=',$user->avatar_type)->first();
                        if(!empty($social_Account)){
                            $image = $social_Account->avatar;
                        }
                    }

                    $html .= "<li class='notification-li'>";  
                    $html .= "<a href='/inbox'><div class='left-noti-part'><img src='$image' width='30px' height='30px;'></div><div class='right-noti-part'><span class='unread-message'> $value->unread ".__('strings.new.Message_from')." " .$user->first_name." ". $user->last_name ." </span></div></a>";  
                    $html .= "</li>";  
                }
            }

            $query_f = "SELECT COUNT(read_status) as unread , from_userid as userId FROM `rating` WHERE to_userid = $loged->id and read_status = 0 GROUP BY from_userid";
            $unread_feedbacks = DB::select($query_f);

            if(!empty($unread_feedbacks)){
                if(!empty($data['total_notification'])){
                    $data['total_notification'] += count($unread_feedbacks);
                } else {
                    $data['total_notification'] = count($unread_feedbacks);
                }
                
                foreach ($unread_feedbacks as $key => $value) {
                    $user = user::find($value->userId);

                    $image = "/storage/avatars/dummy.png";

                    if($user->avatar_type == "gravatar"){
                        $image = "/storage/avatars/dummy.png";
                    }else if ($user->avatar_type == "storage"){
                        if($user->avatar_location){
                            $image = "/storage/".$user->avatar_location;
                        } else {
                            $image = "/storage/avatars/dummy.png";
                        }
                    }else{
                        $social_Account = SocialAccount::where('user_id','=',$user->id)->where('provider','=',$user->avatar_type)->first();
                        if(!empty($social_Account)){
                            $image = $social_Account->avatar;
                        }
                    }

                    $html .= "<li class='notification-li'>";  
                    $html .= "<a href='/feedbacks'><div class='left-noti-part'><img src='$image' width='30px' height='30px;'></div><div class='right-noti-part'><span class='unread-message'> $value->unread ".__('strings.new.feedbacks_from')." " .$user->first_name." ". $user->last_name ." </span></div></a>";  
                    $html .= "</li>";  
                }
            }

            if(!empty($html)){
                $html = "<ul class='dropdown-menu' role='menu' aria-labelledby='notifi-menu'>".$html."</ul>";
                $data['html'] = $html;
            }

            $data['total_total_notification_html'] ="<span class='noti_msg'>".$data['total_notification']."</span>";
        }
        return response()->json(compact('data'));   
    }

    public function getAdsBanner($page,$position){
        $advtisement = Ads::where('pagename',$page)->where('position' ,$position )->where('status',1)->first();
        return response()->json(compact('advtisement'));
        //return view('frontend.service',compact('advtisement'));
    }
}
