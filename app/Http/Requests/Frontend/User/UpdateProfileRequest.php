<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Validation\Rule;
use App\Helpers\Frontend\Auth\Socialite;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   

        // echo $this->id;
        // echo $this->avatar_type;
        // die("ASDfdsaf");
        $validation = array();
        if($this->id){
            //echo $this->is_sp;
            
            $validation['first_name']='required|max:191';
            $validation['last_name']='required|max:191';
            $validation['email']='sometimes| required| email| max:191';
            //$validation['avatar_type']='required|max:2000|'. Rule::in(array_merge(['gravatar', 'storage'], (new Socialite)->getAcceptedProviders()));
            //$validation['avatar_location']= "sometimes|image|max:2000";
            $validation['banner_image']='sometimes|mimes:jpeg,jpg,png';

            if($this->is_sp == 1){
                //$validation['address']= "required";
                $validation['city']= "required";
                $validation['pincode']= "required";
                $validation['country']= "required";
                $validation['state']= "required";
                $validation['phone']='required|numeric';                
            }

            
        }else{
           // echo $this->is_sp;
            $validation['phone']='required|numeric';
            $validation['first_name']='required|max:191';
            $validation['last_name']='required|max:191';
            $validation['email']='sometimes| required| email| max:191';
            //$validation['avatar_type']='required|max:2000|'. Rule::in(array_merge(['gravatar', 'storage'], (new Socialite)->getAcceptedProviders()));
            //$validation['avatar_location']= "sometimes|image|max:2000";

            if($this->is_sp == 1){
                //$validation['address']= "required";
                $validation['city']= "required";
                $validation['pincode']= "required";
                $validation['country']= "required";
                $validation['state']= "required";
                $validation['phone']='required|numeric';
                $validation['banner_image']='sometimes|mimes:jpeg,jpg,png';                
            }
        }

       
        return $validation;
        // return [
        //     'first_name'  => ['required', 'max:191'],
        //     'last_name'  => ['required', 'max:191'],
        //     'email' => ['sometimes', 'required', 'email', 'max:191'],
        //     'avatar_type' => ['required', 'max:2000', Rule::in(array_merge(['gravatar', 'storage'], (new Socialite)->getAcceptedProviders()))],
        //     'avatar_location' => ['sometimes', 'image', 'max:2000'],
            
        // ];
    }
}
