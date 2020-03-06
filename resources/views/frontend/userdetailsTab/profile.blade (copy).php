<div class="container">
    <div class="under-details">   
        <div class="row">
                <div class="col-md-4">
                <h2>@lang('strings.new.inforamtion')</h2> 
                @if(!empty($alluserData->Spavailability))       
                <div class="user-availability-time">
                    <h4>@lang('strings.new.opningHours')</h4>
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
                        <table class="table">
                            <tbody>                
                                @if(!empty($timeslot->monday) && empty($timeslot->monday->close) )
                                    <tr>
                                        <td>@lang('strings.new.monday')</td>
                                        <td>{{ $timeslot->monday->from }}</td>
                                        <td>{{ $timeslot->monday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.monday')</td>
                                        <td>{{ $timeslot->monday->close }}</td>
                                    </tr>
                                @endif

                                @if(!empty($timeslot->tuesday) && empty($timeslot->tuesday->close) )
                                    <tr>
                                        <td>@lang('strings.new.tuesday')</td>
                                        <td>{{ $timeslot->tuesday->from }}</td>
                                        <td>{{ $timeslot->tuesday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.tuesday')</td>
                                        <td>{{ $timeslot->tuesday->close }}</td>
                                    </tr>
                                @endif

                                @if(!empty($timeslot->wednesday) && empty($timeslot->wednesday->close) )
                                    <tr>
                                        <td>@lang('strings.new.wednesday')</td>
                                        <td>{{ $timeslot->wednesday->from }}</td>
                                        <td>{{ $timeslot->wednesday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.wednesday')</td>
                                        <td>{{ $timeslot->wednesday->close }}</td>
                                    </tr>
                                @endif

                                @if(!empty($timeslot->thursday) && empty($timeslot->thursday->close) )
                                    <tr>
                                        <td>@lang('strings.new.thursday')</td>
                                        <td>{{ $timeslot->thursday->from }}</td>
                                        <td>{{ $timeslot->thursday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.thursday')</td>
                                        <td>{{ $timeslot->thursday->close }}</td>
                                    </tr>
                                @endif

                                @if(!empty($timeslot->friday) && empty($timeslot->friday->close))
                                    <tr>
                                        <td>@lang('strings.new.friday')</td>
                                        <td>{{ $timeslot->friday->from }}</td>
                                        <td>{{ $timeslot->friday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.friday')</td>
                                        <td>{{ $timeslot->friday->close }}</td>
                                    </tr>
                                @endif

                                @if(!empty($timeslot->saturday) && empty($timeslot->saturday->close) )
                                    <tr>
                                        <td>@lang('strings.new.saturday')</td>
                                        <td>{{ $timeslot->saturday->from }}</td>
                                        <td>{{ $timeslot->saturday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.saturday')</td>
                                        <td>{{ $timeslot->saturday->close }}</td>
                                    </tr>
                                @endif

                                @if(!empty($timeslot->sunday) && empty($timeslot->sunday->close) )
                                    <tr>
                                        <td>@lang('strings.new.sunday')</td>
                                        <td>{{ $timeslot->sunday->from }}</td>
                                        <td>{{ $timeslot->sunday->to }}</td> 
                                    </tr>
                                @else
                                    <tr>
                                        <td>@lang('strings.new.sunday')</td>
                                        <td>@lang('strings.new.close')</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                        <ul class="user-timetable">
                            <li><span class="days">Mon</span><span class="timing">09:00 PM - 11:00 PM</span></li>
                            <li><span class="days">Tue</span><span class="timing">07:00 AM - 08:00 PM</span></li>
                        </ul>
                    @endif
                </div>
                @endif

                
                <div class="user-contact-info">
                    <h4>@lang('strings.new.contactInfo')</h4>
                    @if(!empty($alluserData->Profile))
                        @if(!empty($alluserData->Profile->phone))
                        <p><i class="fa fa-mobile" aria-hidden="true"></i><span>{{ $alluserData->Profile->phone }}</span> </p>
                        @endif

                        @if(!empty($alluserData->Profile->address))
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i><span>{{ $alluserData->Profile->address }}</span> </p>
                        @endif
                    @endif

                    @if(!empty($alluserData->email))
                    <p><i class="fa fa-envelope" aria-hidden="true"></i><span>{{ $alluserData->email }}</span></p>
                    @endif
                </div>
                </div>
                <div class="col-md-8">
                <div class="user-avtar-image">
                    @if($alluserData->avatar_type=='storage')
                        @if(!empty($alluserData->avatar_location))
                            <img src="{{ Storage::disk('public')->url($alluserData->avatar_location) }}" style="height: 500px;width: 100%" alt="Image">
                        @endif
                    @endif
                    
                    @if($alluserData->avatar_type!='storage' || $alluserData->avatar_type!='gravatar')
                        @if(!empty($alluserData->SocialAccount))
                            @foreach ($alluserData->SocialAccount as $socialavtar)
                                @if($alluserData->avatar_type == $socialavtar->provider)
                                    <img src="{{ $socialavtar->avatar }}" alt="Image" style="height: 500px;width: 100%">
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>     

                <div class="user-skill-wishlist" style="margin-top: 5%;">
                    <div class="user-skill float-right">
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

                <div class="user-about-section" style="margin-top: 15%;">
                    @if(!empty($alluserData->Profile->about))
                    <p>{{ $alluserData->Profile->about }}</p>
                    @endif
                </div>
                </div>
        </div>
    </div>
</div>