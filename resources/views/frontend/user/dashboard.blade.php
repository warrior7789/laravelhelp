@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
    <div class="container">

            @if($logged_in_user->is_sp != 1)
                <div class="switch_btn">
                    <button type="button" class="btn btn-info btn-lg switch_to_sp" >Switch to Serviceprovider</button>
                </div>
            @else
                <div class="switch_btn">
                    <button type="button" class="btn btn-info btn-lg switch_to_cs">Remove from Service Provider</button>
                </div>
            @endif
            <div class="card deshbord">
                <div class="card-header title-card">
                    <i class="fas fa-tachometer-alt"></i> @lang('navs.frontend.dashboard')
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-4 col-sm-12 order-1 order-sm-2  mb-4">
                            <div class="card mb-4 bg-light">
                                @php
                                    $avatar_path = "/storage/avatars/dummy.png";
                                    if($logged_in_user->avatar_type=='storage'){
                                        if(!empty($logged_in_user->avatar_location)){
                                            $avatar_path = Storage::disk('public')->url($logged_in_user->avatar_location);
                                        }
                                    }
                                    if($logged_in_user->avatar_type!='storage' || $logged_in_user->avatar_type!='gravatar'){
                                        if(!empty($logged_in_user->avatar)){
                                            $avatar_path = $logged_in_user->avatar;
                                        }
                                    }
                                @endphp
                                <img class="card-img-top" src="{{ $avatar_path }}" alt="Profile Avatar">
                                <!-- <img class="card-img-top" src="{{ $logged_in_user->picture }}" alt="Profile Picture"> -->

                                <div class="card-body my-account">
                                    <h4 class="card-title">
                                        {{ $logged_in_user->name }}<br/>
                                    </h4>

                                    <p class="card-text">
                                            <i class="fas ac-icon fa-envelope"></i> {{ $logged_in_user->email }}<br/>
                                            <i class="fas ac-icon fa-calendar-check"></i> @lang('strings.frontend.general.joined') {{ timezone()->convertToLocal($logged_in_user->created_at, 'F jS, Y') }}
                                    </p>

                                    <p class="card-text">

                                        <a href="{{ route('frontend.user.account')}}" class="btn myaccount btn-info btn-sm mb-1">
                                            <i class="fas fa-user-circle"></i> @lang('navs.frontend.user.account')
                                        </a>

                                        @can('view backend')
                                            &nbsp;<a href="{{ route('admin.dashboard')}}" class="btn btn-danger btn-sm mb-1">
                                                <i class="fas fa-user-secret"></i> @lang('navs.frontend.user.administration')
                                            </a>
                                        @endcan
                                    </p>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">Header</div>
                                <div class="card-body">
                                    <h4 class="card-title">Info card title</h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div><!--card-->
                        </div><!--col-md-4-->

                        <div class="col-md-8 order-2 order-sm-1">                           

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card-header">@lang('strings.new.fav_provider_list')</div>
                                    <div class="card-body">
                                        <favsp></favsp> 
                                    </div>          
                                </div>
                                
                            </div><!--row-->
                        </div><!--col-md-8-->
                    </div><!-- row -->
                </div> <!-- card-body -->
            </div><!-- card -->
            
            @if($logged_in_user->is_sp != 1 && !empty($logged_in_user->confirmation_code))

                <div class="modal fade" id="switch_user" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Choose Profile</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <button type="button" class="btn btn-default switch_to_cs_close" data-dismiss="modal">Continue as a Customer</button>
                                <span class="or">OR</span>
                                <button type="button" class="btn btn-default switch_to_sp" id="switch_to_sp">Switch to ServiceProvider</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

            @endif
    </div><!-- row -->
@endsection


@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            if($("#switch_user").length != 0) {
                $('#switch_user').modal('show');
            }

            $('#switch_user').on("hidden.bs.modal", function(){
                $.get("{{ route('frontend.profile.removeConfirmationCode') }}",{},function(resp){
                });
            });
        });

        $(document).on('click', '.switch_to_sp',function(){
            $('.container-fluid-custom .alert').remove();
            if(confirm('Are You sure You want to be a service Provider?')){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.post("{{ route('frontend.user.profile.switchuser') }}",{convert_to:'sp',_token: CSRF_TOKEN},function(resp){
                    $('#switch_user').modal('hide');
                    var data = jQuery.parseJSON(resp);
                    if(data.status == 1){
                        $('.container-fluid-custom').prepend('<div role="alert" class="alert alert-success"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>'+data.msg+'</div>');
                    }else{
                        $('.container-fluid-custom').prepend('<div role="alert" class="alert alert-danger"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>'+data.msg+'</div>');
                    }
                    window.location.href = "{{ route('frontend.user.account') }}";
                })
                
            }
        });
        $(document).on('click', '.switch_to_cs',function(){
            $('.container-fluid-custom .alert').remove();
            if(confirm('Are You sure You want to be a customer?')){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.post("{{ route('frontend.user.profile.switchuser') }}",{convert_to:'cs',_token: CSRF_TOKEN},function(resp){
                    $('#switch_user').modal('hide');
                    var data = jQuery.parseJSON(resp);
                    if(data.status == 1){
                        $('.container-fluid-custom').prepend('<div role="alert" class="alert alert-success"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>'+data.msg+'</div>');
                    }else{
                        $('.container-fluid-custom').prepend('<div role="alert" class="alert alert-danger"><button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>'+data.msg+'</div>');
                    }
                    location.reload();
                    
                })
                
            }
        });
    </script>
@endpush