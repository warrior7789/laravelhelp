<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Models\Ads;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $advtisement = Ads::where('pagename','contactus')->where('status',1)->get()->toArray();
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
        return view('frontend.contact',compact('ads'));
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {   

        // Build POST request:
        $recaptcha_url = $_ENV['RECAPTCHA_URL_GOOGLE'];
        $recaptcha_secret = $_ENV['NOCAPTCHA_SECRET'];
        $recaptcha_response = $request->get('recaptcha_response');

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        //echo "<pre>";print_r($recaptcha);echo "</pre>";die("ASDfdas");
        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {            
            Mail::send(new SendContact($request)); 
            return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
        } else {
            // Not verified - show form error
            return redirect()->back()->withFlashDanger(__('strings.new.contact_capcha_fail'));
        }
        
        

        
    }
}
