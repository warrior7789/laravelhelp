<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Constraint;
// use Intervention\Image\Facades\Image;
use App\Models\Skill;
use App\Models\Spskill;
use App\Models\Auth\User;
use App\Models\Currency;


class SpskillController extends Controller
{
    
    
    public function index(Request $request)
    {          
        $spskill = Spskill::latest()->paginate(10);
        $search =array();        

        Breadcrumbs::for('admin.spskill', function ($trail) {
            $trail->push(__('strings.new.spskill'), route('admin.spskill'));
        });
        
         
        return view('backend.spskill.index',compact('spskill','search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function Create(Request $request ,$userid=0) {
    
        $id='';
        $model = new Spskill;
        if(!empty($id)){            
            $model = Spskill::find($id);
        }
        $user = User::GetAll();        
        $Currency = Currency::GetAll();
        
        
        $skill_id=0;
        $skills = Skill::SpRemainigSkill($userid,$skill_id);

        Breadcrumbs::for('admin.spskill.create', function ($trail,$userid) {
            $trail->push(__('strings.new.spskill'), route('admin.spskill.create',$userid));
        });
        //echo "DSF";die;
        return view('backend.spskill.create',compact('model','id','skills','Currency','user','userid'));
    }

    public function spremainingSkill(Request $request)
    {        
        $userid=$request->get('userid');        
        $skill_id=0;
        $skills = Skill::SpRemainigSkill($userid,$skill_id);
        $html = ''; 
        if(!empty($skills))
        {
            $html = $html.'<select class="form-control" name="skill_id">';
            $i=0;
            foreach ($skills as $key => $value) {
                if($i==0)
                {
                    $html = $html.'<option value="'.$key.'" selected="selected">'.$value.'</option>';
                }
                else
                {
                    $html = $html.'<option value="'.$key.'">'.$value.'</option>';
                }
            $i++;
            }
            $html = $html.'</select>';
        }    
        
        echo $html;die;
    }


    public function edit($id){

        $model = Spskill::find($id);
        $skill_id = $model->skill_id;
        $userid = $model->user_id;
        $skills = Skill::SpRemainigSkill($userid,$skill_id);
        $user = User::GetAll();        
        $Currency = Currency::GetAll();

        Breadcrumbs::for('admin.spskill.edit', function ($trail,$id) {
            $trail->push(__('strings.new.spskill'), route('admin.spskill.edit',$id ) );
        });
        
        return view('backend.spskill.create',compact('model','id','skills','Currency','user','userid'));
    }

    

    public function Store(Request $request){

        if(!empty($request->get('id'))){
            $Spskill = Spskill::find($request->get('id'));
        } else {
            $Spskill = new Spskill();
        }

       if($request->get('show_price') == "day"){
            $rules = [
                'skill_id'          => 'required',
                'description'       => 'required',
                'price_per_day'     => 'required|numeric|min:1',
                'show_price'        => 'required',
                'currency_id'       => 'required', 
            ];
            $price_per_hour = 0;
            $price_per_day = $request->get('price_per_day');
        } else {
            $rules = [
                'skill_id'          => 'required',
                'description'       => 'required',
                'price_per_hour'    => 'required|numeric|min:1',
                'show_price'        => 'required',
                'currency_id'       => 'required', 
            ];
            $price_per_hour = $request->get('price_per_hour');
            $price_per_day = 0;
        }

        if(!empty($request->get('offer_discount'))){
            $rules['offer_discount'] = 'required|numeric|min:1|max:99.99';
            $rules['offer_start_date'] = 'required|date';
            $rules['offer_end_date'] = 'required|date|after:offer_start_date';
            $rules['offer_img']      = 'mimes:jpeg,jpg,png'; 
        }

        $messages = [            
            'skill_id.required'          => 'Please select a skill.',
            'currency_id.required'       => 'Please select a currency.',
            'description.required'       => 'Skill description cannot be blank.',
            'price_per_hour.required'    => 'Price per hour cannot be blank.',
            // 'price_per_hour.regex'       => 'Price per hour format is invalid.',
            'price_per_hour.numeric'     => 'Price per hour must be a number.',
            'price_per_hour.min'         => 'Price per hour must be at least 1.',
            'price_per_hour.max'         => 'Price per hour may not be greater than 200.',            
            'price_per_day.required'     => 'Price per day cannot be blank.',
            'price_per_day.numeric'      => 'Price per day must be a number.',
            'price_per_day.min'          => 'Price per day must be at least 1.',
            'price_per_day.max'          => 'Price per day may not be greater than 200.',
            'show_price.required'        => 'Please select the show price.',            
            'offer_discount.numeric'     => 'Offer discount must be a number.',
            'offer_discount.min'         => 'Offer discount must be at least 1.',
            'offer_discount.max'         => 'Offer discount may not be greater than 99.99.',
        ];
        $data = $this->validate($request, $rules, $messages);
        if(!empty($request->file('offer_img'))){
            $fileName = time().'.'.request()->offer_img->getClientOriginalExtension();
            $Spskill->offer_img=$fileName;
        }
        
        $Spskill->user_id       = $request->get('user_id');
        $Spskill->skill_id      = $request->get('skill_id');
        $Spskill->description   = $request->get('description');
        $Spskill->tags          = $request->get('tags'); // change by bindiya
        $Spskill->price_per_hour= $price_per_hour;
        $Spskill->price_per_day = $price_per_day;
        $Spskill->show_price    = $request->get('show_price');
        $Spskill->currency_id   = $request->get('currency_id');
        $status                 = ($request->get('status')) ? $request->get('status') : 0;
        $Spskill->status        = $status;
        
        if(!empty($request->get('offer_discount'))){
            $Spskill->offer_discount = $request->get('offer_discount');           
            $Spskill->offer_desc = $request->get('offer_desc');           
            $Spskill->offer_start_date    = $request->get('offer_start_date');
            $Spskill->offer_end_date    = $request->get('offer_end_date');
        }else{
            if(!empty($Spskill->id)){

                $Spskill->offer_discount    = NULL;           
                $Spskill->offer_start_date  = NULL;
                $Spskill->offer_end_date    = NULL;                
                $Spskill->offer_desc    = NULL;   
                if(!empty($Spskill->offer_img)){
                    $offer_img ="storage/spskills/".$Spskill->offer_img;
                    if(file_exists($offer_img))
                        unlink(public_path($offer_img)); 

                }             
                
                $Spskill->offer_img = NULL;
            }
        }
          
        if($Spskill->save())
        {
            if(!empty($request->file('offer_img')))
            {                
                //$dir = storage_path('app/public/spskills/');
                $dir = public_path().'/storage/spskills/';
                $fileimage = $request->file('offer_img');
                $fileimage->move($dir, $fileName);
                //$request->offer_img->storeAs('spskills',$fileName);
            }
        }
        

        if(!empty($request->get('id')))      
            return redirect()->route('admin.serviceprovider.edit',$request->get('user_id'))->withFlashSuccess(__('strings.new.skill_update_message'));

        return redirect()->route('admin.serviceprovider.edit',$request->get('user_id'))->withFlashSuccess(__('strings.new.skill_insert_message'));
        
    }

    public function destroy($id)
    {  
        $skill = Spskill::find($id);
        $userid = $skill->user_id;
        $offer_img = $skill->offer_img;
        $offer_img_path ="/storage/spskills/".$skill->offer_img;

        //die(public_path($avatar));
        if($skill->delete())
            if(file_exists(public_path($offer_img_path)) && $offer_img != "")
                    unlink(public_path($offer_img_path));   
                               
        
  
        return redirect()->route('admin.serviceprovider.edit',$userid)
                        ->withFlashSuccess(__('strings.new.delete_message'));
       
    }

    
}
