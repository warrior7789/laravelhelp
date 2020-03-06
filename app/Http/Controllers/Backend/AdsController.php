<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\View\View;
use App\Models\Ads;

use Illuminate\Support\Facades\File;

class AdsController extends Controller
{    
    public function index(Request $request)
    {  
        $ads = Ads::orderBy('pagename', 'asc')->paginate(10);        

        Breadcrumbs::for('admin.ads', function ($trail) {
            $trail->push(__('strings.new.ads'), route('admin.ads'));
        });
                 
        return view('backend.ads.index',compact('ads'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function Create(Request $request ,$id='' ) {       
        $model = new Ads();
        $pagenames = array(
            ''=>__('strings.new.select_pagename'),
            'homepage'=>'Home page',
            'aboutus'=>'About Us',
            'servicepage'=>'Service page',
            'contactus'=>'Contact Us',
            'message'=>'Message',
            'userdetailspage'=>'Userdetails page',
            'myaccount'=>'My Account',
            'search'=>'Search',
        );

        $positions = array(
            ''=>__('strings.new.select_position'),
            'top'=>'Top',
            'bottom'=>'Bottom',
            'left'=>'Left',
            'right'=>'Right',            
        );
        
        Breadcrumbs::for('admin.ads.create', function ($trail) {
            $trail->push(__('strings.new.ads'), route('admin.ads.create'));
        });
        
        return view('backend.ads.create',compact('model','id','pagenames','positions'));
    }

    

    public function edit($id){
        
        $model = Ads::find($id);

        $pagenames = array(
            ''=>__('strings.new.select_pagename'),
            'homepage'=>'Home page',
            'aboutus'=>'About Us',
            'servicepage'=>'Service page',
            'contactus'=>'Contact Us',
            'message'=>'Message',
            'userdetailspage'=>'Userdetails page',
            'myaccount'=>'My Account',
            'search'=>'Search',
        );

        $positions = array(
            ''=>__('strings.new.select_position'),
            'top'=>'Top',
            'bottom'=>'Bottom',
            'left'=>'Left',
            'right'=>'Right',            
        );

        Breadcrumbs::for('admin.ads.edit', function ($trail,$id) {
            $trail->push(__('strings.new.ads'), route('admin.ads.edit',$id ) );
        });
        
        return view('backend.ads.create',compact('model','id','pagenames','positions'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    

    public function Store(Request $request){
        
        $rules = [            
            'pagename'        => 'required', 
            'position'        => 'required',            
        ];

        $messages = [            
            'pagename.required'   => 'Please Select Page', 
            'position.required'   => 'Please Select Position', 
        ];
        $data = $this->validate($request, $rules, $messages);


        if(!empty($request->get('id')))
        {            
            $ads = Ads::find($request->get('id'));
        } 
        else 
        { 
            $ads = new Ads();           
        }
        $fileName = "";
        
        $dir = public_path()."/addvs";
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        if(!empty($request->files) && !empty($request->file('image'))) 
        {
            $fileName = time().'.'.request()->image->getClientOriginalExtension();
            $ads->image=$fileName;
        }
        
        $ads->pagename=$request->get('pagename');
        $ads->position=$request->get('position');
        $ads->title=$request->get('title');
        $ads->link=$request->get('link');
        $ads->description=$request->get('description');
        $ads->isgoogle=($request->get('isgoogle')) ? $request->get('isgoogle') : 0;
        $ads->status=($request->get('status')) ? $request->get('status') : 0;

        if($ads->save())
        {
            if(!empty($request->files) && !empty($request->file('image'))) 
            {  
                $fileimage = $request->file('image');                
                $fileimage->move($dir ."/", $fileName); 
                $previous_image = $request->get('previous_image');
                if(!empty($request->get('previous_image')))
                {                    
                    $fpath = 'addvs/'.$previous_image;
                    File::delete($fpath);
                }               
            }
        }


             
        if(!empty($request->get('id')))      
            return redirect()->route('admin.ads')->withFlashSuccess(__('strings.new.update_message'));

        return redirect()->route('admin.ads')->withFlashSuccess(__('strings.new.insert_message'));
        
    }

    public function destroy($id)
    { 
        $ads = Ads::find($id);
        if(!empty($ads))
        {
            $ads_image = $ads->image;
            if($ads->delete())
            {
                if(!empty($ads_image))
                {
                    $fpath = 'addvs/'.$ads_image;
                    File::delete($fpath);
                }

                return redirect()->route('admin.ads')
                        ->withFlashSuccess(__('strings.new.delete_message'));
            }
        }

        return redirect()->route('admin.ads')
                        ->withFlashError(__('strings.new.delete_message'));
       
    }

    
}
