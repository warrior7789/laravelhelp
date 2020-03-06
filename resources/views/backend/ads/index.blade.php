@extends('backend.layouts.app')
@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))
@section('content')
    

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left leftA">
                <h2>@lang('strings.new.ads_sidebar')</h2>
            </div>
            <div class="pull-right rightA">
                <a class="btn btn-success" href="{{ route('admin.ads.create') }}"> @lang('strings.new.add_new_ads')</a>
            </div>
        </div>
    </div>
   
    
   
    <table class="table table-bordered skilltable">
        <tr>
            {{-- <th>@lang('strings.new.no')</th> --}}
            <th>@lang('strings.new.pagename')</th>  
            <th>@lang('strings.new.position')</th>           
            {{-- <th>@lang('strings.new.image')</th>  
            <th>@lang('strings.new.link')</th> --}}   
            <th>@lang('strings.new.isgoogle')</th>        
            <th>@lang('strings.new.status')</th>
            
            <th width="280px">@lang('strings.new.action')</th>
        </tr>
        @foreach ($ads as $ad)
        <tr>
            {{-- <td>{{ ++$i }} </td> --}}
            <td>{{ $ad->pagename }}</td>
            <td>{{ $ad->position }}</td>
            {{-- <td>
             @if(!empty($ad->image))                    
                <img src="/addvs/{{ $ad->image }}" height="100px" width="100px" alt="Image">
            @endif 
            </td>
            <td>{{ $ad->link }}</td> --}}
            <td>
                @if($ad->isgoogle)
                    @lang('strings.new.yes')
                @else
                    @lang('strings.new.no')
                @endif
            </td>
            <td>
                @if($ad->status)
                    @lang('strings.new.enable')
                @else
                    @lang('strings.new.disable')
                @endif
            </td>
            <td>
                <form action="{{ route('admin.ads.destroy',$ad->id) }}" method="POST">    
                    <a class="btn btn-primary" href="{{ route('admin.ads.edit',$ad->id) }}">@lang('strings.new.edit')</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">@lang('strings.new.delete')</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $ads->links() !!}
      
@endsection