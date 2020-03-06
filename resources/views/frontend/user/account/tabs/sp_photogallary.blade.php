@push('after-styles')
    <link href="{{ asset('lightbox/css/lightbox.css') }}" rel="stylesheet">
@endpush

<div class="page-header my-photo">
    <h2>
        <!-- @lang('strings.new.sp_photogallary')  -->
            <a class="btn btn-success" href="{{ route('frontend.user.photogallary.create') }}"> @lang('strings.new.addnew_photogallary')</a>
    </h2>

    <div class="photo-gallary">
        @if($Photogallary->count())
            <div class="row">
                @foreach ($Photogallary as $phtgallary)
                    <div class="col-md-3"> 
                        <a class="photo-image-link" href="/images-album/{{$phtgallary->user_id }}/{{ $phtgallary->image }}" data-lightbox="photo-image">
                            <img class="lazy" data-src="/images-album/{{$phtgallary->user_id }}/{{ $phtgallary->image }}" alt="Image" />
                        </a>
                        <span class="photo-title">{{ $phtgallary->title}}</span>
                        <div class="actions">
                            <a class="btn btn-primary photo-b" href="{{ route('frontend.user.photogallary.edit',$phtgallary->id) }}"><i class="fa fa-edit"></i></a>
                            {!! Form::model($phtgallary, ['method' => 'post', 'route' => ['frontend.user.photogallary.delete', $phtgallary->id], 'class' =>'form-delete']) !!}
                                {!! Form::hidden('id', $phtgallary->id) !!}
                                <a class="btn btn-danger delete-photo" href="javascript:;"><i class="fa fa-trash"></i></a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="no-photo">No photos found!</h3>
        @endif
    </div>

    <table class="d-none table skill-table d-none1" data-form="deleteForm">
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
                    <a class="btn btn-primary photo-b" href="{{ route('frontend.user.photogallary.edit',$phGallary->id) }}">@lang('strings.new.edit')</a>
                    

                    {!! Form::model($phGallary, ['method' => 'post', 'route' => ['frontend.user.photogallary.delete', $phGallary->id], 'class' =>'form-inline form-delete']) !!}
                        {!! Form::hidden('id', $phGallary->id) !!}
                        {!! Form::submit(__('strings.new.delete'), ['class' => 'btn btn-xs btn-danger delete', 'name' => 'delete_modal']) !!}
                    {!! Form::close() !!}
                </td>             
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($Photogallarycount > 10)
    <div class="gallery_show_more d-none">
    	<a href="{{ route('frontend.user.photogallary') }}">More</a>
    </div>
    @endif
</div>

@push('after-scripts')

<script src="{{ asset('lightbox/js/lightbox.js') }}" defer></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>

<script>
$(function() {
    $('.lazy').lazy();
});

</script>
@endpush
