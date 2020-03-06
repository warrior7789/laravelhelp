<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Models\Spskill;
use App\Models\Spavailability;
use App\Models\Photogallary;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\FavSp;
use App\Models\Ads;
/**
 * Class AccountController.
 */
class UserdetailsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($slug="", Request $request) {
        if($slug!="") {
            $userData = User::where('slug',$slug)->first();            
            if($userData) {
                $userId=$userData->id;
                $spavtar = array();                
                $alluserData = array();

                $userStatus=$userData->active;
                if($userStatus == '1') {
                    $alluserData = User::with(['Spskill','Profile','SocialAccount','Spavailability','Photogallary'])->where('id', '=', $userId)->first();

                    $feedbackData = DB::table('rating')
                            ->leftjoin('users', 'users.id', '=', 'rating.from_userid')
                            ->leftJoin('social_accounts', function($join){
                                $join->on('social_accounts.user_id', '=', 'rating.from_userid')
                                     ->on('users.avatar_type', '=', 'social_accounts.provider');
                            })
                            ->select('rating.*','users.first_name','users.last_name','users.avatar_type','users.avatar_location','users.email','social_accounts.provider','social_accounts.avatar')
                            ->where('rating.to_userid', $userId)
                            ->paginate(10); 

                    $spskill_id=array();
                    $Sproskills = Spskill::where('user_id','=',$userId)->where('status','=',1)->get();
                    if(!empty($Sproskills)) {
                        foreach ($Sproskills as $sskill) {
                           $spskill_id[]=$sskill->skill_id;
                        }
                    }

                    $sessflag = $request->session()->get('flag');

                    $flag = '';
                    if($sessflag) {
                        $flag = 'feedback';
                        $request->session()->forget('flag');
                    }

                    $user = Auth::user();
                    $checkonline=$userData->isOnline();
                    $isonline = 0;
                    if(!empty($checkonline)) {
                        $isonline = 1;
                    }
                    
                    $fromuserData = 0;
                    if((!empty($user)) && (!empty($spskill_id))) {
                        $fromuserId=$user->id;
                        $fromuserData = Feedback::CheckRemainigSkill($userId,$fromuserId);
                    }

                    $userAverageRating = Feedback::user_average_rating($userId);
                    $userAverageRating = round($userAverageRating);

                    $sp_fav=0;

                    if(!empty($user)){
                        $FavSp  = FavSp::where('user_id','=',$user->id)->where('fav_user_id','=',$userId)->first();

                        if(!empty($FavSp)){
                            $sp_fav=1;
                        }
                    }

                    $advtisement = Ads::where('pagename','userdetailspage')->where('status',1)->get()->toArray();
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
                    
                    return view('frontend.userdetails',compact('alluserData','Sproskills','slug','flag','fromuserData','feedbackData','userAverageRating','isonline','sp_fav','ads'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                } else {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        }
    }

    public function feedbacks(){
        // ALTER TABLE `rating` ADD `read_status` INT(11) NOT NULL DEFAULT '0' AFTER `review`;
        if(Auth::user()->is_sp == 1){
            // read feedbacks...
            $update = Feedback::where('to_userid' ,'=',auth()->id())->where('read_status','=',0)->update(['read_status' => 1]);

            $feedbacks = DB::table('rating')
                            ->leftjoin('users', 'users.id', '=', 'rating.from_userid')
                            ->leftjoin('skill', 'skill.id', '=', 'rating.sp_skill_id')
                            ->leftJoin('social_accounts', function($join){
                                $join->on('social_accounts.user_id', '=', 'rating.from_userid')
                                     ->on('users.avatar_type', '=', 'social_accounts.provider');
                            })
                            ->select('rating.*','users.first_name','users.last_name','users.avatar_type','users.avatar_location','users.email','social_accounts.provider','social_accounts.avatar', 'skill.name AS skill_name')
                            ->where('rating.to_userid', Auth::user()->id)
                            ->paginate(10);

            return view('frontend.user.feedbacks',compact('feedbacks'));
        }

        return abort(404);
    }
}
