@push('after-styles')
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">    
@endpush
<div class="container">
    @if(!empty($feedbackData->count()))   
        <div class="row feedback-ajax-data">
            <!-- <h2 class="rating-heading">{{ __('strings.new.feedback') }}</h2> -->
            @foreach ($feedbackData as $feeddata)
                <!-- <div class="col-md-6">  -->
                    <div class="service-tab">   
                    <div class="row">        
                        <div class="col-lg-1 col-md-2 col-sm-2 col-3">
                            <div class="feedback-user-image">
                                @php
                                    $avatar_path = "/storage/avatars/dummy.png";
                                    if($feeddata->avatar_type=='storage'){
                                        if(!empty($feeddata->avatar_location)){
                                            $avatar_path = Storage::disk('public')->url($feeddata->avatar_location);
                                        }
                                    }
                                    if($feeddata->avatar_type!='storage' || $feeddata->avatar_type!='gravatar'){
                                        if(!empty($feeddata->avatar)){
                                            $avatar_path = $feeddata->avatar;
                                        }
                                    }
                                @endphp
                                <div class="feedback-part">
                                    <img src="{{ $avatar_path }}" alt="Image">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-11 col-md-10 col-sm-10 col-9 fd-p">
                        <div class="feedback-user-detail">
                            <div class="feedback-content-block">
                                <div class="feedback-user-name">
                                    @if((!empty($feeddata->first_name)) && (!empty($feeddata->last_name)))
                                        {{ $feeddata->first_name }} {{ $feeddata->last_name }}
                                    @endif
                                </div>
                                <div class="feedback-date">
                                    @if(!empty($feeddata->created_at))
                                        {{ date( "F j, Y @ g:i a", strtotime( $feeddata->created_at ) ) }}
                                    @endif
                                </div>
                                <div class="feedback-rating row">
                                    @if(!empty($feeddata->value_for_money))
                                        <div class="col-md-3">
                                            <p>Value for Money</p>
                                            @php
                                                $totalrating =round($feeddata->value_for_money);
                                                for ($i=0; $i < $totalrating; $i++) { 
                                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                            @endphp
                                        </div>
                                    @endif
                                    @if(!empty($feeddata->relation_with_customer))
                                        <div class="col-md-3">
                                            <p>Relation with Customer</p>
                                            @php
                                                $totalrating =round($feeddata->relation_with_customer);
                                                for ($i=0; $i < $totalrating; $i++) { 
                                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                            @endphp
                                        </div>
                                    @endif
                                    @if(!empty($feeddata->quality_of_work))
                                        <div class="col-md-3">
                                            <p>Quality of Work</p>
                                            @php
                                                $totalrating =round($feeddata->quality_of_work);
                                                for ($i=0; $i < $totalrating; $i++) { 
                                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                            @endphp
                                        </div>
                                    @endif
                                    @if(!empty($feeddata->performance))
                                        <div class="col-md-3">
                                            <p>Performance</p>
                                            @php
                                                $totalrating =round($feeddata->performance);
                                                for ($i=0; $i < $totalrating; $i++) { 
                                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                            @endphp
                                        </div>
                                    @endif
                                    @if(!empty($feeddata->total))
                                        @php
                                            $totalrating =round($feeddata->total);
                                            for ($i=0; $i < $totalrating; $i++) { 
                                                // echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                            }
                                        @endphp
                                    @endif
                                </div>
                                <div class="feedback-description">
                                    @if(!empty($feeddata->review))
                                        {{ $feeddata->review }}
                                    @endif
                                </div>
                            </div>
                        </div> 
                        </div> 
                    </div>          
                <!-- </div> -->
               </div>
            @endforeach
            <div class="feedback-pagination">
                {!! $feedbackData->links() !!}
            </div>
        </div>
    @else
        <h3 class="no-feedback">No feedbacks found!</h3>
    @endif
</div> 

@push('after-scripts')
<script>
$(document).ready(function() {
    $(document).on('click', '.pagination a', function (e) {
        getPosts($(this).attr('href').split('page=')[1]);
        e.preventDefault();        
    });
});

function getPosts(page) {
    var url = '<?php echo $_ENV['APP_URL']."/feedback/ajaxfeedback/".$slug."?page="?>'+page;
    $.ajax({
    url : url,
    dataType: 'html',
    }).done(function (data) {
        $('.feedback-ajax-data').html(data);
    }).fail(function () {
        alert('Sorry something went wrong, feedback could not be loaded.');
    });
}
</script>
@endpush