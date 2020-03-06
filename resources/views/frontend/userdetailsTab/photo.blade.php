@push('after-styles')
    <link href="{{ asset('lightbox/css/lightbox.css') }}" rel="stylesheet">
@endpush
@if(!empty($alluserData->Photogallary))
    <div class="container">
        <div class="photo-gallary">
            @if(!empty($alluserData->Photogallary->count()))
                <div class="row">
                    @php
                        $count=1;
                    @endphp

                    @foreach ($alluserData->Photogallary as $phtgallary)   
                        @if((!empty($phtgallary->image)) && ($phtgallary->status=='1'))     
                            <!-- <div class="col-md-3 dis-img-<?php echo $count?> <?php if($count>8){ ?>dis-no-img<?php } ?>" data-id="<?php echo $count;?>"> 
                                <a class="photo-image-link" href="/images-album/{{$phtgallary->user_id }}/{{ $phtgallary->image }}" data-lightbox="photo-image">               
                                <img class="lazy" src="/images-album/{{$phtgallary->user_id }}/{{ $phtgallary->image }}" alt="Image">
                                </a>
                            </div> -->
                            <div class="col-md-3"> 
                                <a class="photo-image-link" href="/images-album/{{$phtgallary->user_id }}/{{ $phtgallary->image }}" data-lightbox="photo-image">
                                    <img class="lazy" data-src="/images-album/{{$phtgallary->user_id }}/{{ $phtgallary->image }}" alt="Image">
                                </a>
                            </div>
                        @endif

                        @php
                            // $count++;
                        @endphp
                    @endforeach
                </div>
            @else
                <h3 class="no-photo">No photos found!</h3>
            @endif
        </div>
    </div>
@endif
@push('after-scripts')
<script src="{{ asset('lightbox/js/lightbox.js') }}" defer></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>

<script>
// $(window).scroll(function() { 
//     if($('.photo-tab-pane').hasClass('active'))
//     {                     
//         if($(window).scrollTop() + $(window).height() >= $(document).height())
//         {               
//             var divid = $(".dis-no-img").attr("data-id");
//             divid = parseInt(divid);
//             $('.dis-img-'+divid).show();
//             $('.dis-img-'+divid).removeClass('dis-no-img');

//             divid = parseInt(divid)+1;
//             $('.dis-img-'+divid).show();
//             $('.dis-img-'+divid).removeClass('dis-no-img');

//             divid = parseInt(divid)+1;
//             $('.dis-img-'+divid).show();
//             $('.dis-img-'+divid).removeClass('dis-no-img');

//             divid = parseInt(divid)+1;
//             $('.dis-img-'+divid).show();
//             $('.dis-img-'+divid).removeClass('dis-no-img');
//         }
//     }
// });

$(function() {
    $('.lazy').lazy();
});

</script>
@endpush
