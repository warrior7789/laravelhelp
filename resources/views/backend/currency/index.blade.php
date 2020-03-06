@extends('backend.layouts.app')
@section('title', app_name() . ' | '. __('labels.backend.access.roles.management'))
@section('content')
    

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left leftA">
                <h2>@lang('strings.new.currency_list')</h2>
            </div>
            <div class="pull-right rightA">
                <a class="btn btn-success" href="{{ route('admin.currency.create') }}"> @lang('strings.new.currency_add_new')</a>
            </div>
        </div>
    </div>
   
    
   
    <table class="table table-bordered currencytable">
        <tr>
            <th>@lang('strings.new.no')</th>
            <th>@lang('strings.new.name')</th>            
            <th>@lang('strings.new.iso_code')</th>            
            <th>@lang('strings.new.symbol')</th>            
            <th>@lang('strings.new.status')</th>
            
            <th width="280px">@lang('strings.new.action')</th>
        </tr>
        @foreach ($Currencys as $Currency)
        <tr>
            <td>{{ ++$i }} </td>
            <td>{{ $Currency->name }}</td>
            <td>{{ $Currency->iso_code }}</td>
            <td>{{ $Currency->symbol }}</td>
            
            <td>
                @if($Currency->status)
                    @lang('strings.new.enable')
                @else
                    @lang('strings.new.disable')
                @endif
                

            </td>
            <td>
                <form action="{{ route('admin.currency.destroy',$Currency->id) }}" method="POST" >    
                    <a class="btn btn-primary" href="{{ route('admin.currency.edit',$Currency->id) }}">@lang('strings.new.edit')</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">@lang('strings.new.delete')</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $Currencys->links() !!}
      
@endsection