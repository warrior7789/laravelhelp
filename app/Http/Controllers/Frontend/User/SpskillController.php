<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Spskill;
use App\Models\Skill;
use App\Models\Currency;

use Illuminate\Support\Facades\DB;

use App\Models\Auth\User;
use App\Models\Auth\SocialAccount;

use App\Models\Feedback;

/**
 * Class AccountController.
 */
class SpskillController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$user = Auth::user();
		$Spskills = Spskill::where('user_id',$user->id)->paginate(10);
		return view('frontend.user.skill.index',compact('Spskills'))
			->with('i', (request()->input('page', 1) - 1) * 5);
	}

	public function create(Request $request ,$id='' ) {
		// check if there is already 4 skills or not...
		$my_skills = Spskill::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
		if(($my_skills->count() < env('APP_SKILL_LIMIT')) || $id > 0){
			$skill_id = 0;
			$model = new Spskill;
			$model->status = 1;
			if(!empty($id)){
				$model = Spskill::find($id);
				$skill_id = $model->skill_id;
			}
			
			$skills = array();
			$user = Auth::user();
			if(!empty($user)){
				$userId = $user->id;
				$skills = Skill::SpRemainigSkill($userId,$skill_id);
			}
			$Currency = Currency::GetAll();
			return view('frontend.user.skill.create',compact('model','id','skills','Currency'));
		} else {
			$url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#skill_list';
			return \Redirect::to($url)->withFlashDanger(__('strings.new.skill_more_than_4'));
		}
	}

	public function Store(Request $request){
		if(!empty($request->get('id'))){
			$Spskill = Spskill::find($request->get('id'));
		} else {
			$Spskill = new Spskill();
		}

		if($Spskill->status != 1){
			$my_skills = Spskill::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
			if($my_skills->count() >= env('APP_SKILL_LIMIT') && $request->get('status') == 1){
				$url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#skill_list';
				return \Redirect::to($url)->withFlashDanger(__('strings.new.skill_more_than_4'));
			}
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

		if(empty($request->city) && empty($request->pincode) && empty($request->country) && empty($request->state)){
	        $rules['address']= "required";
	    } else {
	        $rules['city']= "required";
	        // $rules['pincode']= "required";
	        $rules['country']= "required";
	        $rules['state']= "required";
	    }

		$messages = [
			'skill_id.required'          => __('strings.new.please_select_skill'),
			'currency_id.required'       => __('strings.new.please_select_currency'),
			'description.required'       => __('strings.new.skill_desc_cannot_blank'),
			'price_per_hour.required'    => __('strings.new.price_per_hour_cannot_blank'),
			// 'price_per_hour.regex'       => 'Price per hour format is invalid.',
			'price_per_hour.numeric'     => __('strings.new.price_per_hour_must_be_number'),
			'price_per_hour.min'         => __('strings.new.price_per_hour_must_be_at_least_1'),
			'price_per_hour.max'         => __('strings.new.price_per_hour_may_not_be_greater_than_200'),
			'price_per_day.required'     => __('strings.new.price_per_day_cannot_blank'),
			'price_per_day.numeric'      => __('strings.new.price_per_day_must_be_number'),
			'price_per_day.min'          => __('strings.new.price_per_day_must_be_at_least_1'),
			'price_per_day.max'          => __('strings.new.price_per_day_may_not_be_greater_than_200'),
			'show_price.required'        => __('strings.new.please_select_the_show_price'),            
			'offer_discount.numeric'     => __('strings.new.offer_discount_must_be_number'),
			'offer_discount.min'         => __('strings.new.offer_discount_must_be_at_least_1'),
			'offer_discount.max'         => __('strings.new.offer_discount_may_not_be_greater_than_99'),

			'address.required' => __('strings.frontend.profile.address_required'),
            'city.required' => __('strings.frontend.profile.city_required'),
            'pincode.required' => __('strings.frontend.profile.pincode_required'),
            'country.required' => __('strings.frontend.profile.country_required'),
            'state.required' => __('strings.frontend.profile.state_required'),
		];
		$data = $this->validate($request, $rules, $messages);
		if(!empty($request->file('offer_img'))){
			$fileName = time().'.'.request()->offer_img->getClientOriginalExtension();
			$Spskill->offer_img=$fileName;
		}
		
		$user = Auth::user();
		$Spskill->user_id       = $user->id;
		$Spskill->skill_id		= $request->get('skill_id');
		$Spskill->description 	= $request->get('description');
		$Spskill->tags          = $request->get('tags'); // change by bindiya
		$Spskill->price_per_hour= $price_per_hour;
		$Spskill->price_per_day = $price_per_day;
		$Spskill->show_price    = $request->get('show_price');
		$Spskill->currency_id 	= $request->get('currency_id');
		$status 	            = ($request->get('status')) ? $request->get('status') : 0;
		$Spskill->status        = $status;
		
		$Spskill->city        = $request->city;
		$Spskill->state        = $request->state;
		$Spskill->country        = $request->country;
		$Spskill->pincode        = $request->pincode;
		$Spskill->latitude        = $request->latitude;
		$Spskill->longitudes        = $request->longitudes;
		$Spskill->address        = $request->address;

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
		if($Spskill->save()){
			if(!empty($request->file('offer_img'))){
				$dir = public_path().'/storage/spskills/';
				$fileimage = $request->file('offer_img');
				$fileimage->move($dir, $fileName);
			}
		}
		$url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#skill_list';
		if(!empty($request->get('id'))){
			return \Redirect::to($url)->withFlashSuccess(__('strings.new.skill_update_message'));
		}
		return \Redirect::to($url)->withFlashSuccess(__('strings.new.skill_insert_message'));
	}

	public function delete(Request $request, $id=0){
		$skill = Spskill::find($id);
		$offer_img = $skill->offer_img;
		$offer_img_path ="/storage/spskills/".$skill->offer_img;

		if($skill->delete())
			if(file_exists(public_path($offer_img_path)) && $offer_img != "")
				unlink(public_path($offer_img_path));

		$url = \Illuminate\Support\Facades\URL::route('frontend.user.account').'#skill_list';
		return \Redirect::to($url)->withFlashSuccess(__('strings.new.delete_message'));
	}

	public function searchskill($query=""){
		$skills = Skill::autocomplete($query);
		return response()->json(compact('skills'));
	}

	public function allskill($query=""){
		$skills = Skill::allskill();
		return response()->json(compact('skills'));
	}

	public function searchsp(Request $request){
		return response()->json($this->getSearchResults($request, 40));
	}

	public function searchTag(Request $request){
		return response()->json($this->getSearchResults($request, 10));
	}

	public function getSearchResults($request, $per_page_records){
		DB::enableQueryLog();

		$loged = Auth::user();
		$skillid    =$request->get('skillid');
		$skillname    =$request->get('skillname');
		$where    =$request->get('where');
		$street_number    =$request->get('street_number');
		$route    =$request->get('route');
		$city    =$request->get('locality');  //city
		$state    =$request->get('administrative_area_level_1'); //state
		$country    =$request->get('country'); // india
		$postal_code    =$request->get('postal_code');
		$lng    =$request->get('lng');
		$lat    =$request->get('lat');
		$sort_by = $request->get('sort_by');
		$location['latitude']=$lat;
		$location['longitude']=$lng;
		$setting =array();
		$all_tag = json_decode($skillid);
		$my_results = [];
		if(!empty($all_tag) && $all_tag!="null"){
			foreach ($all_tag as $key => $value) {
				$sp_skills_data = DB::table('sp_skill');
				$sp_skills_data->where(['status' => 1]);
				$sp_skills_data->where(function ($main_query) use($value){
					$main_query->whereIn('skill_id', function($query) use($value){
						$query->select('id')->from('skill')->where('name', $value->name);
					});
					$main_query->orWhere('tags', 'LIKE','%'.$value->name.'%');
				});
				$sp_skills_data->whereIn('user_id', function($query){
					$query->select('id')->from('users')->where('is_sp', 1)->where('active', 1);
				});

				if(!empty($city) && $city != "null"){
					$sp_skills_data->where('city', 'LIKE','%'.$city.'%');
				}

				if(!empty($state) && $state!="null"){
					$sp_skills_data->where('state', 'LIKE','%'.$state.'%');
				}

				if(!empty($country) && $country!="null"){
					$sp_skills_data->where('country', 'LIKE','%'.$country.'%');
				}

				if($sp_skills_data->paginate()->count() == 0){
					$sp_new = DB::table('sp_skill');
					$sp_new->where(['status' => 1]);
					$sp_new->where(function ($main_query) use($value){
						$main_query->whereIn('skill_id', function($query) use($value){
							$query->select('id')->from('skill')->where('name', $value->name);
						});
						$main_query->orWhere('tags', 'LIKE','%'.$value->name.'%');
					});
					$sp_new->whereIn('user_id', function($query){
						$query->select('id')->from('users')->where('is_sp', 1)->where('active', 1);
					});
					$haversine = "(6371 * acos(cos(radians(".$location['latitude'].")) * cos(radians(latitude)) * cos(radians(longitudes) - radians(".$location['longitude'].")) + sin(radians(".$location['latitude'].")) * sin(radians(latitude))))";

					$sp_new->whereRaw("{$haversine} < ?", [60]);					
				    // echo $sp_new->toSql(); echo "\n\n";
					$my_results[] = $sp_new->paginate($per_page_records);
				} else {
					// echo $sp_skills_data->toSql(); echo "\n\n";
					$my_results[] = $sp_skills_data->paginate($per_page_records);
				}

				// $my_results[] = $sp_skills_data->paginate($per_page_records);
			}
		}
		$return = [];
		foreach ($my_results as $k => $datas) {
			$setting[$k]['total'] = $datas->total();
			$setting[$k]['perpage'] = $per_page_records;
			
			$result = array();
			if(!empty($datas)){
				$i=0;
				foreach ($datas as $key => $value1) {
					$value = DB::table('sp_skill')
							->select([
								'users.id as user_id',
								'users.first_name',
								'users.last_name',
								'users.email',
								'users.avatar_type',
								'users.avatar_location',
								'users.slug',
								'users.updated_at as updated_at',
								'profile.phone',
								'profile.experience',
								'profile.about',
								'profile.address',
								'profile.city',
								'profile.state',
								'profile.country',
								'profile.pincode',
								'profile.latitude',
								'profile.longitudes',            
								'skill.name as skillname',
								'skill.avatar as skillavatar',
								'currency.symbol as currency',
								'sp_skill.tags', /// change by bindiya
								'sp_skill.description as sp_skill_description',
								'sp_skill.price_per_hour as sp_skill_price_per_hour',
								'sp_skill.price_per_day as sp_skill_price_per_day',
								'sp_skill.show_price as sp_skill_show_price',
								'sp_skill.offer_discount as sp_skill_offer_discount',
								'sp_skill.offer_desc as sp_skill_offer_desc',
								'sp_skill.offer_img as sp_skill_offer_img',
								'sp_skill.offer_start_date as sp_skill_offer_start_date',
								'sp_skill.offer_end_date as sp_skill_offer_end_date',
								'sp_skill.address AS sp_skill_address',
								'sp_skill.city AS sp_skill_city',
								'sp_skill.state AS sp_skill_state',
								'sp_skill.country AS sp_skill_country',
								'sp_skill.pincode AS sp_skill_pincode',
								'sp_skill.latitude AS sp_skill_latitude',
								'sp_skill.longitudes AS sp_skill_longitudes',
							])
							->leftjoin('users', 'users.id', '=', 'sp_skill.user_id')
							->leftjoin('profile', 'profile.user_id', '=', 'sp_skill.user_id')
							->leftjoin('skill', 'skill.id', '=', 'sp_skill.skill_id')        
							->leftjoin('currency', 'currency.id', '=', 'sp_skill.currency_id')  
							->where('users.id', '=',$value1->user_id)
							->where('sp_skill.id', '=',$value1->id)->first();

					if(!empty($value->slug)){
						$userAverageRating = Feedback::user_average_rating($value->user_id);
						$userAverageRating = round($userAverageRating); 
						$user = User::find($value->user_id);
						$isOnline = $user->isOnline();
						$last_login = $user->updated_at->diffForHumans();
						$result[$i]['heading'] = $all_tag[$k];
						$result[$i]['user_id'] = $value->user_id;
						$result[$i]['rating'] = $userAverageRating;
						$result[$i]['isOnline'] = 0;
						$result[$i]['able_to_send_message'] = 0;
					   
						if(!empty($loged)){
							if(!($loged->id == $value->user_id))
								$result[$i]['able_to_send_message'] = 1;
						}

						if($isOnline)
							$result[$i]['isOnline'] = 1;

						if($value->avatar_type == "gravatar"){
							$result[$i]['sp_image']= "/storage/avatars/dummy.png";
						}else if ($value->avatar_type == "storage"){
							if($value->avatar_location){
								$result[$i]['sp_image']="/storage/".$value->avatar_location;                    
							} else {
								$result[$i]['sp_image']= "/storage/avatars/dummy.png";
							}
						}else{
							$social_Account = SocialAccount::where('user_id','=',$value->user_id)->where('provider','=',$value->avatar_type)->first();
							if(!empty($social_Account))
								$result[$i]['sp_image']=$social_Account->avatar;
						}

						$Spskills = Spskill::where('user_id',$value->user_id)->where('status',1)->get();
						if(!empty($Spskills)){
							$j=0;
							foreach ($Spskills as $key => $Spskill) {
								$result[$i]['sp_skill_images'][$j++]="/storage/skills/".$Spskill->skill->avatar;
							}
						}
						$result[$i]['sp_name']=$value->first_name ." ".$value->last_name;
						$result[$i]['sp_about']=$value->about;
						$result[$i]['sp_slug']=$value->slug;
						$result[$i]['sp_last_login']=$last_login;
						$result[$i]['currency']=$value->currency;
						$result[$i]['email']=$value->email;
						$result[$i]['address']=$value->sp_skill_address ? $value->sp_skill_address : $value->address;
						$result[$i]['city']=$value->sp_skill_city ? $value->sp_skill_city : $value->city;
						$result[$i]['state']=$value->sp_skill_state ? $value->sp_skill_state : $value->state;
						$result[$i]['country']=$value->sp_skill_country ? $value->sp_skill_country : $value->country;
						$result[$i]['latitude']=$value->sp_skill_latitude ? $value->sp_skill_latitude : $value->latitude;
						$result[$i]['longitudes']=$value->sp_skill_longitudes ? $value->sp_skill_longitudes : $value->longitudes;
						$result[$i]['phone']=$value->phone;
						$result[$i]['experience']=$value->experience;
						$result[$i]['skillname']=$value->skillname;
						$result[$i]['skillavatar']="/storage/skills/".$value->skillavatar;

						// $result[$i]['sp_skill_description']=$value->sp_skill_description;
						// $result[$i]['sp_skill_price_per_hour']=$value->sp_skill_price_per_hour;
						// $result[$i]['sp_skill_price_per_day']=$value->sp_skill_price_per_day;
						// $result[$i]['sp_skill_show_price']=__("strings.new.".$value->sp_skill_show_price);
						// $result[$i]['sp_skill_offer_discount']=$value->sp_skill_offer_discount;
						// $result[$i]['sp_skill_offer_desc']=$value->sp_skill_offer_desc;
						// $result[$i]['sp_skill_offer_img']="/storage/spskills/".$value->sp_skill_offer_img;
						// $result[$i]['sp_skill_offer_start_date']=$value->sp_skill_offer_start_date;
						// $result[$i]['sp_skill_offer_end_date']=$value->sp_skill_offer_end_date;

						$result[$i]['sp_skill_description']=$value1->description;
						$result[$i]['sp_skill_price_per_hour']=$value1->price_per_hour;
						$result[$i]['sp_skill_price_per_day']=$value1->price_per_day;
						$result[$i]['sp_skill_show_price']=__("strings.new.".$value1->show_price);
						$result[$i]['sp_skill_offer_discount']=$value1->offer_discount;
						$result[$i]['sp_skill_offer_desc']=$value1->offer_desc;
						$result[$i]['sp_skill_offer_img']="/storage/spskills/".$value1->offer_img;
						$result[$i]['sp_skill_offer_start_date']=$value1->offer_start_date;
						$result[$i]['sp_skill_offer_end_date']=$value1->offer_end_date;

						$result[$i]['sp_skill_si_offer']=0;

						// price calculation 
						$now = date("Y-m-d");
						$now = strtotime($now);
						$offer_start = strtotime($value1->offer_start_date);
						$offer_end = strtotime($value1->offer_end_date);
						if($value1->show_price =="hour"){
							$final_price = (float)$value1->price_per_hour;
						}else{
							$final_price = (float)$value1->price_per_day;                        
						}
						$result[$i]['normal_price']=$final_price;
						if($offer_start  <= $now  &&  $now  <= $offer_end){
							$final_price = (float)($final_price - (($final_price *$value1->offer_discount)/100 ) );
							$result[$i]['sp_skill_si_offer']=1;
						}
						$result[$i]['final_price']=$final_price;
						$i++;
					}
				}
			}   

			$price = array();
			$rating_val = array();
			foreach ($result as $key => $row){
				$price[$key] = $row['final_price'];
				$rating_val[$key] = $row['rating'];
			}
			array_multisort($price, SORT_ASC, $result);
			if($sort_by == 'desc_price'){
				array_multisort($price, SORT_DESC, $result);
			}else if($sort_by == 'desc_rating'){
				array_multisort($rating_val, SORT_DESC, $result);
			}else if($sort_by == 'asc_rating'){
				array_multisort($rating_val, SORT_ASC, $result);
			}

			$return[] = $result;
		}

		return compact('return','setting');
	}
}