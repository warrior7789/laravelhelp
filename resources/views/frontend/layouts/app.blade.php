<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="@yield('meta_description', 'Laravel 5 Boilerplate')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @auth
            <meta name="user-id" content="{{ Auth::user()->id }}">
        @endauth

        @yield('meta')

        <title>@yield('title', app_name())</title>

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}        
        <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/vue-multiselect.min.css') }}" />
        
        @stack('after-styles')
        
        <!-- local testing  google api -->
        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ3w2XZ6msFgbmQJ9dKST1HeYQLM6Dqnk&libraries=places" async="" defer=""></script> -->

        <!-- live google api -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANGQiDmKPOHX5H5fUJQiuVsjhsL1Q3MtU&libraries=places&language=sv&region=SE" async="" defer=""></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135043380-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-135043380-1');
</script>
       
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'siteName'  => config('app.name'),
                'siteUrl'  => config('app.url'),
                'apiDomain' => config('app.url').'/api',
            ]) !!}
        </script>
        <style type="text/css">
            .sidenav-login.move-to-right{
                right: -30%;
                transition: right 1s;
            }
            .sidenav-login.move-to-right-tablet{
                right: -40%;
                transition: right 1s;
            }
            .sidenav-login.move-to-left{
                right: 0px;
                transition: right 1s;
            }
            #app.move-to-right{
                width: 100%;
                transition: width 1s;
            }
            #app.move-to-left{
                width: 70%;
                transition: width 1s;
            }
            .hidden{
                right: -1000px;
                width: 100%;
            }
            .move-to-left-full{
                right:0;
                width: 100%;
                transition: width 1s;
            }
            .overlap-login{
                width: 0px;         
                right: 0 !important;
            }
        </style>
    </head>
    <body class="page_{{ str_replace('.','_',Route::currentRouteName()) }}">
        <div id="app" class="{{ Route::currentRouteName()=='frontend.index'?'move-to-right':'' }}">
            @include('includes.partials.logged-in-as')

            @if(Route::currentRouteName() == 'frontend.index')            
                @include('frontend.includes.index_nav')
            @else
                @include('frontend.includes.nav')
            @endif    
            <div class="container-fluid-custom">                  
                @include('includes.partials.messages')
                @yield('content')                
            </div><!-- container -->
            @if(Route::currentRouteName() == 'frontend.index')            
                
            @else
                @include('frontend.includes.footer')
            @endif 
        </div><!-- #app -->

        @guest
            <div id="mySidenav-login" class="sidenav-login {{ Route::currentRouteName()=='frontend.index'?'move-to-right':'overlap-login' }}">
                <a href="javascript:void(0)" class="closebtn login-close" onclick="closelogin()">&times;</a>
                <div class="row justify-content-center align-items-center">
                    <div class="col col-md-12 align-self-center">
                        <div class="card nb">
                            <!-- <div class="card-header">
                                <strong>
                                    @lang('labels.frontend.auth.login_box_title')
                                </strong>
                            </div>-->
                            <div class="card-body logpart">
                                {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                                    @if(Route::currentRouteName() == 'frontend.profile.slug')
                                        <input type="hidden" name="redirecturl" value="{{ Request::url() }}">
                                    @endif
                                    <div class="row">
                                        <div class="col">
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
                                        <div class="col">
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
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    {{ html()->label(html()->checkbox('remember', true, 1) . ' ' . __('labels.frontend.auth.remember_me'))->for('remember') }}
                                                </div>
                                            </div><!--form-group-->
                                        </div><!--col-->
                                    </div><!--row-->

                                    <div class="row">
                                        <div class="col loginbtn">
                                            <div class="form-group clearfix">
                                                {{ form_submit(__('labels.frontend.auth.login_button')) }}
                                            </div><!--form-group-->
                                        </div><!--col-->
                                    </div><!--row-->

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <a href="{{ route('frontend.auth.password.reset') }}" class="frgt-link">@lang('labels.frontend.passwords.forgot_password')</a>
                                                
                                            </div><!--form-group-->
                                        </div><!--col-->
                                    </div><!--row-->
                                {{ html()->form()->close() }}

                                <div class="row">
                                    <div class="col">
                                        <div class="login-social">
                                            @if(config('access.registration'))
                                                <p><a href="{{route('frontend.auth.register')}}" class="rgstr-link">@lang('navs.frontend.register')</a></p>
                                            @endif
                                            <a href="/login/facebook" class="loginBtn loginBtn--facebook btn btn-outline-info m-1"> Login with Facebook</a>
                                            
                                            <a href="/login/google" class="loginBtn loginBtn--google btn btn-sm btn-outline-info m-1">Login with Google</a>
                                        </div>
                                    </div><!--col-->
                                </div><!--row-->                                
                            </div><!--card body-->
                        </div><!--card-->
                    </div><!-- col-md-8 -->
                </div><!-- row -->
            </div>
        @endguest

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/manifest.js')) !!}
        {!! script(mix('js/vendor.js')) !!}
        {!! script(mix('js/frontend.js')) !!}
        
        <script src="{{ asset('js/jquery-ui.js') }}" defer></script>        
       
        @if(Route::currentRouteName() == 'frontend.index')
            <script type="text/javascript">
                function openLogin() {
                    if($( window ).width() > 500){                        
                        $("#app, #mySidenav-login").addClass("move-to-left");
                        $("#app, #mySidenav-login").removeClass("move-to-right");
                    }else{
                        $("#mySidenav-login").addClass("move-to-left-full");
                        $("#mySidenav-login").removeClass("move-to-right");               
                    }
                }

                function closelogin() {
                    if($( window ).width() > 500){
                        $("#app, #mySidenav-login").addClass("move-to-right");
                        $("#app, #mySidenav-login").removeClass("move-to-left");
                    }else{
                        $("#mySidenav-login").removeClass("move-to-left-full");
                        $("#mySidenav-login").addClass("move-to-right");  
                    }         
                }
            </script>            
        @else
            <script type="text/javascript">
                function openLogin() {
                    if($( window ).width() > 500){                   
                        $("#mySidenav-login").animate({ width: "30%" }, 200);
                    }else{
                        $("#mySidenav-login").animate({ width: "100%" }, 200);
                    }
                }

                function closelogin() {
                    if($( window ).width() > 500){
                        $("#mySidenav-login").animate({ width: "0" }, 200); "0";
                    }else{
                        $("#mySidenav-login").animate({ width: "0" }, 200);
                    }            
                }
            </script>  
        @endif 

        @stack('after-scripts')      

        @include('includes.partials.ga')
    </body>
</html>
