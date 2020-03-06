<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Photogallary;

/**
 * Class AccountController.
 */
class PhotogallaryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {	
    	$user = Auth::user();
    	$Photogallary = Photogallary::where('user_id',$user->id)->orderBy('id', 'desc')->paginate(10);

        // echo $user->id;
        // echo "<pre>";print_r($Spskills);echo "</pre>";

    	return view('frontend.user.photogallary.index',compact('Photogallary'));
            // ->with('i', (request()->input('page', 1) - 1) * 2);
    }

    public function create(Request $request ,$id =0) {        
              
        $user = Auth::user();
        $model = new Photogallary;            
        if($id > 0){
          $model = Photogallary::find($id);               
        }

              
        return view('frontend.user.photogallary.create',['model' => $model]);
    }

    public function store(Request $request){
       
        if($request->get('id') > 0)
        {
            $rules = [
                'title' => 'required',
                'image' => 'mimes:jpeg,jpg,png',                          
            ];
           
            $messages = [
                'title.required' => __('strings.new.title_required'),                
                'image.mimes' => __('strings.new.image_file_only'),            
            ];
        }
        else
        {
            $rules = [
                'title' => 'required',
                'image' => 'required | mimes:jpeg,jpg,png',                          
            ];
           
            $messages = [
                'title.required' => __('strings.new.title_required'),
                'image.required' => __('strings.new.image_required'),
                'image.mimes' => __('strings.new.image_file_only'),            
            ];
        }

        $data = $this->validate($request, $rules, $messages);

        $avatar = "";
        if(!empty($request->files) && !empty($request->file('image'))) {
            $fileavtar = $request->file('image');
            $ext = $fileavtar->getClientOriginalExtension();
            $filename = $fileavtar->getClientOriginalName();
            $avatar = time().$filename;           
        }
        
        // save record...
        if($request->get('id') > 0)
        {
            // update existing record...
            $Photogallary = Photogallary::find($request->get('id'));            
            $Photogallary->title = $request->get('title');        
            $status = ($request->get('status')) ? $request->get('status') : 0;
            $Photogallary->status = $status;
            $deleted_image = $Photogallary->image;
            if(!empty($avatar))
            {                  
                $Photogallary->image = $avatar;
            }

            $Photogallary->save();
            $dir = public_path()."/images-album/".$Photogallary->user_id;
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }


            if(!empty($request->files) && !empty($request->file('image'))) {
                if($deleted_image != '')
                {                    
                    $fpath = 'images-album/'.$Photogallary->user_id.'/'.$deleted_image;
                    File::delete($fpath);
                }
                $fileavtar->move($dir ."/", $avatar);
            }

            // return redirect()->route('frontend.user.photogallary')->withFlashSuccess(__('strings.new.update_message'));

            $url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#sp_photogallary';
            return \Redirect::to($url)->withFlashSuccess(__('strings.new.update_message'));
            
        }
        else
        {
            // insert new record in users table...
            $Photogallary = new Photogallary();
            $user = Auth::user();
            $Photogallary->user_id = $user->id;
            $Photogallary->title = $request->get('title');        
            $status = ($request->get('status')) ? $request->get('status') : 0;
            $Photogallary->status = $status;
            if(!empty($avatar))
            {                  
                $Photogallary->image = $avatar;                
            }

            $Photogallary->save();
            $dir = public_path()."/images-album/".$Photogallary->user_id;
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }

            if(!empty($request->files) && !empty($request->file('image'))) {
                $fileavtar->move($dir ."/", $avatar);
            }

            // return redirect()->route('frontend.user.photogallary')->withFlashSuccess(__('strings.new.insert_message'));

            $url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#sp_photogallary';
            return \Redirect::to($url)->withFlashSuccess(__('strings.new.insert_message'));
        }

    }

    public function delete(Request $request ,$id=0 ) {
        $model = Photogallary::find($id);
        $deleted_image = $model->image;
        if($deleted_image != '')
        {                    
            $fpath = 'images-album/'.$model->user_id.'/'.$deleted_image;
            File::delete($fpath);
        }
                
        $url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#sp_photogallary';
        if($model->delete()){
            return \Redirect::to($url)->withFlashSuccess(__('strings.new.delete_message'));
        } else {
            return \Redirect::to($url)->withFlashDanger(__('strings.new.delete_message_unsuccess'));
        }        
    }

}
