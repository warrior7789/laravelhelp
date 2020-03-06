@extends('backend.layouts.app')

@section('page_title',__('strings.new.currency'))



@section('content')


    <h1 class="page-title">
        {{ $model->id ? __('strings.new.currency_edit'):__('strings.new.currency_add_new') }}
    </h1>
    <div class="page-content container-fluid">
        
        {{ Form::model($model, array('route' => array('admin.currency.create') ,'files' => true)) }}

            <div class="form-group">
                <label for="name">@lang('strings.new.name'):</label>
                {{ Form::text('name',$value = null, $attributes = array('class' => 'form-control') ) }} 
            </div>

            <div class="form-group">
                <label for="iso_code">@lang('strings.new.iso_code'):</label>
                {{ Form::text('iso_code',$value = null, $attributes = array('class' => 'form-control') ) }} 
            </div>

            <div class="form-group">
                <label for="symbol">@lang('strings.new.symbol'):</label>
                {{ Form::text('symbol',$value = null, $attributes = array('class' => 'form-control') ) }} 
            </div>

            
            <div class="form-check spaceAlign">
              {{ Form::checkbox('status', '1',null , $attributes = array('class' => 'form-check-input')  ) }}
              <label class="form-check-label" for="status">
                @lang('strings.new.status')
              </label>

            </div>
            
            {{ Form::hidden('id') }}
            {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-primary')) }}
            <a href="{{ route('admin.currency') }}" class="btn btn-danger"> @lang('strings.new.cancel')</a>
        {{ Form::close() }}
    </div>
    
@stop

@push('after-styles')
    <style type="text/css">
       
    </style>
@endpush

@push('after-scripts')
    
@endpush
