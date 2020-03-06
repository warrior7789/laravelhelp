@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. __('strings.new.photogallary'))

@section('content')
    {{-- <div class="row"> --}}
        {{-- <div class="col-lg-12 margin-tb"> --}}

    <div class="page-header">
        <h2>
            @lang('strings.new.sp_photogallary') 
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('frontend.user.photogallary.create') }}"> @lang('strings.new.addnew_photogallary')</a>
                
            </div>       
        </h2>
    </div>
        {{-- </div> --}}
    {{-- </div> --}}
    
    <table class="table" data-form="deleteForm">
        <thead>
            <tr>
                <th>@lang('strings.new.image')</th>
                <th>@lang('strings.new.title')</th>
                <th>@lang('strings.new.status')</th>  
                <th width="280px">@lang('strings.new.action')</th>              
            </tr>
        </thead>
        <tbody>         
            @foreach ($Photogallary as $phGallary)           
            <tr>
                <td>
                    @if(!empty($phGallary->image))                    
                        <img src="/images-album/{{$phGallary->user_id }}/{{ $phGallary->image }}" style="width: 50px;height: 50px" />                 
                    @endif
                </td> 
                <td>{{ $phGallary->title}}</td>   
                <td>
                    @if($phGallary->status)
                        @lang('strings.new.enable')
                    @else
                        @lang('strings.new.disable')
                    @endif
                </td> 
                <td>
                    <a class="btn btn-primary" href="{{ route('frontend.user.photogallary.edit',$phGallary->id) }}">@lang('strings.new.edit')</a>
                    

                    {!! Form::model($phGallary, ['method' => 'post', 'route' => ['frontend.user.photogallary.delete', $phGallary->id], 'class' =>'form-inline form-delete']) !!}
                        {!! Form::hidden('id', $phGallary->id) !!}
                        {!! Form::button(__('strings.new.delete'), ['class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                    {!! Form::close() !!}
                </td>             
            </tr>
            @endforeach
        </tbody>
    </table>
  
    {!! $Photogallary->links() !!}

    <div class="modal fade" role="dialog" id="confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you, want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Delete</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
    $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
        e.preventDefault();
        var $form=$(this);
        $('#confirm').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#delete-btn', function(){
                $form.submit();
            });
    });
    </script>
@endpush