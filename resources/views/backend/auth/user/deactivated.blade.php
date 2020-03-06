@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.deactivated'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('labels.backend.access.users.management')
                    <small class="text-muted">@lang('labels.backend.access.users.deactivated')</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-sm-12">
                <div class="serach-sp">
                    <form class="form-inline" method="get" action="{{ route('admin.auth.user.deactivated') }}">

                        <div class="form-group">
                            <label for="first_name">@lang('labels.backend.access.users.table.first_name'): </label>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter Firstname" value="{{ $searchbyfirstName }}">
                        </div>

                        <div class="form-group">
                            <label for="last_name">@lang('labels.backend.access.users.table.last_name'): </label>
                            <input type="text" class="form-control" name="last_name" id="name" placeholder="Enter Lastname" value="{{ $searchbylastName }}">
                        </div>
                       
                        <div class="form-group">
                            <label for="email">@lang('strings.new.email_text'): </label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="{{ $searchbyEmail }}">
                        </div>

                        <button type="submit" class="btn btn-success">Search</button>
                        <a class="btn btn-success" href="{{ route('admin.auth.user.deactivated') }}"> @lang('strings.new.reset')</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            {{-- <th>@lang('labels.backend.access.users.table.last_name')</th>
                            <th>@lang('labels.backend.access.users.table.first_name')</th>
                            <th>@lang('labels.backend.access.users.table.email')</th>
                            <th>@lang('labels.backend.access.users.table.confirmed')</th>
                            <th>@lang('labels.backend.access.users.table.roles')</th>
                            <th>@lang('labels.backend.access.users.table.other_permissions')</th>
                            <th>@lang('labels.backend.access.users.table.social')</th>
                            <th>@lang('labels.backend.access.users.table.last_updated')</th>
                            <th>@lang('labels.general.actions')</th> --}}
                            <th>@lang('labels.backend.access.users.table.first_name')</th>
                            <th>@lang('labels.backend.access.users.table.last_name')</th>
                            <th>@lang('labels.backend.access.users.table.email')</th>
                            {{-- <th>@lang('labels.backend.access.users.table.confirmed')</th>
                            <th>@lang('labels.backend.access.users.table.roles')</th>
                            <th>@lang('labels.backend.access.users.table.other_permissions')</th>
                            <th>@lang('labels.backend.access.users.table.social')</th> --}}
                            {{-- <th>@lang('labels.backend.access.users.table.last_updated')</th> --}}
                            <th>@lang('strings.new.status')</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count())
                            @foreach($users as $user)
                                <tr>
                                    {{-- <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{!! $user->confirmed_label !!}</td>
                                    <td>{!! $user->roles_label !!}</td>
                                    <td>{!! $user->permissions_label !!}</td>
                                    <td>{!! $user->social_buttons !!}</td>
                                    <td>{{ $user->updated_at->diffForHumans() }}</td>
                                    <td>{!! $user->action_buttons !!}</td> --}}
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->active)
                                            @lang('strings.new.enable')
                                        @else
                                            @lang('strings.new.disable')
                                        @endif
                                    </td>
                                    {{-- <td>{!! $user->confirmed_label !!}</td>
                                    <td>{!! $user->roles_label !!}</td>
                                    <td>{!! $user->permissions_label !!}</td>
                                    <td>{!! $user->social_buttons !!}</td>
                                    <td>{{ $user->updated_at->diffForHumans() }}</td> --}}
                                   
                                    <td>{!! $user->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">@lang('strings.backend.access.users.no_deactivated')</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $users->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
