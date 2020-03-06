@extends('backend.layouts.app')
@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))
@section('content')
    

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left leftA">
                <h2>@lang('strings.new.skill_list')</h2>
            </div>
            <div class="pull-right rightA">
                <a class="btn btn-success" href="{{ route('admin.skill.create') }}"> @lang('strings.new.skill_add_new')</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="serach-sp">
                <form class="form-inline" method="get" action="{{ route('admin.skill') }}">

                    <div class="form-group">
                        <label for="name">@lang('strings.new.name'): </label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Skill Name" value="{{ $name }}">
                    </div>

                    <button type="submit" class="btn btn-success">Search</button>
                    <a class="btn btn-success" href="{{ route('admin.skill') }}"> @lang('strings.new.reset')</a>
                </form>
            </div>
        </div>
    </div>
   
    <table class="table table-bordered skilltable">
        <tr>
            <th>@lang('strings.new.no')</th>
            <th>@lang('strings.new.name')</th>            
            <th>@lang('strings.new.avatar')</th>            
            <th>@lang('strings.new.status')</th>
            
            <th width="280px">@lang('strings.new.action')</th>
        </tr>
        @foreach ($Skills as $Skill)
        <tr>
            <td>{{ ++$i }} </td>
            <td>{{ $Skill->name }}</td>
            <td><img src="/storage/skills/{{ $Skill->avatar }}" width="100px" height="100px" ></td>
            <td>
                @if($Skill->status)
                    @lang('strings.new.enable')
                @else
                    @lang('strings.new.disable')
                @endif
                

            </td>
            <td>
                <form action="{{ route('admin.skill.destroy',$Skill->id) }}" method="POST">    
                    <a class="btn btn-primary" href="{{ route('admin.skill.edit',$Skill->id) }}">@lang('strings.new.edit')</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">@lang('strings.new.delete')</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $Skills->links() !!}
      
@endsection