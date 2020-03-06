<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
// use Intervention\Image\Constraint;
// use Intervention\Image\Facades\Image;
use App\Models\Sitesettings;



class SitesettingsController extends Controller
{
    
    public function Create(Request $request ,$id=0 ) { 
        $model = new Sitesettings();       
        $sitesettingsData = Sitesettings::get();        
        $sitesettingsData = reset($sitesettingsData);
        
        Breadcrumbs::for('admin.sitesettings.create', function ($trail) {
            $trail->push(__('strings.new.sitesettings'), route('admin.sitesettings.create'));
        });
        
        return view('backend.sitesettings.create',compact('model','sitesettingsData'));
    }

    public function Store(Request $request)
    {
        $sitesettingsData = Sitesettings::get();
        $sitesettingsData = reset($sitesettingsData);

        if(!empty($sitesettingsData))
        {
            Sitesettings::query()->truncate();            
        }

        $input = Input::all();
        
        foreach ($input as $key => $value) {

            if($key != '_token' && $key != 'sitelogo' && $key != 'previous_logo')
            {
                $Sitesettings = new Sitesettings();
                $Sitesettings->fieldname =$key;
                $Sitesettings->fieldvalue =$value;                               
                $Sitesettings->save();                
            }            
        }
        
        $dir = public_path()."/logo";
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $deleted_image = $request->get('previous_logo');

        if(!empty($request->files) && !empty($request->file('sitelogo'))) {
            $filelogo = $request->file('sitelogo');            
            $filename = $filelogo->getClientOriginalName();
            $logo = time().$filename; 
            $Sitesettings = new Sitesettings(); 
            $Sitesettings->fieldname = 'sitelogo';
            $Sitesettings->fieldvalue = $logo; 
            $Sitesettings->save();            
            if(!empty($request->get('previous_logo')))
            {                    
                $fpath = 'logo/'.$deleted_image;
                File::delete($fpath);
            }

            $filelogo->move($dir ."/", $logo);
        }
        else
        {
            $Sitesettings = new Sitesettings();
            $Sitesettings->fieldname = 'sitelogo';
            $Sitesettings->fieldvalue = $deleted_image;
            $Sitesettings->save();
        }       
        
        return redirect()->route('admin.sitesettings.create')->withFlashSuccess('success',__('strings.new.update_message'));
        
    }
        
}
