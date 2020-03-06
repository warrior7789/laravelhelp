{{ html()->modelForm($logged_in_user, 'PATCH', route('frontend.user.profile.update'))->class('form-horizontal frmupdateprofile')->attribute('enctype', 'multipart/form-data')->attribute('id', 'profile-update')->open() }}    
    <input type="hidden" name="id" value="{{ $logged_in_user->id}}">

<div class="row">
    <div class="col-md-12" id="Ajaxerror">
        <div class="alert-danger Ajaxerror"></div>
    </div>

    @if ($logged_in_user->is_sp == 3)       
        <div class="col-md-12">
            <div class="form-group">
                {{ html()->label(__('strings.frontend.select_role'))->for('is_sp') }}
                <div>
                    <input type="radio" name="is_sp" value="1"  checked /> Service Provider
                    <input type="radio" name="is_sp" value="0" />  Customer
                </div>
            </div><!--form-group-->            
        </div><!--col-->        
    @else
        <div class="col-md-12">
            <input type="hidden" name="is_sp" value="{{ $logged_in_user->is_sp }}">
        </div>
    @endif

    @if ($logged_in_user->is_sp ==1 || $logged_in_user->is_sp ==3)                   
        <div class="col-md-12">
            <div class="form-group">               
                @if ($logged_in_user->slug == NULL)                
                    <div class="form-group">
                        {{ html()->label(__('strings.new.profileurl').' ('.__('strings.new.profileurlnote').')')->for('slug') }}

                        <div>
                            <input type="text" name="slug" class="form-control slugtext" autocomplete="off" id="slug" value="{{ $logged_in_user->first_name}}-{{ $logged_in_user->last_name }}" required>
                           
                        </div>
                        <span>{{ __('strings.new.profileurl') }} : {{ $_ENV['APP_URL'] }}/profile/<span id="slugchange">{{ $logged_in_user->first_name}}-{{ $logged_in_user->last_name }}</span></span>

                    </div><!--form-group-->                    
                @else
                    <span>{{ __('strings.new.profileurl') }} : <a href="{{ route('frontend.profile.slug',$logged_in_user->slug) }}" target="_blank" title="View Profile">{{ $_ENV['APP_URL'] }}/profile/{{ $logged_in_user->slug }}</a></span>
                @endif
                <p class="help-block help-block-error text-danger slug-exist"></p>
            </div><!--form-group-->
        </div><!--col-->
    @endif

    <div class="col-md-6">                        
        <!-- <div class="col-md-12"> -->
            <input type="hidden" name="avatar_type" value="storage">
            <div class="form-group" id="avatar_location">
                {{ html()->label(__('strings.new.profile_image'))->for('avatar') }}
                {{ html()->file('avatar_location')->class('form-control')->attribute('id', "avatar_location_file") }}            
            </div><!--form-group-->
            <input type="hidden" id="avtar_image" name="avtar_image">
            <input type="hidden" id="remove_profile_image" name="remove_profile_image" value="0">
        <!-- </div>
        <div class="col-md-12"> -->
            <div class="row preview" >
                <div class="col-md-12 text-center upload-demo" style="display: none">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="upload-demo" ></div>                        
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="upload-image" style="margin-top:2%">crope</button>
                        </div>
                    </div>
                </div> 
                <div class="col-md-12 preview-crop-image">
                    <div class="row"> 
                        <div class="col-xl-6 col-lg-8 col-md-10">
                            <div id="preview-crop-image" >
                                @if($logged_in_user->avatar_type == "storage")
                                    @if( !empty($logged_in_user->avatar_location))
                                        <img src="/storage/{{ $logged_in_user->avatar_location }}">
                                    @else
                                        <img src="/storage/avatars/dummy.png">
                                    @endif
                                @else
                                    <img src="/storage/avatars/dummy.png">
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-md-2">
                            <div class="row"> 
                            @if( !empty($logged_in_user->avatar_location))
                                <span id="remove_avtar" class="remove_button"><i class="fas fa-trash-alt" style="font-size:30px;color:red"></i></span>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            </div> 
        <!-- </div> -->        
    </div>
    
    <div class="col-md-6">
        @if ($logged_in_user->is_sp ==1 || $logged_in_user->is_sp ==3)
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group sp_profile">
                        {{ html()->label(__('strings.new.banner_image'))->for('banner_image') }}
                        {{ html()->file('banner_image')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if(!empty($logged_in_user->profile->banner_image))
                    <div class="row">
                        <div class="col-xl-9 col-md-10 banner_div">
                            <img id="banner_div_image" src="/spbanner/{{$logged_in_user->id}}/{{ $logged_in_user->profile->banner_image }}" width="100%" height="200px">
                            
                        </div>
                        <div class="col-xl-2 col-md-2">
                            <span id="remove_banner" class="only-mb remove_button"><i class="fas fa-trash-alt" style="font-size:30px;color:red"></i></span>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-xs-8 col-md-10 banner_div">  
                            <img  src="/spbanner/default-banner.jpg" id="banner_div_image" width="100%" height="200px" />
                        </div>
                    </div>
                @endif
                <input type="hidden" id="remove_profile_banner" name="remove_profile_banner" value="0">
            </div>
        @endif        
    </div>

    <div class="col-md-6">
        <div class="form-group required">
            {{ html()->label(__('validation.attributes.frontend.first_name'))->class('control-label')->for('first_name') }}

            {{ html()->text('first_name')
                ->class('form-control')
                ->placeholder(__('validation.attributes.frontend.first_name'))
                ->attribute('maxlength', 191)
                ->attribute('autocomplete', 'off')
                ->required()
                ->autofocus() }}
        </div><!--form-group-->
    </div><!--col-->
    
    <div class="col-md-6">
        <div class="form-group required">
            {{ html()->label(__('validation.attributes.frontend.last_name'))->class('control-label')->for('last_name') }}

            {{ html()->text('last_name')
                ->class('form-control')
                ->placeholder(__('validation.attributes.frontend.last_name'))
                ->attribute('maxlength', 191)
                ->required() }}
        </div><!--form-group-->
    </div><!--col-->

    @if ($logged_in_user->canChangeEmail())        
        <div class="col-md-6">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> @lang('strings.frontend.user.change_email_notice')
            </div>
            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                {{ html()->email('email')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.email'))
                    ->attribute('maxlength', 191)
                    ->required() }}
            </div><!--form-group-->
        </div><!--col-->        
    @endif

    @if ($logged_in_user->is_sp ==1 || $logged_in_user->is_sp ==3)
    <div class="col-md-12">   
        <div class="sp_profile row">            
            <div class="col-md-6">
                <div class="form-group required">
                    {{ html()->label(__('strings.new.phone'))->class('control-label')->for('phone') }}

                    <input type="text" class="form-control" id="phone" name="phone"  placeholder= "{{ __('strings.new.enter_phone') }}" value="{{ !empty($logged_in_user->profile->phone) ? $logged_in_user->profile->phone : '' }}" />               
                </div><!--form-group-->
            </div><!--col-->

            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label(__('strings.new.experience'))->class('control-label')->for('experience') }}

                    <input type="text" class="form-control allownumericwithoutdecimal" id="experience" name="experience"  placeholder= "{{ __('strings.new.enter_experience') }}" value="{{ !empty($logged_in_user->profile->experience) ? $logged_in_user->profile->experience : '' }}" />               
                </div><!--form-group-->
            </div><!--col-->
            
            <div class="col-md-12">
                <div class="form-group">
                    {{ html()->label(__('strings.new.about'))->for('about') }}                   
                    <textarea  rows="6" name="about" class="form-control" >{{ !empty($logged_in_user->profile->about) ? $logged_in_user->profile->about : '' }}</textarea>
                </div><!--form-group-->
            </div><!--col-->
           
            <input type="hidden" name="address" id="address" value="{{ !empty($logged_in_user->profile->address) ? $logged_in_user->profile->address : '' }}">
            
            <div class="col-md-12">
                <div id="locationField" class="form-group">
                    {{ html()->label(__('strings.new.address_auto'))->for('autocomplete') }}
                    <input id="autocomplete" placeholder="{{ __('strings.new.address_autocomplete') }}"  onFocus="geolocate()" type="text" class="form-control"  />
                </div>
            </div>

            <div class="col-md-12">
                <table id="addresse" class="table">
                    <tr>
                        <td class="label">{{ __('strings.new.street_address') }}</td>
                        <td class="slimField">
                            <input type="text" class="field" id="street_number" name="street_number" />
                        </td>
                        <td class="wideField" colspan="3">
                            <input type="text"  class="field" id="route" name="route" value="{{ !empty($logged_in_user->profile->address) ? $logged_in_user->profile->address : '' }}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label asterisk">{{ __('strings.new.city') }}</td>
                        <td class="wideField" colspan="3">
                            <input class="field" id="locality" name="city"  value="{{ !empty($logged_in_user->profile->city) ? $logged_in_user->profile->city : '' }}" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label asterisk">{{ __('strings.new.state') }}</td>
                        <td class="slimField">
                            <input type="text" class="field" name="state"  id="administrative_area_level_1"  value="{{ !empty($logged_in_user->profile->state) ? $logged_in_user->profile->state : '' }}" />
                        </td>
                        <td class="label asterisk lblzipcode">{{ __('strings.new.zip_code') }}</td>
                        <td class="wideField">
                            <input type="text" class="field" id="postal_code" name="pincode"  value="{{ !empty($logged_in_user->profile->pincode) ? $logged_in_user->profile->pincode : '' }}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label asterisk">{{ __('strings.new.country') }}</td>
                        <td class="wideField" colspan="3">
                            <input type="text" class="field" id="country" name="country"  value="{{ !empty($logged_in_user->profile->country) ? $logged_in_user->profile->country : '' }}" /></td>
                    </tr>
                     <tr>
                        <td class="label">{{ __('strings.new.latitude') }}</td>
                        <td class="wideField">
                            <input type="text" class="field" name="latitude"  id="latitude"  value="{{ !empty($logged_in_user->profile->latitude) ? $logged_in_user->profile->latitude : '' }}" />
                        </td>
                        <td class="label lbllongitudes">{{ __('strings.new.longitudes') }}</td>
                        <td class="wideField">
                            <input type="text" class="field" id="longitudes" name="longitudes"  value="{{ !empty($logged_in_user->profile->longitudes) ? $logged_in_user->profile->longitudes : '' }}" />
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-12">
                <div class="mt-map-wrapper">
                    <div class="mt-map propmap" id="map">            
                    </div>
                </div>
            </div>

            <input type="hidden" name="profile_id" value="{{ !empty($logged_in_user->profile->id) ? $logged_in_user->profile->id : '' }}">

            <div class="col-md-12">
            <div id="infoPanel">
                <b>{{ __('strings.new.marker_status_text') }}</b>
                <div id="markerStatus"><i>{{ __('strings.new.marker_status') }}</i></div>   
            </div>
            </div>

            <div class="col-md-12">
                <div id="infoPanel">                
                    <h4>{{ __('strings.new.social_media_text') }}</h4>  
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label(__('strings.new.social_media_facebook'))->for('facebook') }}

                    <input type="text" class="form-control field" id="facebook" name="facebook"  value="{{ !empty($logged_in_user->profile->facebook) ? $logged_in_user->profile->facebook : '' }}" />                    
                </div><!--form-group-->
            </div><!--col-->
            
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label(__('strings.new.social_media_twitter'))->for('twitter') }}

                    <input type="text" class="form-control field" id="twitter" name="twitter"  value="{{ !empty($logged_in_user->profile->twitter) ? $logged_in_user->profile->twitter : '' }}" />
                </div><!--form-group-->
            </div><!--col-->

            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label(__('strings.new.social_media_linkedin'))->for('linkedin') }}
                    <input type="text" class="form-control field" id="linkedin" name="linkedin"  value="{{ !empty($logged_in_user->profile->linkedin) ? $logged_in_user->profile->linkedin : '' }}" />
                </div><!--form-group-->
            </div><!--col-->
            
            <div class="col-md-6">
                <div class="form-group">
                    {{ html()->label(__('strings.new.social_media_instagram'))->for('instagram') }}
                    <input type="text" class="form-control field" id="instagram" name="instagram"  value="{{ !empty($logged_in_user->profile->instagram) ? $logged_in_user->profile->instagram : '' }}" />
                </div><!--form-group-->
            </div><!--col-->
        </div>
    </div>
    @endif

    <div class="col-md-12">
        <div class="form-group mb-0 clearfix update-btn">
            {{ form_submit(__('labels.general.buttons.update')) }}
        </div><!--form-group-->
    </div><!--col-->    
</div>
{{ html()->closeModelForm() }}

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="/css/croppie.css">
    
    <style type="text/css">       
        .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
        }
        
        .field {
            width: 99%;
        }
        .slimField {
            width: 80px;
        }
        .wideField {
            width: 200px;
        }       

        .mt-map-container {
            width: 71.4%;
            padding-bottom: 41.6%;
            height: 200px;
            overflow:hidden;
            position:relative;
        }

        .mt-map {
            width: 100%;
            height: auto;
            left: 0;
            
            position: sticky;
        }

        .form-group.required .control-label:after,.asterisk:after {
          content:"*";
          color:red;
        }
    </style>
@endpush

@push('after-scripts')

<script type="text/javascript" src="/js/croppie.js"></script>

<script type="text/javascript">
    $(document).ready(function(){        
        initialize();
        $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        //Start code for upload profile image
        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,    
            viewport: { // Default { width: 100, height: 100, type: 'square' } 
                width: 250,
                height: 250,
                type: 'circle' //square
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#avatar_location_file').on('change', function () {
            $("#remove_profile_image").val("0");
            $(".upload-demo").show();            
            $(".preview-crop-image").hide();
            var reader = new FileReader();
            reader.onload = function (e) {
              resize.croppie('bind',{
                url: e.target.result
              }).then(function(){
                console.log('jQuery bind complete');
              });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.upload-image').on('click', function (ev) {
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (img) {            
                html = '<img src="' + img + '" />';
                $("#preview-crop-image").html(html);
                $("#preview-crop-image").show();
                $(".upload-demo").hide();            
                $(".preview-crop-image").show();
                $("#avtar_image").val(img);
            
            });
        });
        //End code for upload profile image

        // remove avtar and banner 
        $('#remove_avtar').on('click', function (ev) {        
            $("#remove_profile_image").val("1");
            var html = '<img src="/storage/avatars/dummy.png" />';
            $("#preview-crop-image").html(html);
        });

        $('#remove_banner').on('click', function (ev) {
            $("#remove_profile_banner").val("1");
            var html = '<img id="banner_div_image" src="/spbanner/default-banner.jpg" width="100%" height="200px" /> ';
            $(".banner_div").html(html);
        });
        // End of remove avtar and banner 

        //code of change banner image
        $('#banner_image').on('change', function () {            
            $("#remove_profile_banner").val("0");
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#banner_div_image').attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);

         });
        //End code of change banner image

        //Changed profile slug
        @if ($logged_in_user->slug == NULL)
            $('#slug').keyup(function(){                     
                var slug = $(this).val();
                $("#slugchange").html(slug);
                if(slug.length < 4)
                    return false;
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('frontend.user.profile.checkSlug') }}",
                    type: "POST",
                    data: { slug : slug ,_token: CSRF_TOKEN},                
                    success: function(result)
                    {
                        if(result!='')
                        {
                            $(".slug-exist").html('Slug Already Exist');
                        }
                        else
                        {
                            $(".slug-exist").html('');
                        }
                    }
                });                
            });
        @endif
        //End code of changed profile slug
    });
    

    

    $(function() {
        var avatar_location = $("#avatar_location");
        // if ($('input[name=avatar_type]:checked').val() === 'storage') {
        //     avatar_location.show();
        // } else {
        //     avatar_location.hide();
        // }
        $('input[name=avatar_type]').change(function() {
            if ($(this).val() === 'storage') {
                avatar_location.show();
            } else {
                avatar_location.hide();
            }
        });

        // if radio button change
        $('input:radio[name=is_sp]').change(function () {           
            if ($("input[name='is_sp']:checked").val() == 1) {                
                $(".sp_profile").show();
            }else{
                $(".sp_profile").hide();                
            }            
        });
    });


    var geocoder;

    function geocodePosition(pos) {
      geocoder.geocode({
        latLng: pos
      }, function(responses) {

        console.log(responses);

        if (responses && responses.length > 0) {
            updateMarkerAddress(responses[0].formatted_address);
            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // document.getElementById('locality').value = '';
            // document.getElementById('locality').disabled = false;

            for (var i = 0; i < responses[0].address_components.length; i++) {
                var addressType = responses[0].address_components[i].types[0];
                
                console.log("drage value");
                console.log("addressType" + addressType);

                console.log(responses[0].address_components[i]);
                if (componentForm[addressType]) {
                    var val = responses[0].address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;                    
                }

                if(addressType == "postal_town"){
                    //console.log(place.address_components[i]);
                    var val = responses[0].address_components[i]["long_name"];
                    //alert(val);
                    document.getElementById('locality').value = val;
                }
                //locality: 'long_name',
                if(addressType == "locality"){
                    //console.log(place.address_components[i]);
                    var val = responses[0].address_components[i]["long_name"];
                   // alert(val);
                    document.getElementById('locality').value = val;
                }
            }
        } else {
          updateMarkerAddress('Cannot determine address at this location.');
        }
      });
    }

    function updateMarkerStatus(str) {
      document.getElementById('markerStatus').innerHTML = str;
    }

    function updateMarkerPosition(latLng) {
        $('#latitude').val(latLng.lat());
        $('#longitudes').val(latLng.lng());
      // document.getElementById('info').innerHTML = [
      //   latLng.lat(),
      //   latLng.lng()
      // ].join(', ');
    }

    function updateMarkerAddress(str) {
      //document.getElementById('address').innerHTML = str;
      //document.getElementById('autocomplete').value = str;
      $('#autocomplete').val(str);
      $('#address').val(str);
      //initAutocomplete();
    }

    function initialize() {
        @if(!empty($logged_in_user->profile->longitudes))
            initMap();
        @endif

        initAutocomplete();
    }

    var placeSearch, autocomplete,postal_town;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',            
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initMap() {
        $('.mt-map').css('height','300px');
        var latLng = new google.maps.LatLng( {{ !empty($logged_in_user->profile->latitude) ? $logged_in_user->profile->latitude : $_ENV['LAT'] }}, {{ !empty($logged_in_user->profile->longitudes) ? $logged_in_user->profile->longitudes : $_ENV['LNG'] }}); 
        
        console.log('latLng');
        console.log(latLng);

        var mapOptions = {
          zoom: 18,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          mapTypeControl: true,
          center: latLng,
          fullscreenControl: false 
        }

        map1 = new google.maps.Map(document.getElementById("map"), mapOptions);
        var marker = new google.maps.Marker({
            position: latLng, 
            map: map1,
            title: 'Point A',
            draggable: true,
            animation: google.maps.Animation.DROP,

        });

        // Update current position info.
          geocoder = new google.maps.Geocoder();
          //updateMarkerPosition(latLng);
          //geocodePosition(latLng);

          // Add dragging event listeners.
          google.maps.event.addListener(marker, 'dragstart', function() {
            updateMarkerAddress('Dragging...');
          });

          google.maps.event.addListener(marker, 'drag', function() {
            updateMarkerStatus('Dragging...');
            updateMarkerPosition(marker.getPosition());
          });

          google.maps.event.addListener(marker, 'dragend', function() {
            updateMarkerStatus('Drag ended');

            geocodePosition(marker.getPosition());
          });
        //initAutocomplete();
    }

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        
        autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        console.log('place');
        console.log(place);
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#latitude').val(lat);
        $('#longitudes').val(lng);

        var latLng = new google.maps.LatLng(lat, lng);
       // $('#longitudes').val()  =  place.geometry.location.lng();

        
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        document.getElementById('locality').value = '';
        document.getElementById('locality').disabled = false;

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            console.log("addressType");
            console.log(addressType);
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
               // if(addressType == "postal_town") 
                   // document.getElementById('locality').value = val;                   
            }

            if(addressType == "postal_town"){
                //console.log(place.address_components[i]);
                var val = place.address_components[i]["long_name"];
                //alert(val);
                document.getElementById('locality').value = val;
            }
            //locality: 'long_name',
            if(addressType == "locality"){
                //console.log(place.address_components[i]);
                var val = place.address_components[i]["long_name"];
               // alert(val);
                document.getElementById('locality').value = val;
            }
        }

        $('#address').val($('#autocomplete').val());

        $('.mt-map').css('height','300px');
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: latLng,
          mapTypeId: 'terrain'
        });

        var marker = new google.maps.Marker({
            position: latLng, 
            map: map,
            title: 'Point A',
            draggable: true,
            animation: google.maps.Animation.DROP,

        });

        geocoder = new google.maps.Geocoder();
        
        updateMarkerPosition(latLng);
        
        //geocodePosition(latLng);

        // Add dragging event listeners.
        google.maps.event.addListener(marker, 'dragstart', function() {
            updateMarkerAddress('Dragging...2');
        });

        google.maps.event.addListener(marker, 'drag', function() {
            updateMarkerStatus('Dragging...2');
            updateMarkerPosition(marker.getPosition());
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            updateMarkerStatus('Drag ended');
            console.log("marker.getPlace");
            console.log(marker.getPosition());
            geocodePosition(marker.getPosition());
        });
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
            autocomplete.setBounds(circle.getBounds());
            });
        }
    }

    
    //$('#submitdddddd').click(function(e){
    var cansubmit =0;    
    $('#profile-update').submit(function(e) {
        if(cansubmit == 0){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('frontend.user.profile.AjaxValidation') }}",
                method: 'post',
                data: $('form#profile-update').serialize(),
                success: function(data){
                   // alert("all goes well");
                    // alert("asdfdsaf");
                    // $.each(data.responseJSON.errors, function(key, value){
                    //     console.log(value);
                    //     $('.alert-danger').show();
                    //     $('.alert-danger').append('<p>'+value+'</p>');
                    // });

                    $('form#profile-update').trigger('submit');
                    cansubmit = 1;
                    $('#profile-update button[type=submit]').removeAttr("disabled");
                },
                error: function(data){
                    console.log(data.responseJSON);
                    $('#profile-update button[type=submit]').removeAttr("disabled");
                    $('.alert-danger').html("");
                    $.each(data.responseJSON.errors, function(key, value){
                        console.log(value);
                        $('html, body').animate({scrollTop: $("#Ajaxerror").offset().top}, 1000);
                        $('.Ajaxerror').show();
                        
                        $('.Ajaxerror').append('<p>'+value+'</p>');
                    });
                }
            });
        } else {
            // do nothing...
            //e.preventDefault();
           // $('#profile-update button[type=submit]').removeAttr("disabled");
        }
    });

</script>
@endpush
