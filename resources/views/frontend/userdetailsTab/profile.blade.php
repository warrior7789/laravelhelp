<div class="container">
    <div class="under-details">   
        <div class="row">
            <div class="col-md-4 col-sm-5 br-right">
                <h2>@lang('strings.new.inforamtion')</h2> 
                @if(!empty($alluserData->Spavailability))       
                    <div class="user-availability-time">
                        @php 
                            $timeslot = array();
                            $spavailabilityArray = array();
                            if(!empty($alluserData->Spavailability)){
                                $spavailabilityArray = $alluserData->Spavailability;
                                foreach ($spavailabilityArray as $availabletime) {
                                    $timeslot = json_decode($availabletime->timeslot);               
                                }           
                            }
                        @endphp
                        @if(!empty($timeslot))
                        <h4>@lang('strings.new.opningHours')</h4>
                            <ul class="user-timetable">            
                                @if(!empty($timeslot->monday) && empty($timeslot->monday->close) )          
                                    @if($timeslot->monday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.mon')</span>
                                            <span class="timing">{{ $timeslot->monday->from }} - {{ $timeslot->monday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.mon')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li> 
                                @endif

                                @if(!empty($timeslot->tuesday) && empty($timeslot->tuesday->close) )
                                    @if($timeslot->tuesday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.tue')</span>
                                            <span class="timing">{{ $timeslot->tuesday->from }} - {{ $timeslot->tuesday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.tue')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li>                                 
                                @endif

                                @if(!empty($timeslot->wednesday) && empty($timeslot->wednesday->close) )
                                    @if($timeslot->wednesday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.wed')</span>
                                            <span class="timing">{{ $timeslot->wednesday->from }} - {{ $timeslot->wednesday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.wed')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li>                                
                                @endif

                                @if(!empty($timeslot->thursday) && empty($timeslot->thursday->close) )
                                    @if($timeslot->thursday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.thu')</span>
                                            <span class="timing">{{ $timeslot->thursday->from }} - {{ $timeslot->thursday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.thu')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li>                                 
                                @endif

                                @if(!empty($timeslot->friday) && empty($timeslot->friday->close))
                                    @if($timeslot->friday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.fri')</span>
                                            <span class="timing">{{ $timeslot->friday->from }} - {{ $timeslot->friday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.fri')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li>                                 
                                @endif

                                @if(!empty($timeslot->saturday) && empty($timeslot->saturday->close) )
                                    @if($timeslot->saturday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.sat')</span>
                                            <span class="timing">{{ $timeslot->saturday->from }} - {{ $timeslot->saturday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.sat')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li>                                
                                @endif

                                @if(!empty($timeslot->sunday) && empty($timeslot->sunday->close) )
                                    @if($timeslot->sunday->from)
                                        <li>
                                            <span class="days">@lang('strings.new.sun')</span>
                                            <span class="timing">{{ $timeslot->sunday->from }} - {{ $timeslot->sunday->to }}</span>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <span class="days">@lang('strings.new.sun')</span>
                                        <span class="timing">@lang('strings.new.close')</span>
                                    </li>                                
                                @endif                            
                            </ul>                        
                        @endif
                    </div>
                @endif
            
                <div class="user-contact-info">
                    @if(!empty($alluserData->Profile))
                    <h4>@lang('strings.new.contactInfo')</h4>
                        @if(!empty($alluserData->Profile->phone))
                        <p><i class="fas fa-mobile-alt"></i><span>{{ $alluserData->Profile->phone }}</span> </p>
                        @endif

                        @if(!empty($alluserData->Profile->address))
                        <p><i class="fas fa-map-marker-alt"></i><span>{{ $alluserData->Profile->address }}</span> </p>
                        @endif
                    @endif

                    @if(!empty($alluserData->email))
                    <p><i class="fa fa-envelope" aria-hidden="true"></i><span>{{ $alluserData->email }}</span></p>
                    @endif
                </div>

                <div class="user-social-icons">
                    @if(!empty($alluserData->Profile))
                        @if(!empty($alluserData->Profile->facebook) || !empty($alluserData->Profile->twitter)  || !empty($alluserData->Profile->linkedin) ||!empty($alluserData->Profile->instagram) )
                            <h4>{{ __('strings.new.social_media_text') }}</h4>
                        @endif
                        @if(!empty($alluserData->Profile->facebook))
                            <a href="{{ $alluserData->Profile->facebook }}" target="_blank" class="social-i"><i class="fab fa-facebook-square"></i></a>
                        @endif

                        @if(!empty($alluserData->Profile->twitter))
                            <a href="{{ $alluserData->Profile->twitter }}" target="_blank" class="social-i"><i class="fab fa-twitter"></i></a>
                        @endif

                        @if(!empty($alluserData->Profile->linkedin))
                            <a href="{{ $alluserData->Profile->linkedin }}" target="_blank" class="social-i"><i class="fab fa-linkedin"></i></a>
                        @endif

                        @if(!empty($alluserData->Profile->instagram))
                            <a href="{{ $alluserData->Profile->instagram }}" target="_blank" class="social-i"><i class="fab fa-instagram"></i></a>
                        @endif
                    @endif    
                </div>
            </div>
            <div class="col-md-8 col-sm-7">
                <div class="user-skill-wishlist">
                    <div class="row user-skill">
                        <div class="col-md-12"> 
                            <div class="row set-right">
                                @if(!empty($Sproskills))
                                    @foreach ($Sproskills as $key => $spkdata)
                                        @if(!empty($spkdata->Skill))
                                            @if(!empty($spkdata->Skill->avatar))
                                                <img src="/storage/skills/{{ $spkdata->Skill->avatar }}" alt="Image" style="height: 40px;width: 40px">
                                            @endif
                                        @endif                       
                                    @endforeach
                                @endif
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="user-about-section">
                    @if(!empty($alluserData->Profile->about))
                        <p> {{ $alluserData->Profile->about }} </p>                    
                    @endif
                    {{-- <button type="button" class="btn service-btn">More</button> --}}
                </div>
                <div class="sp-services">
                    <h2>Services</h2>
                    @include('frontend.userdetailsTab.services')
                </div>
            </div>
        </div>
    </div>
</div>