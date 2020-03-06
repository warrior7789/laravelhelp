<?php

namespace App\Http\Controllers\Frontend\User;

/**
 * Class LanguageController.
 */

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Auth\User;
use App\Events\ChatEvent;

class ChatController extends Controller
{
    /**
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    // public function send(Request $request)
    // {   

    //     $user = Auth::user();
    //     event(new ChatEvent($request->message,$user));
        
    // }


     public function send()
    {   
        $message = "hello 555";
        $user = Auth::user();
        event(new ChatEvent($message,$user));

       // die("ASDF");
        
    }

    function chat(){
        return view('chat');
    }
}
