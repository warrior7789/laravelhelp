<?php

namespace App\Http\Controllers\Backend;

use App\Models\Currency;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
// use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Constraint;
// use Intervention\Image\Facades\Image;



class CurrencyController extends Controller
{
    
    
    public function index(Request $request)
    {           
        $Currencys = Currency::latest()->paginate(10);
        $search =array();
        if(($request->get('search'))){
            $query = Currency::query(); 
            $search = $request->get('search');
            
            if(!empty($search['name'])){               
               $query = $query->where('name',' like ',$search['name']);
            }  
            $Currencys = $query->get();
        }


        Breadcrumbs::for('admin.currency', function ($trail) {
            $trail->push(__('strings.new.currency'), route('admin.currency'));
        });
        
         
        return view('backend.currency.index',compact('Currencys','search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function Create(Request $request ,$id=0 ) {
        
        $model = new Currency;
        if(!empty($id)){            
            $model = Currency::find($id);
        }

        Breadcrumbs::for('admin.currency.create', function ($trail) {
            $trail->push(__('strings.new.currency'), route('admin.currency.create'));
        });
        
        return view('backend.currency.create',compact('model','id'));
    }


    public function edit($id){
        $model = Currency::find($id);       

        Breadcrumbs::for('admin.currency.edit', function ($trail,$id) {
            $trail->push(__('strings.new.currency'), route('admin.currency.edit',$id ) );
        });


        return view('backend.currency.create',compact('model','id'));
    }

    

    public function Store(Request $request){

        $data = $this->validate($request, [
            'name'  => 'required',                                     
            'iso_code'  => 'required|max:3',                                     
            'symbol'  => 'required',                                     
        ]);
        $Currency = new Currency();
        
        if(!empty($request->get('id'))){            
            $Currency = Currency::find($request->get('id'));
        }

        $Currency->name       = $request->get('name');
        $Currency->iso_code   = $request->get('iso_code');
        $Currency->symbol     = $request->get('symbol');
        $Currency->status     = ($request->get('status')) ? $request->get('status') : 0;
        $Currency->save();
        
        if(!empty($request->get('id')))      
            return redirect()->route('admin.currency')->withFlashSuccess(__('strings.new.currency_update_message'));

        return redirect()->route('admin.currency')->withFlashSuccess(__('strings.new.currency_insert_message'));
        
    }

    public function destroy($id)
    {   
        $Currency = Currency::find($id);        
        $Currency->delete();
  
        return redirect()->route('admin.currency')
                        ->withFlashSuccess(__('strings.new.delete_message'));
    }

    
}
