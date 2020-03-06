<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Spavailability;

/**
 * Class AccountController.
 */
class SpavailabilityController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {	
    	// $user = Auth::user();
    	// $Spskills = Spskill::where('user_id',$user->id)->paginate(10);

     //    // echo $user->id;
     //    // echo "<pre>";print_r($Spskills);echo "</pre>";

    	// return view('frontend.user.skill.index',compact('Spskills'))
     //        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(Request $request ) {        
              
        $user = Auth::user();
        $model = Spavailability::where('user_id',$user->id)->first();
        $timeslot=array();         
        if(empty($model)){ 
            $model = new Spavailability;            
        }else{
            $timeslot =json_decode($model->timeslot);
        } 

              
        return view('frontend.user.sp_availability',compact('model','timeslot'));
    }

    public function Store(Request $request){
        $user = Auth::user();
        if(!empty($request->get('id'))){
            $Spavailability = Spavailability::find($request->get('id'));
        } else {
            $Spavailability = new Spavailability();
        }

       
        

        $timeslot=array();
        if(!empty($request->monday['close'])){
            $timeslot["monday"]['close'] = 1;
        }else{
            $timeslot["monday"] = $request->monday;
        }

        if(!empty($request->tuesday['close'])){
            $timeslot["tuesday"]['close'] = 1;
        }else{
            $timeslot["tuesday"] = $request->tuesday;

        }

        if(!empty($request->wednesday['close'])){
            $timeslot["wednesday"]['close'] = 1;
        }else{
            $timeslot["wednesday"] = $request->wednesday;

        }


        if(!empty($request->thursday['close'])){
            $timeslot["thursday"]['close'] = 1;
        }else{
            $timeslot["thursday"] = $request->thursday;

        }

        if(!empty($request->friday['close'])){
            $timeslot["friday"]['close'] = 1;
        }else{
            $timeslot["friday"] = $request->friday;

        }

        if(!empty($request->saturday['close'])){
            $timeslot["saturday"]['close'] = 1;
        }else{
            $timeslot["saturday"] = $request->saturday;

        }

        if(!empty($request->sunday['close'])){
            $timeslot["sunday"]['close'] = 1;
        }else{
            $timeslot["sunday"] = $request->sunday;

        }

        
        $Spavailability->user_id=$user->id;
        $Spavailability->timeslot=json_encode($timeslot);
        $Spavailability->save();
       

        
        // if(!empty($request->get('id')))      
        //     return redirect()->route('frontend.user.account')->withFlashSuccess( __('strings.new.availability_update_message'));

        // return redirect()->route('frontend.user.account')->withFlashSuccess(__('strings.new.availability_insert_message'));

        $url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#sp_availability';
        if(!empty($request->get('id'))){
            return \Redirect::to($url)->withFlashSuccess(__('strings.new.availability_update_message'));
        }
        return \Redirect::to($url)->withFlashSuccess(__('strings.new.availability_insert_message'));
    }

    public function delete(Request $request ,$id=0 )
    {   
        echo $id;
        die("pendiing");
        // $skill = skill::find($id);
        // $avatar ="storage/skills/".$skill->avatar;
        // if($skill->delete())
        //     unlink(public_path($avatar));            
        
  
        return redirect()->route('frontend.user.spskill')
                        ->with('success','Room Booked deleted successfully');
    }
}
