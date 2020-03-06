@extends('backend.layouts.app')

@section('page_title',__('strings.new.ads'))



@section('content')


    <h1 class="page-title">
        {{ $model->id ? __('strings.new.update_ads'):__('strings.new.add_new_ads') }}
    </h1>
    <div class="page-content container-fluid seboX">
        
        {{ Form::model($model, array('route' => array('admin.ads.create') ,'files' => true)) }}
        <div class="row"> 
            <div class="col-md-6">  
                <div class="form-group {{ $errors->has('pagename') ? 'has-error' : ''}}">
                    <label for="pagename">@lang('strings.new.select_pagename')</label>
                    {{ Form::select('pagename', $pagenames, $value = null, $attributes = array('class' => 'form-control') ) }}
                    {!! $errors->first('pagename', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                </div>

                <div class="form-group {{ $errors->has('position') ? 'has-error' : ''}}">
                    <label for="position">@lang('strings.new.select_position')</label>
                    {{ Form::select('position', $positions, $value = null, $attributes = array('class' => 'form-control') ) }}
                    {!! $errors->first('position', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    <label for="title">@lang('strings.new.title'):</label>
                    {{ Form::text('title',$value = null, $attributes = array('class' => 'form-control') ) }} 
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="image">
                        @lang('strings.new.image')
                    </label>
                    {{ Form::file('image') }} 
                    @if(!empty($model->image))                    
                        <img src="/addvs/{{ $model->image }}" height="100px" width="100px" alt="Image">
                    @endif 
                    <input type="hidden" name="previous_image" id="previous_image" value="{{ $model->image }}">             
                </div>

                <div class="form-group">
                    <label for="link">@lang('strings.new.link'):</label>
                    {{ Form::text('link',$value = null, $attributes = array('class' => 'form-control') ) }} 
                </div>

                <div class="form-check spaceAlign">
                  {{ Form::checkbox('isgoogle', '1',null , $attributes = array('class' => 'form-check-input')  ) }}
                  <label class="form-check-label" for="isgoogle">
                    @lang('strings.new.isgoogle') (@lang('strings.new.isgoogle_note'))
                  </label>
                </div>

                <div class="form-group">
                    <label for="description">@lang('strings.new.description')</label>
                    {{ Form::textarea('description', $value = null, $attributes = array('class' => 'form-control','rows' => 4) ) }}                
                </div>

                

                <div class="form-check spaceAlign">
                  {{ Form::checkbox('status', '1',null , $attributes = array('class' => 'form-check-input')  ) }}
                  <label class="form-check-label" for="status">
                    @lang('strings.new.status')
                  </label>
                </div>

                
                
                {{ Form::hidden('id') }}
                {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-primary')) }}
                <a href="{{ route('admin.ads') }}" class="btn btn-danger"> @lang('strings.new.cancel')</a>
            </div>
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
