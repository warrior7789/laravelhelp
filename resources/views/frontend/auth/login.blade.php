@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
    <div class="container">
        <div class="col col-sm-12">
            <div class="row">
                <div class="card registerd">
                    <div class="card-header title-card">
                        @lang('labels.frontend.auth.login_box_title')
                    </div>

                    <div class="card-body">
                        {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                        {{ html()->email('email')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.email'))
                                            ->attribute('maxlength', 191)
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                        {{ html()->password('password')
                                            ->class('form-control')
                                            ->placeholder(__('validation.attributes.frontend.password'))
                                            ->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            {{ html()->label(html()->checkbox('remember', true, 1) . ' ' . __('labels.frontend.auth.remember_me'))->for('remember') }}
                                        </div>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group registerbtn clearfix">
                                        {{ Form::button(__('labels.frontend.auth.login_button'),array('class' => 'registerbtn btn btn-success btn-sm' ,'type' => 'submit', 'tabindex' => 6)) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <a href="{{ route('frontend.auth.password.reset') }}">@lang('labels.frontend.passwords.forgot_password')</a>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                        {{ html()->form()->close() }}

                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <!-- {!! $socialiteLinks !!} -->
                                    <a href="/login/facebook" class="loginBtn loginBtn--facebook btn btn-outline-info m-1" tabindex="7"> @lang('labels.frontend.auth.login_with_facebook')</a>
                                                
                                    <a href="/login/google" class="loginBtn loginBtn--google btn btn-sm btn-outline-info m-1" tabindex="8"> @lang('labels.frontend.auth.login_with_google')</a>
                                </div>
                            </div><!--col-->
                        </div><!--row-->
                    </div><!--card body-->
                </div>
            </div><!--card-->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
