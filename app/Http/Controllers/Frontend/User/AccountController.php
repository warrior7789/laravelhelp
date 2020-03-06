<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Spskill;
use App\Models\Spavailability;
use App\Models\Photogallary;
use App\Models\Ads;
/**
 * Class AccountController.
 */
class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {	
        $user = Auth::user();
        $Spskills = Spskill::where('user_id',$user->id)->get();
        
        $Spavailability = Spavailability::where('user_id',$user->id)->first();

        $Photogallary = Photogallary::where('user_id',$user->id)->orderBy('id', 'desc')->get();
        $Photogallarycount = Photogallary::where('user_id',$user->id)->count();
        
        $timeslot = array();
        if(!empty($Spavailability)){
            $timeslot = json_decode($Spavailability->timeslot);
        }

        $advtisement = Ads::where('pagename','myaccount')->where('status',1)->get()->toArray();
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

        //die("sdfsaf");
        return view(
                'frontend.user.account',
                compact('Spskills','Spavailability','timeslot','Photogallary','Photogallarycount','ads')
            )
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
