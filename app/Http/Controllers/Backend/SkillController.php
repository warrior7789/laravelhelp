<?php

namespace App\Http\Controllers\Backend;

use App\Models\Skill;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Constraint;
// use Intervention\Image\Facades\Image;



class SkillController extends Controller
{
    
    
    public function index(Request $request)
    {   

        $name="";         

        if(!empty($request->get('name')))
        {
            $name = $request->get('name');           
            
             if(!empty($name)){                
               $Skills = Skill::where('name','like','%'.$name.'%');
               $Skills = $Skills->latest()->paginate(10);
            } 
           
        }
        else
        {
            $Skills = Skill::latest()->paginate(10);
        }

        Breadcrumbs::for('admin.skill', function ($trail) {
            $trail->push(__('strings.new.skill'), route('admin.skill'));
        });
        
         
        return view('backend.skill.index',compact('Skills','name'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function Create(Request $request ,$id=0 ) {
        
        $model = new Skill;
        if(!empty($id)){            
            $model = Skill::find($id);
        }

        Breadcrumbs::for('admin.skill.create', function ($trail) {
            $trail->push(__('strings.new.skill'), route('admin.skill.create'));
        });
        
        return view('backend.skill.create',compact('model','id'));
    }


    public function edit($id){
        $model = Skill::find($id);
        

        Breadcrumbs::for('admin.skill.edit', function ($trail,$id) {
            $trail->push(__('strings.new.skill'), route('admin.skill.edit',$id ) );
        });


        return view('backend.skill.create',compact('model','id'));
    }

    

    public function Store(Request $request){

        $Skill = new skill();
        if(!empty($request->get('id'))){
            $data = $this->validate($request, [
                'name'  => 'required',                                     
            ]);
            $Skill = Skill::find($request->get('id'));
        }else{
            $data = $this->validate($request, [
                'name'  => 'required',
                'avatar' => 'required|file|max:1024',                              
            ]);
        }
        

        if(!empty($request->file('avatar'))){
            $fileName = time().'.'.request()->avatar->getClientOriginalExtension();
            $Skill->avatar=$fileName;
        }

        $Skill->name=$request->get('name');
        $status = ($request->get('status')) ? $request->get('status') : 0;
        $Skill->status=$status;
          
        if($Skill->save())
        {
            if(!empty($request->file('avatar')))
            {
                //$dir = storage_path('app/public/skills/');
                $dir = public_path().'/storage/skills/';
                $fileimage = $request->file('avatar');
                $fileimage->move($dir, $fileName);
                //$request->avatar->storeAs('skills',$fileName);
            }
        }
        
        
        if(!empty($request->get('id')))      
            return redirect()->route('admin.skill')->withFlashSuccess(__('strings.new.skill_update_message'));

        return redirect()->route('admin.skill')->withFlashSuccess(__('strings.new.skill_insert_message'));
        
    }

    public function destroy($id)
    {   
        $skill = skill::find($id);
        $avatar ="storage/skills/".$skill->avatar;
        if($skill->delete())
            unlink(public_path($avatar));            
        
  
        return redirect()->route('admin.skill')
                        ->withFlashSuccess(__('strings.new.delete_message'));
    }

    
}
