<nav class="navbar inner-mynavbar navbar-expand-lg navbar-light mb-4">
    <div class="container">   

        <div class="col-md-6 col-4">
            <div class="row">
                <div class="logos">
                   <a href="#;"> <img src="/img/whitelogo.jpg" class="main_logo"></a>
                </div> 
            </div>
        </div>
        <div class="col-md-6 col-8">
            <div class="row">  
                <div class="right-menus">    
                        <a href="#"><i class="fas fa-bell"></i></a>
                        <a href="#"><i class="fas fa-user"></i></a> 
                        <a class="inner-login" href="#">Login</a>
                </div>
            </div>
        </div>

    </div>
</nav>



@push('after-scripts')
    <script>
        function openNav() {
          document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
          document.getElementById("mySidenav").style.width = "0";
        }
    </script>
@endpush



<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container">    
        <a href="{{ route('frontend.index') }}" class="navbar-brand">{{ app_name() }}</a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('labels.general.toggle_navigation')">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @if(config('locale.status') && count(config('locale.languages')) > 1)
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">@lang('menus.language-picker.language') ({{ strtoupper(app()->getLocale()) }})</a>

                        @include('includes.partials.lang')
                    </li>
                @endif

                @auth
                    <li class="nav-item"><a href="{{route('frontend.user.dashboard')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}">@lang('navs.frontend.dashboard')</a></li>
                @endauth

                @auth
                    <li class="nav-item"><a href="{{route('frontend.user.inbox')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.inbox')) }}">@lang('strings.new.messages')</a></li>
                @endauth

                @guest
                    <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">@lang('navs.frontend.login')</a></li>

                    @if(config('access.registration'))
                        <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">@lang('navs.frontend.register')</a></li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">{{ $logged_in_user->name }}</a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuUser">
                            @can('view backend')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">@lang('navs.frontend.user.administration')</a>
                            @endcan

                            <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}">@lang('navs.frontend.user.account') </a>
                            @if($logged_in_user->is_sp == 1)
                                <a href="{{ route('frontend.user.spskill') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.spskill')) }}">@lang('strings.new.skill')</a>
                            @endif
                            <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">@lang('navs.general.logout')</a>
                        </div>
                    </li>
                @endguest

                <li class="nav-item"><a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.contact')) }}">@lang('navs.frontend.contact')</a></li>
            </ul>
        </div>
    </div>
</nav>
