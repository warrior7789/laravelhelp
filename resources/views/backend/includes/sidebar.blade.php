<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            {{-- <li class="nav-title">
                <i class="nav-icon icon-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;@lang('menus.backend.sidebar.general')
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            {{-- <li class="nav-title">
               <i class="nav-icon icon-wrench"></i>&nbsp;&nbsp;&nbsp;&nbsp;@lang('menus.backend.sidebar.system')
            </li> --}}

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/serviceprovider*')) }}" href="{{ route('admin.serviceprovider') }}">
                                @lang('strings.new.serviceprovider')
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li> --}}
                    </ul>
                </li>
            @endif

            <li class="divider"></li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/skill*')) }}" href="{{ route('admin.skill') }}">
                 <i class="nav-icon icon-fire"></i>&nbsp;&nbsp;@lang('strings.new.skill')

                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/spskill*')) }}" href="{{ route('admin.spskill') }}">
                 <i class="nav-icon icon-fire"></i>&nbsp;&nbsp;@lang('strings.new.spskill')

                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/serviceprovider*')) }}" href="{{ route('admin.serviceprovider') }}">
                 <i class="nav-icon icon-user"></i>&nbsp;&nbsp;@lang('strings.new.serviceprovider')
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/currency*')) }}" href="{{ route('admin.currency') }}">
                <i class="nav-icon fas fa-money-bill-wave"></i>&nbsp;&nbsp;@lang('strings.new.currency')

                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/ads*')) }}" href="{{ route('admin.ads') }}">
                <i class="nav-icon fas fa-futbol"></i>&nbsp;&nbsp;@lang('strings.new.ads_sidebar')

                </a>
            </li>

            {{-- <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li> --}}

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/sitesettings*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/sitesettings*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('strings.new.settings')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/sitesettings/create')) }}" href="{{ route('admin.sitesettings.create') }}">
                            @lang('strings.new.sitesettings')
                        </a>
                    </li>
                    
                </ul>
            </li>
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
