@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. __('strings.new.photogallary'))

@section('content')
    <div class="photogallary-edit">    
        <div class="container">    
            
            <div class="set-upload-photo">
                <div class="page-header my-photo">
                    <h2>{{ $model->id ? __('strings.new.edit_skill'):__('strings.new.addnew_photogallary') }}</h2>
                </div>
           
                <div class="skill-table">
                    
                        {{ Form::model($model, array('route' => array('frontend.user.photogallary.create') ,'files' => true)) }}

                            @if($model->id) 
                                <input type="hidden" name="id" value="{{ $model->id }}" /> 
                            @else
                                <input type="hidden" name="id" value="0" /> 
                            @endif
                            
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}} edt-glr">
                                <label for="title">@lang('strings.new.title')</label>
                                {{ Form::text('title' ,old('title', $model->title),null, $attributes = array('class' => 'form-control')) }}
                                {!! $errors->first('title', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                            </div>

                            
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                <label class="form-check-label" for="image">
                                    @lang('strings.new.image')
                                </label>
                                {{ Form::file('image') }}
                                <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                                {!! $errors->first('image', '<p class="help-block help-block-error text-danger">:message</p>') !!}

                                @if(!empty($model->image)) 
                                    <img class="photo-glr" src="/images-album/{{$model->user_id }}/{{ $model->image }}" />
                                @endif
                            </div>
                            
                            <div class="form-check {{ $errors->has('status') ? 'has-error' : ''}}">
                                {{ Form::checkbox('status', '1',null , $attributes = array('class' => 'form-check-input')  ) }}
                                <label class="form-check-label" for="status">
                                    &nbsp; @lang('strings.new.status')
                                </label>
                                <p>{!! $errors->first('status', '<p class="help-block help-block-error text-danger">:message</p>') !!}
                                </p>
                            </div>

                            {{ Form::submit($model->id?__('strings.new.update'):__('strings.new.create'),$attributes = array('class' => 'btn btn-success')) }}
                            <a href="{{ route('frontend.user.account')."#sp_photogallary" }}" class="btn btn-danger"> @lang('strings.new.cancel')</a>

                        {{ Form::close() }}
                </div>
            </div>
            
        </div>
    </div>
@endsection
