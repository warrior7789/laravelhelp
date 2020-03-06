@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="container">
        <div class="col col-sm-12">
            <div class="row">
                <div class="card registerd">
                    <div class="card-header title-card">
                        @lang('labels.frontend.auth.register_box_title')
                    </div><!--card-header-->

                    <div class="card-body">
                        {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                            <!-- change by bindiya -->
                            <!-- <div class="form-group">
                                <div class="top-header">    
                                    <p>
                                        {{ html()->label(__('strings.frontend.select_role'))->for('is_sp') }}
                                    </p>
                                    <span class="prt-radio">
                                        <input class="select-roles" type="radio" name="is_sp" value="1"  checked />{{__('strings.new.service_provider')}}
                                        <span class="checkmark-prt"></span>
                                    </span>
                                    <span class="prt-radio">
                                        <input class="select-roles" type="radio" name="is_sp" value="0" />{{__('strings.new.customer')}} 
                                        <span class="checkmark-prt"></span>
                                    </span>
                                </div>
                            </div> -->
                            <!-- change by bindiya -->
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                        {{ html()->text('first_name')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.first_name'))
                                            ->attribute('tabindex', 1)
                                            ->attribute('maxlength', 191) }}
                                    </div><!--col-->
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                        {{ html()->email('email')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.email'))
                                            ->attribute('maxlength', 191)
                                            ->attribute('tabindex', 3)
                                            ->required() }}
                                    </div><!--form-group-->
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                        {{ html()->password('password_confirmation')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                            ->attribute('tabindex', 5)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--row-->

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                        {{ html()->text('last_name')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.last_name'))
                                            ->attribute('tabindex', 2)
                                            ->attribute('maxlength', 191) }}
                                    </div><!--form-group-->
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                        {{ html()->password('password')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.password'))
                                            ->attribute('tabindex', 4)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                           
                            @if(config('access.captcha.registration'))
                                <div class="row">
                                    <div class="col">
                                        {!! Captcha::display() !!}
                                        {{ html()->hidden('captcha_status', 'true') }}
                                    </div><!--col-->
                                </div><!--row-->
                            @endif
                            
                            <div class="row">
                                <div class="col">
                                    <div class="form-group registerbtn">
                                        {{ Form::button(__('labels.frontend.auth.register_button'),array('class' => 'registerbtn btn btn-success btn-sm' ,'type' => 'submit', 'tabindex' => 6)) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                        {{ html()->form()->close() }}

                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <a href="/login/facebook" class="loginBtn loginBtn--facebook btn btn-outline-info m-1" tabindex="7"> @lang('labels.frontend.auth.login_with_facebook')</a>
                                                
                                    <a href="/login/google" class="loginBtn loginBtn--google btn btn-sm btn-outline-info m-1" tabindex="8"> @lang('labels.frontend.auth.login_with_google')</a>
                                </div>
                            </div><!--/ .col -->
                        </div><!-- / .row -->
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endpush
