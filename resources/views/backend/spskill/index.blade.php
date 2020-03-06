@extends('backend.layouts.app')
@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))
@section('content')
    

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left leftA">
                <h2>@lang('strings.new.skill_list')</h2>
            </div>
            <div class="pull-right rightA">
                <a class="btn btn-success" href="{{ route('admin.spskill.create') }}"> @lang('strings.new.skill_add_new')</a>
            </div>
        </div>
    </div>
   
    
   
    <table class="table table-bordered skilltable">
        <tr>
            <th>@lang('strings.new.no')</th>
            <th>@lang('strings.new.name')</th>  
            <th>@lang('strings.new.skill')</th>            
            <th>@lang('strings.new.price')</th>            
            <th>@lang('strings.new.status')</th>
            
            <th width="280px">@lang('strings.new.action')</th>
        </tr>
        @foreach ($spskill as $spskl)
        <tr>
            <td>{{ ++$i }} </td>
            <td>{{ $spskl->User->first_name}} {{ $spskl->User->last_name}}</td>
            <td>{{ $spskl->Skill->name}}</td>
            <td>
                @if($spskl->show_price =="hour")
                    {{ $spskl->price_per_hour}} {{ $spskl->Currency->symbol}} /  @lang('strings.new.hour')
                @else
                    {{ $spskl->price_per_day}} {{ $spskl->Currency->symbol}} /  @lang('strings.new.day')
                @endif

            </td>
            <td>
                @if($spskl->status)
                    @lang('strings.new.enable')
                @else
                    @lang('strings.new.disable')
                @endif
            </td>
            <td>
                <form action="{{ route('admin.spskill.destroy',$spskl->id) }}" method="POST">    
                    <a class="btn btn-primary" href="{{ route('admin.spskill.edit',$spskl->id) }}">@lang('strings.new.edit')</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">@lang('strings.new.delete')</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $spskill->links() !!}
      
@endsection