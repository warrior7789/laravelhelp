@extends('backend.layouts.app')

@section('page_title',__('strings.new.spskill'))



@section('content')


    <h1 class="page-title">
        {{ $model->id ? __('strings.new.edit_serviceprovider'):__('strings.new.add_new_serviceprovider') }}
    </h1>
    <div class="page-content container-fluid seboX">


        <div class="row">
            
            <div class="col-md-12 skill-table">
                <h2>Service Provider Profile :</h2>
                {{ Form::model($model, array('route' => array('admin.serviceprovider.create') ,'files' => true )) }}
                <div class="row">
                    {{ Form::hidden('id') }}
                    {{-- {{ Form::hidden('slug') }} --}}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                            <label for="first_name">@lang('validation.attributes.frontend.first_name')</label>
                            {{ Form::text('first_name' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            {!! $errors->first('first_name', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                            <label for="email">@lang('validation.attributes.frontend.email')</label>
                            {{ Form::text('email' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            {!! $errors->first('email', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label class="form-check-label" for="avatar_location">
                                @lang('validation.attributes.frontend.avatar')
                            </label>
                            <input type="file" name="avatar_location" id="avatar_location_file">
                            <input type="hidden" name="avatar_type" id="avatar_type" value="storage" />
                            <input type="hidden" id="avatar_image" name="avatar_image">
                            <input type="hidden" id="previous_avtar_image" name="previous_avtar_image" value="{{ $model->avatar_location }}">
                            @if((!empty($model->avatar_location)) && (!empty($model->avatar_type)))
                                @if($model->avatar_type=='storage')
                                    <img style="height: 120px;width: 120px;" src="/storage/{{ $model->avatar_location }}">
                                @endif
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="about">@lang('strings.new.about')</label>
                            @if(!empty($model->Profile->about))
                            {{ Form::textarea('about', $value = $model->Profile->about, $attributes = array('class' => 'form-control','rows' => 4) ) }}
                            @else
                            {{ Form::text('about' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="city">@lang('strings.new.city')</label>
                            @if(!empty($model->Profile->city))
                            {{ Form::text('city' ,$value = $model->Profile->city, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('city' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                        
                        </div>

                        <div class="form-group">
                            <label for="country">@lang('strings.new.country')</label>
                            @if(!empty($model->Profile->country))
                            {{ Form::text('country' ,$value = $model->Profile->country, $attributes = array('class' => 'form-control')) }} 
                            @else
                            {{ Form::text('country' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                       
                        </div>

                        <div class="form-group">
                            <label for="latitude">@lang('strings.new.latitude')</label>
                            @if(!empty($model->Profile->latitude))
                            {{ Form::text('latitude' ,$value = $model->Profile->latitude, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('latitude' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                      
                        </div>

                        <div class="form-group">
                            <label for="facebook">@lang('strings.new.social_media_facebook')</label>
                            @if(!empty($model->Profile->facebook))
                            {{ Form::text('facebook' ,$value = $model->Profile->facebook, $attributes = array('class' => 'form-control')) }} 
                            @else
                            {{ Form::text('facebook' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                       
                        </div>

                        <div class="form-group">
                            <label for="linkedin">@lang('strings.new.social_media_linkedin')</label>
                            @if(!empty($model->Profile->linkedin))
                            {{ Form::text('linkedin' ,$value = $model->Profile->linkedin, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('linkedin' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                        
                        </div>

                        <div class="form-check">
                            {{ Form::checkbox('active', '1',null , $attributes = array('class' => 'form-check-input')  ) }}
                            <label class="form-check-label" for="active">
                                &nbsp; @lang('strings.new.status')
                            </label>                        
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                            <label for="last_name">@lang('validation.attributes.frontend.last_name')</label>
                            {{ Form::text('last_name' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            {!! $errors->first('last_name', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>
                         
                         <div class="form-group">
                            <label for="phone">@lang('strings.new.phone')</label>
                            @if(!empty($model->Profile->phone))
                            {{ Form::text('phone' ,$value = $model->Profile->phone, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('phone' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                        
                        </div>

                        <div class="form-group">
                            <div class="row preview" >
                                <div class="col-md-12 text-center upload-demo" style="display: none">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div id="upload-demo" ></div>                        
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="upload-image" style="margin-top:2%">crope</button>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-12 preview-crop-image" style="display: none;" >
                                    <div id="preview-crop-image" ></div>
                                </div>
                            </div>        
                        </div>

                        <div class="form-group">
                            <label class="form-check-label" for="banner_image">
                                @lang('strings.new.banner_image')
                            </label>
                            {{ Form::file('banner_image') }} 
                            <input type="hidden" id="previous_banner_image" name="previous_banner_image" value="{{ $model->Profile->banner_image }}">
                            @if((!empty($model->Profile->banner_image)) && (!empty($model->Profile->user_id)))
                                <img style="height: 100px;width: 100px;" src="/spbanner/{{$model->Profile->user_id }}/{{ $model->Profile->banner_image }}">
                            @endif                       
                        </div>

                        <div class="form-group">
                            <label for="address">@lang('strings.new.complete_address')</label>
                            @if(!empty($model->Profile->address))
                            {{ Form::textarea('address', $value = $model->Profile->address, $attributes = array('class' => 'form-control','rows' => 4) ) }}
                            @else
                            {{ Form::textarea('address', $value = null, $attributes = array('class' => 'form-control','rows' => 4) ) }}
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="state">@lang('strings.new.state')</label>
                            @if(!empty($model->Profile->state))
                            {{ Form::text('state' ,$value = $model->Profile->state, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('state' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                       
                        </div>

                        <div class="form-group">
                            <label for="pincode">@lang('strings.new.zip_code')</label>
                            @if(!empty($model->Profile->pincode))
                            {{ Form::text('pincode' ,$value = $model->Profile->pincode, $attributes = array('class' => 'form-control')) }} 
                            @else
                            {{ Form::text('pincode' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                      
                        </div>

                        <div class="form-group">
                            <label for="longitudes">@lang('strings.new.longitudes')</label>
                            @if(!empty($model->Profile->longitudes))
                            {{ Form::text('longitudes' ,$value = $model->Profile->longitudes, $attributes = array('class' => 'form-control')) }} 
                            @else
                            {{ Form::text('longitudes' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                       
                        </div>

                        <div class="form-group">
                            <label for="twitter">@lang('strings.new.social_media_twitter')</label>
                            @if(!empty($model->Profile->twitter))
                            {{ Form::text('twitter' ,$value = $model->Profile->twitter, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('twitter' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                       
                        </div>

                        <div class="form-group">
                            <label for="instagram">@lang('strings.new.social_media_instagram')</label>
                            @if(!empty($model->Profile->instagram))
                            {{ Form::text('instagram' ,$value = $model->Profile->instagram, $attributes = array('class' => 'form-control')) }}
                            @else
                            {{ Form::text('instagram' ,$value = null, $attributes = array('class' => 'form-control')) }}
                            @endif                        
                        </div>    
                    </div>
                </div>                
                <div class="row">
                    <?php $i=1; ?>
                    @if(!empty($model->Spskill))
                        @foreach($model->Spskill as $sskill)                        
                        @php
                            $skills=(new \App\Helpers\Frontend\Sproskill)->SpRemainigSkill($sskill->user_id,$sskill->skill_id);
                        @endphp
                        <div class="col-md-12">  
                            <h2>Service Provider Skill :</h2>
                            <div class="row">  
                                <input type="hidden" name="sp_skill_id{{ $i }}" value="{{ $sskill->id }}">                   
                                <div class="col-md-6">                            
                                    @if(!empty($sskill->skill_id))
                                        <div class="form-group {{ $errors->has('skill_id') ? 'has-error' : ''}}">
                                            <label for="skill_id{{ $i }}">@lang('strings.new.select_skill')</label>
                                            <div class="skill_select_box">
                                            {{ Form::select('skill_id'.$i, $skills, $value = $sskill->skill_id, $attributes = array('class' => 'form-control') ) }}
                                            {!! $errors->first('skill_id'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                            </div>                                    
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('skill_id') ? 'has-error' : ''}}">
                                            <label for="skill_id{{ $i }}">@lang('strings.new.select_skill')</label>
                                            <div class="skill_select_box">
                                            {{ Form::select('skill_id'.$i, $skills, $value = null, $attributes = array('class' => 'form-control') ) }}
                                            {!! $errors->first('skill_id'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                            </div>                                    
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->description))
                                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                            <label for="description{{ $i }}">@lang('strings.new.description')</label>
                                            {{ Form::textarea('description'.$i, $value = $sskill->description, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                                            {!! $errors->first('description'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                            <label for="description{{ $i }}">@lang('strings.new.description')</label>
                                            {{ Form::textarea('description'.$i, $value = null, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                                            {!! $errors->first('description'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->price_per_hour))
                                        <div class="form-group {{ $errors->has('price_per_hour') ? 'has-error' : ''}}">
                                            <label for="price_per_hour{{ $i }}">@lang('strings.new.Price_per_hour')</label>
                                            {{ Form::text('price_per_hour'.$i ,$value = $sskill->price_per_hour, $attributes = array('class' => 'form-control')) }}
                                            {!! $errors->first('price_per_hour'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('price_per_hour') ? 'has-error' : ''}}">
                                            <label for="price_per_hour{{ $i }}">@lang('strings.new.Price_per_hour')</label>
                                            {{ Form::text('price_per_hour'.$i ,$value = null, $attributes = array('class' => 'form-control')) }}
                                            {!! $errors->first('price_per_hour'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->price_per_day))
                                        <div class="form-group {{ $errors->has('price_per_day') ? 'has-error' : ''}}">
                                            <label for="price_per_day{{ $i }}">@lang('strings.new.Price_per_day')</label>
                                            {{ Form::text('price_per_day'.$i,$value = $sskill->price_per_day, $attributes = array('class' => 'form-control') ) }}
                                            {!! $errors->first('price_per_day'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('price_per_day') ? 'has-error' : ''}}">
                                            <label for="price_per_day{{ $i }}">@lang('strings.new.Price_per_day')</label>
                                            {{ Form::text('price_per_day'.$i,$value = null, $attributes = array('class' => 'form-control') ) }}
                                            {!! $errors->first('price_per_day'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->currency_id))
                                        <div class="form-group {{ $errors->has('currency_id') ? 'has-error' : ''}}">
                                            <label for="currency_id{{ $i }}">@lang('strings.new.select_currency')</label>
                                            {{ Form::select('currency_id'.$i, $Currency, $value = $sskill->currency_id, $attributes = array('class' => 'form-control') ) }}
                                            {!! $errors->first('currency_id'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('currency_id') ? 'has-error' : ''}}">
                                            <label for="currency_id{{ $i }}">@lang('strings.new.select_currency')</label>
                                            {{ Form::select('currency_id'.$i, $Currency, $value = null, $attributes = array('class' => 'form-control') ) }}
                                            {!! $errors->first('currency_id'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->show_price))
                                        <div class="form-group {{ $errors->has('show_price') ? 'has-error' : ''}}">
                                            <label for="show_price{{ $i }}">@lang('strings.new.show_price')</label>
                                            <div class="radio"> 
                                                <label><input type="radio" name="show_price{{ $i }}" value="hour" <?php if($sskill->show_price=='hour'){ ?> checked="checked" <?php } ?>>@lang('strings.new.hour')</label>

                                                <label><input type="radio" name="show_price{{ $i }}" value="day" <?php if($sskill->show_price=='day'){ ?> checked="checked" <?php } ?>>@lang('strings.new.day')</label>                            
                                            </div>               
                                            {!! $errors->first('show_price'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('show_price') ? 'has-error' : ''}}">
                                            <label for="show_price{{ $i }}">@lang('strings.new.show_price')</label>
                                            <div class="radio">
                                                <label>{{ Form::radio('show_price'.$i, 'hour') }}@lang('strings.new.hour')</label>
                                           
                                                <label>{{ Form::radio('show_price'.$i, 'day') }}@lang('strings.new.day')</label>
                                            </div>               
                                            {!! $errors->first('show_price'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->offer_discount))
                                        <div class="form-group {{ $errors->has('offer_discount') ? 'has-error' : ''}}">
                                            <label for="offer_discount{{ $i }}">@lang('strings.new.offer_discount')</label>
                                            {{ Form::text('offer_discount'.$i ,$value = $sskill->offer_discount, $attributes = array('class' => 'form-control')) }}
                                            {!! $errors->first('offer_discount'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('offer_discount') ? 'has-error' : ''}}"> 
                                            <label for="offer_discount{{ $i }}">@lang('strings.new.offer_discount')</label>
                                            {{ Form::text('offer_discount'.$i ,$value = null, $attributes = array('class' => 'form-control')) }}
                                            {!! $errors->first('offer_discount'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->offer_desc))
                                        <div class="form-group {{ $errors->has('offer_desc') ? 'has-error' : ''}}">
                                            <label for="offer_desc{{ $i }}">@lang('strings.new.offer_desc')</label>
                                            {{ Form::textarea('offer_desc'.$i ,$value = $sskill->offer_desc, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                                            {!! $errors->first('offer_desc'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('offer_desc') ? 'has-error' : ''}}">
                                            <label for="offer_desc{{ $i }}">@lang('strings.new.offer_desc')</label>
                                            {{ Form::textarea('offer_desc'.$i ,$value = null, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                                            {!! $errors->first('offer_desc'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->offer_start_date))
                                        <div class="form-group {{ $errors->has('offer_start_date') ? 'has-error' : ''}}">
                                            <label for="offer_start_date{{ $i }}">@lang('strings.new.offer_start_date')</label>
                                            {{ Form::text('offer_start_date'.$i ,$value = $sskill->offer_start_date, $attributes = array('class' => 'form-control date','id' => 'offer_start_date'.$i)) }}
                                            {!! $errors->first('offer_start_date'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('offer_start_date') ? 'has-error' : ''}}">
                                            <label for="offer_start_date{{ $i }}">@lang('strings.new.offer_start_date')</label>
                                            {{ Form::text('offer_start_date'.$i ,$value = null, $attributes = array('class' => 'form-control date','id' => 'offer_start_date'.$i)) }}
                                            {!! $errors->first('offer_start_date'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->offer_end_date))
                                        <div class="form-group {{ $errors->has('offer_end_date') ? 'has-error' : ''}}">
                                            <label for="offer_end_date{{ $i }}">@lang('strings.new.offer_end_date')</label>
                                            {{ Form::text('offer_end_date'.$i ,$value = $sskill->offer_end_date, $attributes = array('class' => 'form-control date','id' => 'offer_end_date'.$i)) }}
                                            {!! $errors->first('offer_end_date'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('offer_end_date') ? 'has-error' : ''}}">
                                            <label for="offer_end_date{{ $i }}">@lang('strings.new.offer_end_date')</label>
                                            {{ Form::text('offer_end_date'.$i ,$value = null, $attributes = array('class' => 'form-control date','id' => 'offer_end_date'.$i)) }}
                                            {!! $errors->first('offer_end_date'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->offer_img))
                                        <div class="form-group {{ $errors->has('offer_img') ? 'has-error' : ''}}">
                                            <label class="form-check-label" for="offer_img{{ $i }}">
                                                @lang('strings.new.offer_img')
                                            </label>
                                            <input type="file" name="offer_img{{ $i }}">
                                            {!! $errors->first('offer_img'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}                                            
                                            <img style="height: 100px;width: 100px;" src="/storage/spskills/{{ $sskill->offer_img }}">
                                        </div>
                                    @else
                                        <div class="form-group {{ $errors->has('offer_img') ? 'has-error' : ''}}">
                                            <label class="form-check-label" for="offer_img{{ $i }}">
                                                @lang('strings.new.offer_img')
                                            </label>
                                            <input type="file" name="offer_img{{ $i }}">
                                            {!! $errors->first('offer_img'.$i, '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @if(!empty($sskill->status))
                                        <div class="form-check {{ $errors->has('status') ? 'has-error' : ''}}">
                                            <input type="checkbox" name="status{{ $i }}" class="form-check-input" <?php if($sskill->status=='1'){ ?> checked="checked" <?php } ?>>                                    
                                            <label class="form-check-label" for="status{{ $i }}">
                                                &nbsp; @lang('strings.new.status')
                                            </label>
                                            <p>{!! $errors->first('status'.$i, '<p class="help-block help-block-error 
                                            text-danger">:message</p>') !!}
                                            </p>
                                        </div>
                                    @else
                                        <div class="form-check {{ $errors->has('status') ? 'has-error' : ''}}">
                                            <input type="checkbox" name="status{{ $i }}" class="form-check-input">
                                            <label class="form-check-label" for="status{{ $i }}">
                                                &nbsp; @lang('strings.new.status')
                                            </label>
                                            <p>{!! $errors->first('status'.$i, '<p class="help-block help-block-error 
                                            text-danger">:message</p>') !!}
                                            </p>
                                        </div>
                                    @endif

                                </div>

                            </div>  
                        </div> 
                        <?php $i++;?>                       
                        @endforeach
                    @endif               
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- <div class="float-right"> --}}
                        <input type="hidden" name="total_skill" value="{{ $i-1 }}">
                        {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-success upd-btn')) }}
                                <a href="{{ route('admin.serviceprovider') }}" class="btn btn-danger  upd-btn"> @lang('strings.new.cancel')</a>
                        {{ Form::close() }}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@stop

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="/css/croppie.css">
    <style type="text/css">
       
    </style>
@endpush

@push('after-scripts')
<script type="text/javascript" src="/js/croppie.js"></script>
    <script>
    $('#user_id').on('change', function() {
        var userid = $('#user_id').val();       
        $.ajax({
            url: "{{ route('admin.spskill.spremainingSkill') }}",            
            data: { userid : userid },
            dataType: "html",
            success: function(result)
            {
                $(".skill_select_box").html(result);
            }
        });
    });

    var resize = $('#upload-demo').croppie({
        enableExif: true,
        enableOrientation: true,    
        viewport: { // Default { width: 100, height: 100, type: 'square' } 
            width: 250,
            height: 250,
            type: 'circle' //square
        },
        boundary: {
            width: 300,
            height: 300
        }
    });


    $('#avatar_location_file').on('change', function () { 
        $(".upload-demo").show();            
        $(".preview-crop-image").hide();
      var reader = new FileReader();
        reader.onload = function (e) {
          resize.croppie('bind',{
            url: e.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
    });


    $('.upload-image').on('click', function (ev) {
      resize.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function (img) {            
        html = '<img src="' + img + '" />';
        $("#preview-crop-image").html(html);
        $("#preview-crop-image").show();
        $(".upload-demo").hide();            
        $(".preview-crop-image").show();
        $("#avtar_image").val(img);
        
      });
    });
    </script>
    <script>    
    $( document ).ready(function() {    
        $('.date').datepicker({  

          dateFormat: 'yy-mm-dd'

        }); 
    });
    </script>
@endpush
