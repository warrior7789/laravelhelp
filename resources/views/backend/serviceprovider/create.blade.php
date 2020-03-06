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
                                <label for="phone">@lang('strings.new.phone')</label>
                                @if(!empty($model1->phone))
                                {{ Form::text('phone' ,$value = $model1->phone, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('phone' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                        
                            </div>

                            <div class="form-group">
                                <label class="form-check-label" for="avatar_location">
                                    @lang('validation.attributes.frontend.avatar')
                                </label>
                                <input type="file" name="avatar_location" id="avatar_location_file">
                                <input type="hidden" name="avatar_type" id="avatar_type" value="storage" />
                                <input type="hidden" id="avatar_image" name="avatar_image">
                                <input type="hidden" id="previous_avatar_image" name="previous_avatar_image" value="{{ $model->avatar_location }}">
                                @if((!empty($model->avatar_location)) && (!empty($model->avatar_type)))
                                    @if($model->avatar_type=='storage')
                                        <img style="height: 120px;width: 120px;" src="/storage/{{ $model->avatar_location }}">
                                    @endif
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="address">@lang('strings.new.complete_address')</label>
                                @if(!empty($model1->address))
                                {{ Form::textarea('address', $value = $model1->address, $attributes = array('class' => 'form-control','rows' => 4) ) }}
                                @else
                                {{ Form::textarea('address', $value = null, $attributes = array('class' => 'form-control','rows' => 4) ) }}
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="city">@lang('strings.new.city')</label>
                                @if(!empty($model1->city))
                                {{ Form::text('city' ,$value = $model1->city, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('city' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                        
                            </div>

                            <div class="form-group">
                                <label for="country">@lang('strings.new.country')</label>
                                @if(!empty($model1->country))
                                {{ Form::text('country' ,$value = $model1->country, $attributes = array('class' => 'form-control')) }} 
                                @else
                                {{ Form::text('country' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                       
                            </div>

                            <div class="form-group">
                                <label for="latitude">@lang('strings.new.latitude')</label>
                                @if(!empty($model1->latitude))
                                {{ Form::text('latitude' ,$value = $model1->latitude, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('latitude' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                      
                            </div>

                            <div class="form-group">
                                <label for="facebook">@lang('strings.new.social_media_facebook')</label>
                                @if(!empty($model1->facebook))
                                {{ Form::text('facebook' ,$value = $model1->facebook, $attributes = array('class' => 'form-control')) }} 
                                @else
                                {{ Form::text('facebook' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                       
                            </div>

                            <div class="form-group">
                                <label for="linkedin">@lang('strings.new.social_media_linkedin')</label>
                                @if(!empty($model1->linkedin))
                                {{ Form::text('linkedin' ,$value = $model1->linkedin, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('linkedin' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                        
                            </div>

                            <div class="form-check">
                                {{ Form::checkbox('active', '1',1 , $attributes = array('class' => 'form-check-input')  ) }}
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
                            @if(empty($model->id))                            
                            <div class="form-group">
                                <label for="password">@lang('validation.attributes.frontend.password')</label>
                                <input type="password" name="password" class="form-control" required="required">
                            </div>
                            @endif                          

                            <div class="form-group">
                                <label for="experience">@lang('strings.new.experience')</label>
                                @if(!empty($model1->experience))
                                {{ Form::text('experience' ,$value = $model1->experience, $attributes = array('class' => 'form-control allownumericwithoutdecimal')) }}
                                @else
                                {{ Form::text('experience' ,$value = null, $attributes = array('class' => 'form-control allownumericwithoutdecimal')) }}
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
                                @if(!empty($model1->banner_image))
                                    <input type="hidden" id="previous_banner_image" name="previous_banner_image" value="{{ $model1->banner_image }}">
                                @else
                                    <input type="hidden" id="previous_banner_image" name="previous_banner_image" value="">
                                @endif
                                @if((!empty($model1->banner_image)) && (!empty($model1->user_id)))
                                    <img style="height: 100px;width: 100px;" src="/spbanner/{{$model1->user_id }}/{{ $model1->banner_image }}">
                                @endif                       
                            </div>

                            

                            <div class="form-group">
                                <label for="state">@lang('strings.new.state')</label>
                                @if(!empty($model1->state))
                                {{ Form::text('state' ,$value = $model1->state, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('state' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                       
                            </div>

                            <div class="form-group">
                                <label for="pincode">@lang('strings.new.zip_code')</label>
                                @if(!empty($model1->pincode))
                                {{ Form::text('pincode' ,$value = $model1->pincode, $attributes = array('class' => 'form-control')) }} 
                                @else
                                {{ Form::text('pincode' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                      
                            </div>

                            <div class="form-group">
                                <label for="longitudes">@lang('strings.new.longitudes')</label>
                                @if(!empty($model1->longitudes))
                                {{ Form::text('longitudes' ,$value = $model1->longitudes, $attributes = array('class' => 'form-control')) }} 
                                @else
                                {{ Form::text('longitudes' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                       
                            </div>

                            <div class="form-group">
                                <label for="about">@lang('strings.new.about')</label>
                                @if(!empty($model1->about))
                                {{ Form::textarea('about', $value = $model1->about, $attributes = array('class' => 'form-control','rows' => 4) ) }}
                                @else
                                {{ Form::textarea('about' ,$value = null, $attributes = array('class' => 'form-control','rows' => 4)) }}
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="twitter">@lang('strings.new.social_media_twitter')</label>
                                @if(!empty($model1->twitter))
                                {{ Form::text('twitter' ,$value = $model1->twitter, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('twitter' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                       
                            </div>

                            <div class="form-group">
                                <label for="instagram">@lang('strings.new.social_media_instagram')</label>
                                @if(!empty($model1->instagram))
                                {{ Form::text('instagram' ,$value = $model1->instagram, $attributes = array('class' => 'form-control')) }}
                                @else
                                {{ Form::text('instagram' ,$value = null, $attributes = array('class' => 'form-control')) }}
                                @endif                        
                            </div>    
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div class="float-right"> --}}
                            {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-success upd-btn')) }}
                                    <a href="{{ route('admin.serviceprovider') }}" class="btn btn-danger  upd-btn"> @lang('strings.new.cancel')</a>
                            {{ Form::close() }}
                            {{-- </div> --}}
                        </div>
                    </div>
                {{ Form::close() }}
                @if(!empty($spskill))                
                <div class="row" style="margin-top: 3%;">
                    <div class="col-md-12">
                        <div class="float-left">
                            <h2>Service Provider Skill: </h2>
                        </div>
                        <div class="float-right rightA">
                            <a class="btn btn-success" href="{{ route('admin.spskill.create',$id) }}"> @lang('strings.new.skill_add_new')</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                       <table class="table table-bordered skilltable">
                            <tr>
                                <th>@lang('strings.new.no')</th>
                                <th>@lang('strings.new.skill')</th>            
                                <th>@lang('strings.new.price')</th>            
                                <th>@lang('strings.new.status')</th>
                                
                                <th width="280px">@lang('strings.new.action')</th>
                            </tr>
                            @foreach ($spskill as $spskl)
                            <tr>
                                <td>{{ ++$i }} </td>
                                <td>{{ $spskl->Skill->name}}</td>
                                <td>
                                    @if($spskl->show_price =="hour")
                                        {{ $spskl->price_per_hour}} {{ $spskl->Currency->symbol}} /  @lang('strings.new.hour')
                                    @else
                                        {{ $spskl->price_per_day}} {{ $spskl->Currency->symbol}} /  @lang('strings.new.day')
                                    @endif

                                </td>
                                <td>
                                    @if($spskl->status)
                                        @lang('strings.new.enable')
                                    @else
                                        @lang('strings.new.disable')
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.spskill.destroy',$spskl->id) }}" method="POST">    
                                        <a class="btn btn-primary" href="{{ route('admin.spskill.edit',$spskl->id) }}">@lang('strings.new.edit')</a>
                       
                                        @csrf
                                        @method('DELETE')
                          
                                        <button type="submit" class="btn btn-danger">@lang('strings.new.delete')</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                      
                        {!! $spskill->links() !!}
                    </div>
                </div>
                @endif
                
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
        $("#avatar_image").val(img);
        
      });
    });
    </script>
    <script>    
    $( document ).ready(function() {    
        $('.date').datepicker({  

          dateFormat: 'yy-mm-dd'

        }); 

        $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });
    </script>
@endpush
