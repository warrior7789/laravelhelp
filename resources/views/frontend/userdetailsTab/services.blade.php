   
@if(!empty($Sproskills))   
    @foreach ($Sproskills as $key => $skdata)
        <div class="service-tab">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-6">
                    <div class="services-skill">
                        @php
                            $offer = 0;
                            $originalprice = 0;
                            $now = date("Y-m-d");
                            $now = strtotime($now);

                            if($skdata->show_price =="hour"){
                                $final_price = $skdata->price_per_hour;
                                $day_hour = __('strings.new.hour');                            
                            }else{
                                $final_price = $skdata->price_per_day; 
                                $day_hour = __('strings.new.day');                       
                            }
                            if((!empty($skdata->offer_start_date)) && (!empty($skdata->offer_end_date)) && (!empty($skdata->offer_discount)))
                            {
                                $originalprice = $final_price;
                                $offer_start = strtotime($skdata->offer_start_date);
                                $offer_end = strtotime($skdata->offer_end_date);
                                if($offer_start  <= $now  &&  $now  <= $offer_end){
                                    $final_price = (float) ($final_price - (($final_price *$skdata->offer_discount)/100 ) );
                                    $offer=1;
                                }
                            }
                         @endphp
                        @if(!empty($skdata->Skill))
                            @if($offer)
                                @if(!empty($skdata->offer_img))
                                    <img src="/storage/spskills/{{ $skdata->offer_img }}" alt="Image">
                                @else
                                     <img src="/storage/skills/{{ $skdata->Skill->avatar }}" alt="Image">
                                @endif
                            @else
                               @if(!empty($skdata->Skill->avatar))
                                    <img src="/storage/skills/{{ $skdata->Skill->avatar }}" alt="Image">
                               @endif 
                            @endif
                        @endif
                        @if(!empty($offer))
                            <span class="services-offer-price">{{ $skdata->offer_discount }}  %OFF</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-sm-6 col-6">
                    @if(!empty($skdata->Skill->name))
                        <div class="services-skill-name">{{ $skdata->Skill->name }}</div>
                    @endif
                    @if(!empty($skdata->tags))
                        <div class="services-skill-description"><b>Tags</b>: {{ $skdata->tags }}</div>
                    @endif 
                    @if(!empty($skdata->description))
                        <div class="services-skill-description">{{ $skdata->description }}</div>
                    @endif 
                                  
                    <div class="services-discount-price">
                        @if(!empty($offer))
                            <span class="services-original-price-strike"><strike>{{ $originalprice}} {{ $skdata->Currency->symbol}} / {{ $day_hour }}</strike>
                            </span>
                            <span class="services-net-amount">{{ $final_price}} {{ $skdata->Currency->symbol}} / {{ $day_hour }}</span>
                            
                        @else
                            <span class="services-original-price">{{ $final_price}} {{ $skdata->Currency->symbol}} / {{ $day_hour }}</span>
                            
                        @endif
                    </div>               
                </div>
            </div>
        </div>
    @endforeach
@endif
