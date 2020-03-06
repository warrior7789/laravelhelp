@extends('backend.layouts.app')
@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))
@section('content')
    @push('after-styles')
        <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet">
        <style type="text/css">
            .jconfirm-box-container{
                padding-right: 0px;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left leftA">
                <h2>@lang('strings.new.serviceprovider')</h2>
            </div>
            
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('admin.serviceprovider.create') }}"> @lang('strings.new.add_new_serviceprovider')</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="serach-sp">
                <form class="form-inline" method="get" action="{{ route('admin.serviceprovider') }}">

                    <div class="form-group">
                        <label for="first_name">@lang('validation.attributes.frontend.first_name'): </label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter Firstname" value="{{ $searchbyfirstName }}">
                    </div>

                    <div class="form-group">
                        <label for="last_name">@lang('validation.attributes.frontend.last_name'): </label>
                        <input type="text" class="form-control" name="last_name" id="name" placeholder="Enter Lastname" value="{{ $searchbylastName }}">
                    </div>
                   
                    <div class="form-group">
                        <label for="email">@lang('strings.new.email_text'): </label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="{{ $searchbyEmail }}">
                    </div>

                    <button type="submit" class="btn btn-success">Search</button>
                    <a class="btn btn-success" href="{{ route('admin.serviceprovider') }}"> @lang('strings.new.reset')</a>
                </form>
            </div>
        </div>
    </div>
    
    <table class="table table-bordered skilltable">
        <tr>
            <th>@lang('strings.new.no')</th>
            <th>@lang('validation.attributes.frontend.first_name')</th>  
            <th>@lang('validation.attributes.frontend.last_name')</th>            
            <th>@lang('validation.attributes.frontend.email')</th>            
            <th>@lang('strings.new.status')</th>
            
            <th width="280px">@lang('strings.new.action')</th>
        </tr>
        @foreach ($serviceprovider as $sprovider)
        <tr>
            <td>{{ ++$i }} </td>
            <td>{{ $sprovider->first_name}}</td>
            <td>{{ $sprovider->last_name}}</td>
            <td>{{ $sprovider->email}}</td>            
            <td>
                @if($sprovider->active)
                    @lang('strings.new.enable')
                @else
                    @lang('strings.new.disable')
                @endif
            </td>
            <td>
                <form id="frmspdelete-{{$sprovider->id}}" name="frmspdelete" action="{{ route('admin.serviceprovider.destroy',$sprovider->id) }}" method="POST">    
                    <a class="btn btn-primary" href="{{ route('admin.serviceprovider.edit',$sprovider->id) }}">@lang('strings.new.edit')</a>
   
                    @csrf
                    @method('DELETE')                    
                    <button type="button" data-id="{{$sprovider->id}}" class="btn btn-danger btnspdelete">@lang('strings.new.delete')</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $serviceprovider->links() !!}

    @push('after-scripts')    
    <script src="{{ asset('js/jquery-confirm.js') }}" defer></script>
    <script> 
    $(document).on('click', '.btnspdelete', function(){
        var id = $(this).attr('data-id');
        // console.log(id);
        $.confirm({
            title: 'Confirm!',
            columnClass: 'm',
            content: 'Are you sure you want to delete service provider?<br/>You can choose the below options:<br/> <strong>1. Remain as Customer:</strong> Means this user can continue as a customer only.<br/><strong>2. Delete Anywhere:</strong> Means this user completely removed from the system.',
            type: 'red',
            typeAnimated: true,
            closeIcon: true,
            buttons: {
                "Remain As Customer": {
                    btnClass: 'btn-warning btn',
                    action: function(){
                        $('#frmspdelete-'+id).append('<input type="hidden" value="remain_as_customer" name="action" />');
                        $('#frmspdelete-'+id).trigger('submit');
                    }
                },
                "Delete Anywhere": {
                    btnClass: 'btn-danger btn',
                    action: function(){
                        $('#frmspdelete-'+id).trigger('submit');
                    }
                },
                // cancel: function () {
                // }
            }
        });
    });   
    </script>
    @endpush
      
@endsection