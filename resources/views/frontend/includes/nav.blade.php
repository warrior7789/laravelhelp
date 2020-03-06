<nav class="navbar inner-mynavbar navbar-expand-lg navbar-light mb-4">
    <div class="container">   
        <div class="col-md-6 col-4">
            <div class="row">
                <div class="logos">
                   <a href="{{ route('frontend.index') }}"> <img src="/img/whitelogo.jpg" class="main_logo"></a>
                </div> 
            </div>
        </div>
        <div class="col-md-6 col-8">
            <div class="row">
                <div class="right-menus"> 
                    <ul class="flex-list">
                        {{-- @auth 
                            <li>
                                <a href="#">{{ $logged_in_user->email}}</a>
                            </li>
                        @endauth --}}
                      
                        <li class="boxmenutemp">
                            @auth
                                <a href="#" class="dropdown-toggleh" id="menu1" data-toggle="dropdown" ><i class="fas fa-th"></i></a>
                                <div class="boxmenu">
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                                        <li>
                                            <a href="{{route('frontend.user.dashboard')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"><i class="fas fa-desktop"></i>@lang('strings.new.dashboard')</a>
                                        </li>
                                        <li>
                                            <a href="{{route('frontend.user.inbox')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.inbox')) }}"><i class="fas fa-envelope-square"></i>@lang('strings.new.messages')</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}"><i class="fas fa-user-circle"></i>@lang('navs.frontend.user.account'){{-- <br> <small >{{ $logged_in_user->first_name}} {{ $logged_in_user->last_name }}</small> --}}
                                            </a>
                                        </li>
                                        @if($logged_in_user->is_sp == 1)
                                            <li>
                                                <a href="{{ route('frontend.user.feedbacks') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.feedbacks')) }}"><i class="fas fa-star"></i>@lang('strings.new.feedbacks')</a>
                                                <!-- <a href="{{ route('frontend.user.spskill') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.spskill')) }}"><i class="fas fa-lightbulb"></i>@lang('strings.new.skill')</a> -->
                                            </li>
                                        @endif
                                    </ul> 
                                </div>                          
                            @endauth
                        </li>
                        @guest 
                            <li>
                                <div class="inner-login">
                                    <a href="#" onclick="openLogin()">@lang('navs.general.login')</a>
                                </div>
                            </li>
                        @else
                            <li class="boxmenutemp">
                                <a href="#" class="dropdown-toggleh" id="notifi-menu" data-toggle="dropdown">
                                    <i class="fas fa-bell"></i>
                                    <span class="notitifation"></span>
                                </a>
                                <div class="notitifation_boxmenu boxmenu"></div>
                            </li>
                            <li>
                                <div class="inner-login">
                                    <a href="{{ route('frontend.auth.logout') }}" >@lang('navs.general.logout')</a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12 innerpage-submenu">
            <a href="{{ route('frontend.about') }}">@lang('strings.new.about_us')</a>
            <a href="{{ route('frontend.service') }}">@lang('strings.new.services')</a>
            {{-- <a href="#">@lang('strings.new.clients')</a>   --}}         
            <a href="{{route('frontend.contact')}}" class="{{ active_class(Active::checkRoute('frontend.contact')) }}">@lang('navs.frontend.contact_us')</a>
        </div>
    </div>
</div>

@push('after-scripts')
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function opensubmenu(){
            $(".opensubmenu").toggle();
        }

        function notitifation(){
            $(".notitifation_boxmenu").toggle();
        }
    </script>
@endpush