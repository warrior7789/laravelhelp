@extends('backend.layouts.app')

@section('page_title',__('strings.new.skill'))



@section('content')


    <h1 class="page-title">
        {{ $model->id ? __('strings.new.edit_skill'):__('strings.new.skill_add_new') }}
    </h1>
    <div class="page-content container-fluid seboX">
        
        {{ Form::model($model, array('route' => array('admin.skill.create') ,'files' => true)) }}

            <div class="form-group spaceAlign Inp">
                <label for="name">@lang('strings.new.name'):</label>
                {{ Form::text('name',$value = null, $attributes = array('class' => 'form-control') ) }} 
            </div>

            
            <div class="form-check spaceAlign">
              {{ Form::checkbox('status', '1',1 , $attributes = array('class' => 'form-check-input')  ) }}
              <label class="form-check-label" for="status">
                @lang('strings.new.status')
              </label>
            </div>

            <div class="form-group spaceAlign chooseFile">
                <label class="form-check-label" for="status">
                    @lang('strings.new.avatar')
                </label>
                {{ Form::file('avatar') }}
                <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
               
            </div>
            
            {{ Form::hidden('id') }}
            {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-primary')) }}
            <a href="{{ route('admin.skill') }}" class="btn btn-danger"> @lang('strings.new.cancel')</a>
        {{ Form::close() }}
    </div>
    
@stop

@push('after-styles')
    <style type="text/css">
       
    </style>
@endpush

@push('after-scripts')
    
@endpush
