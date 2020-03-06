@extends('frontend.layouts.app')

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-12">
        <searchanywhere></searchanywhere>
    </div>
</div>
</div>
<div class="section-page"> 

    {{-- Advertisement div --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(!empty($ads['top']))                    
                    @if($ads['top']['isgoogle']==1)
                        <div class="adv_div">                   
                                {!! $ads['top']['description'] !!}                  
                        </div>
                    @else
                        <div class="adv_div">
                            @php
                                $link = $ads['top']['link'];
                                if(!strpos($link, '://')){
                                    $link = "http://".$link;
                                }
                            @endphp
                            <a href="{{ $link }}" target="_blank">
                                {{-- {{ $ads['top']['title'] }}  --}}                     
                                @if(!empty($ads['top']['image']))
                                    <img src="/addvs/{{ $ads['top']['image'] }}" alt="Image">
                                @endif
                            </a>
                        </div>
                    @endif
                    
                @endif
            </div>
        </div>
    </div>

    <div class="container-fluid">
            
            <div class="row pr">   
                @if(!empty($alluserData->Profile))
                    @if(!empty($alluserData->Profile->banner_image))
                        <div class="banner-image">   
                            <img src="/spbanner/{{$alluserData->Profile->user_id }}/{{ $alluserData->Profile->banner_image }}">
                        </div>
                    @else
                        <div class="banner-image">   
                            <img src="/spbanner/default-banner.jpg" height="300px">
                        </div>
                    @endif
                @endif
                {{-- <div class="slogan"> 
                    @if(!empty($alluserData->first_name) && !empty($alluserData->last_name))
                        <h2>{{ strtoupper($alluserData->first_name) }} {{ strtoupper($alluserData->last_name) }}</h2>
                    @endif

                    {{ @if(!empty($alluserData->last_name))
                        <h2>{{ strtoupper($alluserData->last_name) }}</h2>
                    @endif }}
                </div> --}}

                <div class="container alignment-set">   
                    <div class="services-part">  
                        <div class="black-part">
                            <img src="/storage/{{ $alluserData->avatar_location ? $alluserData->avatar_location : 'avatars/dummy.png' }}"  alt="Image">
                            <div class="profile-slogan">
                                @if((!empty($alluserData->first_name)) && (!empty($alluserData->last_name)))
                                    <h2>{{ $alluserData->first_name }} {{ $alluserData->last_name }}</h2>
                                @endif
                                @if(!empty($alluserData->Profile)) 
                                    <p><i class="fas fa-map-marker-alt"></i>
                                    <span>
                                        @if(!empty($alluserData->Profile->city))
                                            {{ ucwords($alluserData->Profile->city) }},
                                        @endif 
                                        @if(!empty($alluserData->Profile->state))
                                            {{ ucwords($alluserData->Profile->state) }},
                                        @endif
                                        @if(!empty($alluserData->Profile->country))
                                            {{ ucwords($alluserData->Profile->country) }}
                                        @endif
                                    </span></p>
                                @endif
                                
                                <p>
                                    @for($i=0; $i < $userAverageRating; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                    @for($i=$userAverageRating; $i < 5; $i++)
                                        <i class="fa fa-star star-white"></i>
                                    @endfor
                                </p>
                            </div>
                        </div>
                        @if($isonline==1)
                            <p> <i class="fas fa-circle active-circle"></i>
                                <i class="fas fa-circle mini-circle"></i>
                            </p>
                        @else
                            <p> <i class="fas fa-circle inactive-circle"></i>
                                <i class="fas fa-circle mini-circle"></i>
                            </p>
                        @endif
                    </div>
                </div>
        
                <div class="col-md-12">
                        <div class="row">
                            <div class="card tabbing">
                                                      
                                <div class="container">    
                                    <div class="card-header setcard">
                                        <div class="floatsright">                    
                                            @auth
                                                @if($logged_in_user->id != $alluserData->id)
                                                    <button class="add_to_fav btn fav-icn {{$sp_fav?'isfav':''}}" id="AddToFav"   >
                                                        @if($sp_fav)
                                                            <span class="heart_symbol">
                                                                <i class="fas fa-heart"></i>
                                                            </span>   
                                                            <span class="fav-text">@lang('strings.new.added_fav')</span>
                                                        @else
                                                            <span class="heart_symbol">
                                                                <i class="far fa-heart"></i>
                                                            </span>   
                                                            <span class="fav-text">@lang('strings.new.add_fav')</span>
                                                        @endif
                                                    </button>
                                                @endif
                                               
                                                @if ($fromuserData==1 && $logged_in_user->id != $alluserData->id)
                                                    <a href="{{ route('frontend.user.feedback',$slug) }}" class="btn b-gd">
                                                    <i class="far fa-comment-alt"></i>
                                                    @lang('strings.new.add_feedback')</a>
                                                @endif
                                                @if($logged_in_user->id != $alluserData->id)
                                                    @if($isonline == 1)
                                                        <button class="btn btn-primary chat message_chat b-gd" id="quickmessage">
                                                        <i class="fas fa-comments"></i>@lang('strings.new.chat')
                                                        </button>
                                                    @else
                                                        <button class="btn send_message message_chat b-gd" id="quickmessage">
                                                        <i class="fab fa-telegram-plane"></i>@lang('strings.new.send_message')
                                                         </button>
                                                    @endif
                                                @endif 
                                            @endauth
                                            @guest
                                                <button class="add_to_fav btn fav-icn" onclick="openLogin()" >
                                                    <span class="heart_symbol">
                                                        <i class="far fa-heart"></i>
                                                    </span>   
                                                    @lang('strings.new.add_fav')
                                                </button>
                                                <a href="#" class="btn b-gd" onclick="openLogin()">
                                                 <i class="far fa-comment-alt"></i>
                                                @lang('strings.new.add_feedback')</a>
                                                
                                                @if($isonline == 1)
                                                <button class="btn b-gd chat message_chat b-gd" onclick="openLogin()">
                                                    <i class="fas fa-comments"></i>@lang('strings.new.chat')
                                                 </button>
                                                @else
                                                <button class="btn b-gd send_message message_chat b-gd" onclick="openLogin()">
                                                    <i class="fab fa-telegram-plane"></i>@lang('strings.new.send_message')
                                                 </button>
                                                @endif
                                            @endguest                          
                                        </div>
                                    </div>
                                </div> 
                                                      
                                <div class="card-body no-p">
                                    <div role="tabpanel">
                                        <div class="container">    
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a href="#profile" class="nav-link <?php if($flag!='feedback'){ ?>active <?php } ?>" aria-controls="profile" role="tab" data-toggle="tab">@lang('navs.frontend.user.profile')</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#photo" class="nav-link" aria-controls="photo" role="tab" data-toggle="tab">@lang('strings.new.photo')</a>
                                                </li>
                                                {{-- <li class="nav-item">
                                                    <a href="#services" class="nav-link" aria-controls="services" role="tab" data-toggle="tab">@lang('strings.new.services')</a>
                                                </li> --}}
                                                <li class="nav-item">
                                                    <a href="#feedback" class="nav-link <?php if($flag=='feedback'){ ?>active <?php } ?>" aria-controls="feedback" role="tab" data-toggle="tab">@lang('strings.new.feedback')</a>
                                                </li>                           
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade show pt-3 full-part-tab <?php if($flag!='feedback'){ ?>active<?php } ?>" id="profile" aria-labelledby="profile-tab">
                                                @include('frontend.userdetailsTab.profile')
                                            </div><!--tab panel profile-->

                                            <div role="tabpanel" class="photo-tab-pane tab-pane fade show pt-3 full-part-tab" id="photo" aria-labelledby="photo-tab">
                                                @include('frontend.userdetailsTab.photo')
                                            </div><!--tab panel photo-->

                                            {{-- <div role="tabpanel" class="services-tab-pane tab-pane fade show pt-3" id="services" aria-labelledby="services-tab">
                                                @include('frontend.userdetailsTab.services')
                                            </div> --}}

                                            <div role="tabpanel" class="feedback-tab-pane tab-pane fade show pt-3 <?php if($flag=='feedback'){ ?>active <?php } ?>" id="feedback" aria-labelledby="feedback-tab">
                                                @include('frontend.userdetailsTab.feedback')
                                            </div><!--tab panel photo-->

                                        </div><!--tab content-->
                                    </div><!--tab panel-->
                                </div><!--card body-->
                            </div><!-- card -->
                        </div>
                </div><!-- col-xs-12 -->
            </div><!-- row -->    
    </div>
    <div id="quickmessage-model" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Message  to {{ !empty($alluserData->first_name) ? $alluserData->first_name:""  }} {{ !empty($alluserData->last_name) ? $alluserData->last_name : ""  }}

                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <label for="send-quickmessage">Message</label>
                    <textarea class="form-control" id="send-quickmessage"   rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default " id="send-quick-message">Send</button>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
@push('after-scripts')
      
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on("click", "#quickmessage", function(){
                $('#quickmessage-model').modal('show');
            }); 

            $(document).on("click", "#send-quick-message", function(){
                axios.post(Laravel.siteUrl + '/sendQuickMessage/'+ {{ $alluserData->id }}, {                    
                    message: $("#send-quickmessage").val(),
                })
                .then(function (response) {
                    if(response.status===200){
                        alert("message Send Successfully");                       
                        //vm.$modal.hide('model-quickmessage');
                        $('#quickmessage-model').modal('hide');
                        window.location.replace(Laravel.siteUrl + '/inbox');
                    }
                })
                .catch(function (error) {
                   window.location.replace(Laravel.siteUrl + '/login');
                });
            });


            $(document).on("click", "#AddToFav", function(){

                var vm = this;
                axios.get(Laravel.siteUrl + '/AddToFav/'+ {{ $alluserData->id }}).then(response => {
                    if(response.data.data.status){
                        if(response.data.data.remove_fav){
                            $(vm).removeClass('isfav');
                            $(".heart_symbol").html('<i class="far fa-heart"></i>');
                            $(".fav-text").text("{{ __('strings.new.add_fav') }}");
                        }
                        if(response.data.data.add_fav){
                            $(vm).addClass('isfav');
                            $(".heart_symbol").html('<i class="fas fa-heart"></i>');
                            $(".fav-text").text("{{ __('strings.new.added_fav') }}");
                        }
                       // alert(response.data.data.message);
                    }else{
                        //alert(response.data.data.message)
                    }
                    //console.log(response.data.data);                
                })
                .catch(function (error) {
                   console.log(response)
                });
            });
        });
    </script>
@endpush
