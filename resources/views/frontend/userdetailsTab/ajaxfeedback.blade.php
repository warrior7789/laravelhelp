@if(!empty($feedbackData))   
    @foreach ($feedbackData as $feeddata)
    <div class="row">        
        <div class="col-md-2">
            <div class="feedback-user-image">
                @if($feeddata->avatar_type=='storage')
                    @if(!empty($feeddata->avatar_location))
                    <div class="feedback-part">    
                        <img src="{{ Storage::disk('public')->url($feeddata->avatar_location) }}" style="height: 100px;width: 100px"  alt="Image">
                    </div>
                    @endif
                @endif
                
                @if($feeddata->avatar_type!='storage' || $feeddata->avatar_type!='gravatar')
                    @if(!empty($feeddata->avatar))                            
                        <div class="feedback-part">    
                            <img src="{{ $feeddata->avatar }}" style="height: 100px;width: 100px" alt="Image">
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="col-md-10">
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
                <div class="feedback-rating">
                    @if(!empty($feeddata->total))
                        @php
                            $totalrating =round($feeddata->total);
                            for ($i=0; $i < $totalrating; $i++) { 
                                echo '<i class="fa fa-star" aria-hidden="true"></i>';
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
    @endforeach
@endif

<div class="feedback-pagination">
    {!! $feedbackData->links() !!}
</div>