@extends('backend.layouts.app')

@section('page_title',__('strings.new.spskill'))



@section('content')


    <h1 class="page-title">
        {{ $model->id ? __('strings.new.edit_skill'):__('strings.new.skill_add_new') }}
    </h1>
    <div class="page-content container-fluid seboX">

        <div class="row">
            <div class="col-md-12 skill-table">
                {{ Form::model($model, array('route' => array('admin.spskill.create') ,'files' => true , 'class' => 'row' )) }}
                {{ Form::hidden('id') }}
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                        <label for="user_id">@lang('strings.new.select_user')</label>
                        {{ Form::select('user_id', $user, $value = null, $attributes = array('class' => 'form-control','id'=>'user_id') ) }}
                        {!! $errors->first('user_id', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>                 
                        
                    <div class="form-group {{ $errors->has('skill_id') ? 'has-error' : ''}}">
                        <label for="skill_id">@lang('strings.new.select_skill')</label>
                        <div class="skill_select_box">
                        {{ Form::select('skill_id', $skills, $value = null, $attributes = array('class' => 'form-control') ) }}
                        </div>
                        {!! $errors->first('skill_id', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        <label for="description">@lang('strings.new.description')</label>
                        {{ Form::textarea('description', $value = null, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                        {!! $errors->first('description', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('price_per_hour') ? 'has-error' : ''}}">
                        <label for="price_per_hour">@lang('strings.new.Price_per_hour')</label>
                        {{ Form::text('price_per_hour' ,$value = null, $attributes = array('class' => 'form-control')) }}
                        {!! $errors->first('price_per_hour', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('price_per_day') ? 'has-error' : ''}}">
                        <label for="price_per_day">@lang('strings.new.Price_per_day')</label>
                        {{ Form::text('price_per_day',$value = null, $attributes = array('class' => 'form-control') ) }}
                        {!! $errors->first('price_per_day', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('show_price') ? 'has-error' : ''}}">
                        <label for="show_price">@lang('strings.new.show_price')</label>
                        <div class="radio">
                            <label>{{ Form::radio('show_price', 'hour') }}@lang('strings.new.hour')</label>
                        {{-- </div>
                        <div class="radio"> --}}
                            <label>{{ Form::radio('show_price', 'day') }}@lang('strings.new.day')</label>
                        </div>               
                        {!! $errors->first('show_price', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('currency_id') ? 'has-error' : ''}}">
                        <label for="currency_id">@lang('strings.new.select_currency')</label>
                        {{ Form::select('currency_id', $Currency, $value = null, $attributes = array('class' => 'form-control') ) }}
                        {!! $errors->first('currency_id', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('offer_discount') ? 'has-error' : ''}}">
                        <span>For Discount only</span>
                        <label for="offer_discount">@lang('strings.new.offer_discount')</label>
                        {{ Form::text('offer_discount' ,$value = null, $attributes = array('class' => 'form-control')) }}
                        {!! $errors->first('offer_discount', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('offer_desc') ? 'has-error' : ''}}">
                        <label for="offer_desc">@lang('strings.new.offer_desc')</label>
                        {{ Form::textarea('offer_desc' ,$value = null, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                        {!! $errors->first('offer_desc', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('offer_img') ? 'has-error' : ''}}">
                        <label class="form-check-label" for="offer_img">
                            @lang('strings.new.offer_img')
                        </label>
                        {{ Form::file('offer_img') }}
                        <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                        {!! $errors->first('offer_img', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('offer_start_date') ? 'has-error' : ''}}">
                        <label for="offer_start_date">@lang('strings.new.offer_start_date')</label>
                        {{ Form::text('offer_start_date' ,$value = null, $attributes = array('class' => 'form-control date','id' => 'offer_start_date')) }}
                        {!! $errors->first('offer_start_date', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('offer_end_date') ? 'has-error' : ''}}">
                        <label for="offer_end_date">@lang('strings.new.offer_end_date')</label>
                        {{ Form::text('offer_end_date' ,$value = null, $attributes = array('class' => 'form-control date','id' => 'offer_end_date')) }}
                        {!! $errors->first('offer_end_date', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                    </div>

                    <div class="form-check {{ $errors->has('status') ? 'has-error' : ''}}">
                        {{ Form::checkbox('status', '1',null , $attributes = array('class' => 'form-check-input')  ) }}
                        <label class="form-check-label" for="status">
                            &nbsp; @lang('strings.new.status')
                        </label>
                        <p>{!! $errors->first('status', '<p class="help-block help-block-error 
                        text-danger">:message</p>') !!}
                        </p>
                    </div>

                    {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-success upd-btn')) }}
                    <a href="{{ route('admin.spskill') }}" class="btn btn-danger  upd-btn"> @lang('strings.new.cancel')</a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    
@stop

@push('after-styles')
    <style type="text/css">
       
    </style>
@endpush

@push('after-scripts')
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
    </script>
    <script>    
    $( document ).ready(function() {    
        $('.date').datepicker({  

          dateFormat: 'yy-mm-dd'

        }); 
    });
    </script>
@endpush
