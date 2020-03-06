@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. __('strings.new.spskill'))

@section('content')
    <div class="container">
        <div class="page-header my-skill">
            <h2>{{ $model->id ? __('strings.new.edit_skill'):__('strings.new.skill_add_new') }}</h2>
        </div>
        <div>
            <div class="col-md-12 skill-table">
                {{ Form::model($model, array('route' => array('frontend.user.spskill.create') ,'files' => true , 'class' => 'row' )) }}
                    {{ Form::hidden('id') }}
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('skill_id') ? 'has-error' : ''}}">
                            <label for="skill_id">@lang('strings.new.select_skill')</label>
                            {{ Form::select('skill_id', $skills, $value = null, $attributes = array('class' => 'form-control') ) }}
                            {!! $errors->first('skill_id', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            <label for="description">@lang('strings.new.description')</label>
                            {{ Form::textarea('description', $value = null, $attributes = array('class' => 'form-control','cols'=>10,'rows' => 4) ) }}
                            {!! $errors->first('description', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>
                    
                        <!--- custom by bindiya -->
                        <div class="form-group {{ $errors->has('tags') ? 'has-error' : ''}}">
                            <label for="tags">{{ __('strings.new.tags') }}</label>
                            {{ Form::text('tags' ,$value = null, $attributes = array('class' => 'form-control', "data-role"=>"tagsinput")) }}
                            {!! $errors->first('tags', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>
                        <!--- custom by bindiya -->

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
                                <label>{{ Form::radio('show_price', 'day') }}@lang('strings.new.day')</label>
                            </div>
                            {!! $errors->first('show_price', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group {{ $errors->has('currency_id') ? 'has-error' : ''}}">
                            <label for="currency_id">@lang('strings.new.select_currency')</label>
                            {{ Form::select('currency_id', $Currency, $value = null, $attributes = array('class' => 'form-control') ) }}
                            {!! $errors->first('currency_id', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
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
                        <div class="form-group d-none {{ $errors->has('offer_img') ? 'has-error' : ''}}">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-check-label" for="offer_img">
                                        @lang('strings.new.offer_img')
                                    </label>
                                    {{ Form::file('offer_img') }}
                                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                                    {!! $errors->first('offer_img', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                </div>
                                <div class="col-md-3">
                                    @if(!empty($model->offer_img))
                                    <img src="/storage/spskills/{{ $model->offer_img }}" height="50px" width="50px">
                                    @endif
                                </div>
                            </div>
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
                    </div>
                    <div class="col-md-12">
                        <div class="form-check {{ $errors->has('status') ? 'has-error' : ''}}">
                            {{ Form::checkbox('status', '1',1 , $attributes = array('class' => 'form-check-input')  ) }}
                            <label class="form-check-label" for="status">
                                &nbsp; @lang('strings.new.status')
                            </label>
                            <p>{!! $errors->first('status', '<p class="help-block help-block-error
                                text-danger">:message</p>') !!}
                            </p>
                        </div>
                        {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-success upd-btn')) }}
                        <a href="{{ route('frontend.user.account')."#skill_list" }}" class="btn btn-danger  upd-btn"> @lang('strings.new.cancel')</a>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-tagsinput.css"> <!-- custom by bindiya -->
@endpush

@push('after-scripts')
    <script type="text/javascript" src="/js/bootstrap-tagsinput.min.js"></script>   <!-- custom by bindiya -->
    <script>
        $( document ).ready(function() {
            $('.date').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endpush