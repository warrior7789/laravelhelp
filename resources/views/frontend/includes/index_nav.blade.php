<div class="navbar home-mynavbar">
    <div class="container">    
        <div id="mySidenav" class="sidenav my-i">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="{{ route('frontend.about') }}"><i class="fas fa-info"></i>@lang('strings.new.about_us')</a>
            <a href="{{ route('frontend.service') }}"><i class="fas fa-concierge-bell"></i>@lang('strings.new.services')</a>
            {{-- <a href="#"><i class="fas fa-users"></i>@lang('strings.new.clients')</a>    --}}        
            <a href="{{route('frontend.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.contact')) }}"><i class="fas fa-phone-square"></i>@lang('navs.frontend.contact_us')</a>
        </div>

        <span style="font-size:30px;cursor:pointer" onclick="openNav()">
            <div class="ham1"></div>
            <div class="ham2"></div>
            <div class="ham3"></div>
        </span> 

        <div class="right-menus">
            <ul class="flex-list"> 
                <li class="boxmenutemp">
                    @auth
                        <a href="#" class="dropdown-toggleh" id="menu1" data-toggle="dropdown" ><i class="fas fa-th"></i></a>
                        <div class="boxmenu">
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >  
                                <li role="presentation">
                                    <a href="{{route('frontend.user.dashboard')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.dashboard')) }}"><i class="fas fa-desktop"></i>@lang('strings.new.dashboard')</a>
                                </li> 
                                <li role="presentation">
                                    <a href="{{route('frontend.user.inbox')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.inbox')) }}">
                                        <i class="fas fa-envelope-square"></i>@lang('strings.new.messages')</a></li>
                                <li role="presentation">
                                    <a href="{{ route('frontend.user.account') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.account')) }}">
                                        <i class="fas fa-user-circle"></i>@lang('navs.frontend.user.account'){{--  <br> <small >{{ $logged_in_user->first_name}} {{ $logged_in_user->last_name }}</small>  --}}
                                    </a>
                                </li>
                                @if($logged_in_user->is_sp == 1)
                                    <li>
                                        <!-- <a href="{{ route('frontend.user.spskill') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.spskill')) }}"><i class="fas fa-lightbulb"></i>@lang('strings.new.skill')</a> -->
                                        <a href="{{ route('frontend.user.feedbacks') }}" class="dropdown-item {{ active_class(Active::checkRoute('frontend.user.feedbacks')) }}"><i class="fas fa-star"></i>@lang('strings.new.feedbacks')</a>
                                    </li>
                                @endif
                            </ul> 
                        </div>
                    @endauth
                </li>
       
                @guest
                    <li class="boxmenutemp">
                        <a href="#" onclick="openLogin()">@lang('navs.general.login')</a>
                    </li>
                @else
                    <li class="boxmenutemp">
                        <a href="#" class="dropdown-toggleh" id="notifi-menu" data-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="notitifation"></span>
                        </a>
                        <div class="notitifation_boxmenu boxmenu">
                        
                        </div>
                    </li>
                    <li class="boxmenutemp">
                        <a href="{{ route('frontend.auth.logout') }}" >@lang('navs.general.logout')</a>
                    </li>
                @endguest   
            </ul>
        </div>
    </div>
</div>

@push('after-scripts')
    <script>
        var app_w = $("#app").width();
        var side_w = $("#mySidenav-login").width();
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
