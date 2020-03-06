<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;

use App\Models\Feedback;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use App\Models\Spskill;
use App\Models\Skill;
use Illuminate\Support\Facades\Mail;

/**
 * Class AccountController.
 */
class FeedbackController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    

    public function create($slug="", Request $request) {        
        $user = Auth::user();
        $fromuserId='';
        $fromusrname='';
        if(!empty($user))
        {
            $fromuserId=$user->id;
            $fromuserfname=$user->first_name;
            $fromuserlname=$user->last_name;
            $fromusrname = $fromuserfname.' '.$fromuserlname;
        }
        $touserId = '';
        $model = new Feedback; 
        if($slug!="")
        {            
            $userData = User::where('slug',$slug)->get();            
            if(!empty($userData))
            {
                $touserId=0;
                foreach ($userData as $key => $value) {
                   $touserId=$value->id;
                   $touserfirstName=$value->first_name;
                   $touserlastName=$value->last_name;
                   $touserfullName=$touserfirstName.' '.$touserlastName;
                   $touser_profile_image=$value->avatar_location;
                   $back="/profile/".$value->slug;
                }
               
                $Sproskills = Feedback::SpRemainigSkill($touserId,$fromuserId);
                                
                return view('frontend.user.feedback.create',['model' => $model,'fromuserId'=>$fromuserId,'touserId'=>$touserId,'fromusrname'=>$fromusrname,'slug'=>$slug,'Sproskills'=>$Sproskills,'touserName'=>$touserfullName,'touser_profile_image' => $touser_profile_image,'back'=>$back]);
            }
            else
            {
                return abort(404);
            }
        }
        else
        {
            return abort(404);
        }              
        
    }

    public function store(Request $request){       
        $rules = [
                'review' => 'required',
                'sp_skill_id' => 'required',
        ];
       
        $messages = [
            'review.required' => __('strings.new.review_required'),
            'sp_skill_id.required' => __('strings.new.sp_skill_id_required'),            
        ];
       

        $data = $this->validate($request, $rules, $messages);
        $flag = 'feedback';
        $feedback = new Feedback();        
        $feedback->from_userid = $request->get('from_userid');
        $feedback->to_userid = $request->get('to_userid');
        $feedback->value_for_money = $request->get('value_for_money');
        $feedback->quality_of_work = $request->get('quality_of_work');
        $feedback->relation_with_customer = $request->get('relation_with_customer');
        $feedback->performance = $request->get('performance');
        $feedback->review = $request->get('review');
        $feedback->sp_skill_id = $request->get('sp_skill_id');
        $slug = $request->get('slug');
        $total = (((int) $request->get('value_for_money') + (int) $request->get('quality_of_work') + (int) $request->get('relation_with_customer') + (int) $request->get('performance')) / 4);
        $feedback->total = (float) $total;
        $feedback->save();

        $request->session()->put('flag', $flag);

        // send mail to service provider...
        $user = User::where('slug',$slug)->first();
        $skill = Skill::getSkillNameById($feedback->sp_skill_id);
        $data = [];
        $data['html'] = '
            <p><strong>Hello '.$user->first_name.' '.$user->last_name.',</strong></p>
            <p><strong>'.Auth::user()->first_name.' '.Auth::user()->last_name.'</strong> has been submitted feedback for your skill.<p>
            <p>&nbsp;</p>
            <p>Skill: '.$skill.'</p>
            <p>Rating:</p>
            <table width="100%">
                <tr><td>Value for Money:</td><td>'.$feedback->value_for_money.' out of 5 stars</td></tr>
                <tr><td>Relation with Customer:</td><td>'.$feedback->relation_with_customer.' out of 5 stars</td></tr>
                <tr><td>Quality of Work:</td><td>'.$feedback->quality_of_work.' out of 5 stars</td></tr>
                <tr><td>Performance:</td><td>'.$feedback->performance.' out of 5 stars</td></tr>
                <tr><td>Total:</td><td>'.round($feedback->total).' out of 5 stars</td></tr>
            </table>
            <p>Review: '.$feedback->review.'</p>
        ';
        Mail::send('frontend.mail.offlineMessage', $data, function($mail_msg) use($user, $data) {
            $mail_msg->subject("Helpii - New feedback arrived!");
            $mail_msg->from(config('mail.from.address'), config('mail.from.name'));
            $mail_msg->to($user->email, $user->first_name." ".$user->last_name);
        });
        
        return redirect()->route('frontend.profile.slug',[$slug])->withFlashSuccess(__('strings.new.feedback_save'));
    }

    public function ajaxfeedback($slug='',$page='',Request $request)
    {
        if($slug!="")
        {
            $userData = User::where('slug',$slug)->first();
            if($userData)
            {
                $userId=$userData->id;
                $spavtar = array();                
                $alluserData = array();

                $userStatus=$userData->active;
                if($userStatus == '1')
                {                    
                    $feedbackData = DB::table('rating')
                            ->leftjoin('users', 'users.id', '=', 'rating.from_userid')
                            ->leftJoin('social_accounts', function($join){
                                $join->on('social_accounts.user_id', '=', 'rating.from_userid')
                                     ->on('users.avatar_type', '=', 'social_accounts.provider');
                            })
                            ->select('rating.*','users.first_name','users.last_name','users.avatar_type','users.avatar_location','users.email','social_accounts.provider','social_accounts.avatar')
                            ->where('rating.to_userid', $userId)
                            ->paginate(10); 
                   
                    
                    return view('frontend.userdetailsTab.ajaxfeedback',compact('feedbackData'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
                }
                else
                {
                    return abort(404);
                }
            }
            else
            {
                return abort(404);
            }
        }
    }
    
}
