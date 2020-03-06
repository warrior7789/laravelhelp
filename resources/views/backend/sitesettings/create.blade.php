@extends('backend.layouts.app')

@section('page_title',__('strings.new.sitesettings'))
@section('content')
@php
$facebookurl="";
$twitterurl="";
$linkedinurl="";
$instagramurl="";
$phone="";
$address="";
$sitelogo="";

if(!empty($sitesettingsData))
{
    foreach ($sitesettingsData as $moddata)
    {
        if($moddata->fieldname == 'facebookurl')
        {
            $facebookurl=$moddata->fieldvalue;
        }
        if($moddata->fieldname == 'twitterurl')
        {
            $twitterurl=$moddata->fieldvalue;
        }
        if($moddata->fieldname == 'linkedinurl')
        {
            $linkedinurl=$moddata->fieldvalue;
        }
        if($moddata->fieldname == 'instagramurl')
        {
            $instagramurl=$moddata->fieldvalue;
        }
        if($moddata->fieldname == 'phone')
        {
            $phone=$moddata->fieldvalue;
        }
        if($moddata->fieldname == 'address')
        {
            $address=$moddata->fieldvalue;
        }
        if($moddata->fieldname == 'sitelogo')
        {
            $sitelogo=$moddata->fieldvalue;
        }
    }
}

@endphp

    <h1 class="page-title">
        {{ __('strings.new.update_sitesettings') }}
    </h1>
    <div class="page-content container-fluid seboX">
        
        {{ Form::model($model, array('route' => array('admin.sitesettings.create') ,'files' => true, 'class'=>'row')) }}
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="facebookurl">@lang('strings.new.social_media_facebook'):</label>
                    <input type="text" name="facebookurl" id="facebookurl" value="{{ $facebookurl }}" class="form-control">                
                </div>

                <div class="form-group">
                    <label for="twitterurl">@lang('strings.new.social_media_twitter'):</label>
                    <input type="text" name="twitterurl" id="twitterurl" value="{{ $twitterurl }}" class="form-control">  
                </div>

                <div class="form-group">
                    <label for="linkedinurl">@lang('strings.new.social_media_linkedin'):</label>
                    <input type="text" name="linkedinurl" id="linkedinurl" value="{{ $linkedinurl }}" class="form-control">                
                </div>

                <div class="form-group">
                    <label for="instagramurl">@lang('strings.new.social_media_instagram'):</label>
                    <input type="text" name="instagramurl" id="instagramurl" value="{{ $instagramurl }}" class="form-control">                
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">@lang('strings.new.phone'):</label>
                    <input type="text" name="phone" id="phone" value="{{ $phone }}" class="form-control">                
                </div>

                <div class="form-group">
                    <label for="logofile">@lang('strings.new.address'):</label>
                    <textarea name="address" id="address" class="form-control">{{ $address }}</textarea>
                </div>

                <div class="form-group">
                    <label for="sitelogo">@lang('strings.new.sitelogo'):</label>
                    <input type="file" name="sitelogo" id="sitelogo">
                    @if($sitelogo!='') 
                        <img class="photo-glr" style="height: 100px;width: 100px;" src="/logo/{{ $sitelogo }}" />
                    @endif
                </div>
                
                <input type="hidden" name="previous_logo" id="previous_logo" value="{{ $sitelogo }}">

                {{ Form::submit(__('strings.new.save'),$attributes = array('class' => 'btn btn-primary')) }}
            </div>
           
        {{ Form::close() }}
    </div>
    
@stop

@push('after-styles')
    <style type="text/css">
       
    </style>
@endpush

@push('after-scripts')
    
@endpush
