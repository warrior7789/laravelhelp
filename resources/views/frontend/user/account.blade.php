@extends('frontend.layouts.app')

@section('content')
    
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
                                {{-- {{ $ads['top']['title'] }} --}}                      
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
            <div class="col col-sm-12 align-self-center">
                <div class="row">    
                    <div class="card set-part">
                        <div class="card-header title-card">
                            @lang('navs.frontend.user.account')
                        </div>

                        <div class="card-body account-page">
                            <div role="tabpanel">
                                <ul class="nav nav-tabs" id="account_tabs" role="tablist">
                                    <li class="nav-item">
                                        <a href="#profile" class="nav-link " aria-controls="profile" role="tab" data-toggle="tab">@lang('navs.frontend.user.profile')</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#edit" class="nav-link active" aria-controls="edit" role="tab" data-toggle="tab">@lang('labels.frontend.user.profile.update_information')</a>
                                    </li>
                                    @if($logged_in_user->is_sp == 1)
                                        <li class="nav-item">
                                            <a href="#skill_list" class="nav-link" aria-controls="skill_list" role="tab" data-toggle="tab">@lang('strings.new.skill_list')</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sp_availability" class="nav-link" aria-controls="sp_availability" role="tab" data-toggle="tab">@lang('strings.new.sp_availability')</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="#sp_photogallary" class="nav-link" aria-controls="sp_photogallary" role="tab" data-toggle="tab">@lang('strings.new.sp_photogallary')</a>
                                        </li>
                                    @endif

                                    @if($logged_in_user->canChangePassword())
                                        <li class="nav-item">
                                            <a href="#password" class="nav-link" aria-controls="password" role="tab" data-toggle="tab">@lang('navs.frontend.user.change_password')</a>
                                        </li>
                                    @endif
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade show  pt-3" id="profile" aria-labelledby="profile-tab">
                                        @include('frontend.user.account.tabs.profile')
                                    </div><!--tab panel profile-->

                                    <div role="tabpanel" class="tab-pane fade show active pt-3" id="edit" aria-labelledby="edit-tab">
                                        @include('frontend.user.account.tabs.edit')
                                    </div><!--tab panel profile-->

                                    @if($logged_in_user->is_sp == 1)
                                        <div role="tabpanel" class="tab-pane fade show  pt-3" id="skill_list" aria-labelledby="skill_list-tab">
                                            @include('frontend.user.account.tabs.skill')
                                        </div>
                                        
                                        <div role="tabpanel" class="tab-pane fade show  pt-3" id="sp_availability" aria-labelledby="sp_availability-tab">
                                            @include('frontend.user.account.tabs.sp_availability')
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade show  pt-3" id="sp_photogallary" aria-labelledby="sp_photogallary-tab">
                                            @include('frontend.user.account.tabs.sp_photogallary')
                                        </div>
                                    @endif

                                    @if($logged_in_user->canChangePassword())
                                        <div role="tabpanel" class="tab-pane fade show pt-3" id="password" aria-labelledby="password-tab">
                                            @include('frontend.user.account.tabs.change-password')
                                        </div><!--tab panel change password-->
                                    @endif
                                </div><!--tab content-->
                            </div><!--tab panel-->

                            <div class="panel-group" id="account_accordion" role="tablist" aria-multiselectable="true"></div>
                        </div><!--card body-->
                    </div><!-- card -->
                </div>
            </div>
            <!-- col-xs-12 -->
      
        <!-- row -->
        <!-- delete from model -->
        <div class="modal" id="confirm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
    </div>
@endsection
@push('after-scripts')

    <script>

        var hash = window.location.hash;
        if(hash != "" || hash != undefined){
            $(".account-page ul a").each(function(){
                if($(this).attr("href") == hash){
                    $(this).click();
                }
            });
        }

        // $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
        $('body').on('click', '.delete-skill', function(e){
            e.preventDefault();
            var $form=$(this).parent("form");
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .on('click', '#delete-btn', function(){
                    $form.submit();
                });
        });

        $('body').on('click', '.delete-photo', function(e){
            e.preventDefault();
            var $form=$(this).parent("form");
            $('#confirm').modal({ backdrop: 'static', keyboard: false })
                .on('click', '#delete-btn', function(){
                    $form.submit();
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
                    window.location.href = "{{ route('frontend.user.dashboard') }}";
                })
            }
        });


        /* accordion.js */

        getAccordion("#account_tabs",768);

        function getAccordion(element_id,screen) 
        {            
            // $(window).resize(function () { location.reload(); });

            if ($(window).width() < screen) 
            {
                var concat = '';
                obj_tabs = $( element_id + " li" ).toArray();
                obj_cont = $( ".tab-content .tab-pane" ).toArray();
                jQuery.each( obj_tabs, function( n, val ) 
                {
                    concat += '<div id="' + n + '" class="panel panel-default">';
                    concat += '<div class="panel-heading" role="tab" id="heading' + n + '">';
                    concat += '<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#account_accordion" href="#collapse' + n + '" aria-expanded="false" aria-controls="collapse' + n + '">' + val.innerText + '</a></h4>';
                    concat += '</div>';
                    concat += '<div id="collapse' + n + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + n + '" data-parent="#account_accordion">';
                    concat += '<div class="panel-body">' + obj_cont[n].innerHTML + '</div>';
                    concat += '</div>';
                    concat += '</div>';
                });
                $("#account_accordion").html(concat);
                $("#account_accordion").find('.panel-collapse:first').addClass("in");
                $("#account_accordion").find('.panel-title a:first').attr("aria-expanded","true");
                $(element_id).remove();
                $(".tab-content").remove();
            }   
        }

        $("#account_accordion").on("click", "h4 a", function(){
            var id = $(this).attr("href");
            if(!$(id).hasClass("show")){
                $('html, body').animate({
                    scrollTop: $(id).offset().top + 200
                }, 100);
            }
        });
    </script>

@endpush
