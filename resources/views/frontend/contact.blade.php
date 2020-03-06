@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

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
                                {{-- {{ $ads['top']['title'] }}   --}}                    
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
        <div class="row">
             
                {{-- Advertisement div --}}        
                <div class="col-md-3 col-sm-2">
                    @if(!empty($ads['left']))                 
                        @if($ads['left']['isgoogle']==1)
                            <div class="adv_div">                   
                                    {!! $ads['left']['description'] !!}                   
                            </div>
                        @else
                            <div class="adv_div">
                                @php
                                    $link = $ads['left']['link'];
                                    if(!strpos($link, '://')){
                                        $link = "http://".$link;
                                    }
                                @endphp
                                <a href="{{ $link }}" target="_blank">
                                    {{-- {{ $ads['left']['title'] }} --}}                       
                                    @if(!empty($ads['left']['image']))
                                        <img src="/addvs/{{ $ads['left']['image'] }}" alt="Image">
                                    @endif
                                </a>
                            </div>
                        @endif
                        
                    @endif
                </div>
                {{-- col-10 offset-1 align-self-center --}}
                <div class="col col-md-6 col-sm-8">
                    
                        <div class="card">
                        <div class="card-header title-card">
                            <strong>
                                @lang('labels.frontend.contact.box_title')
                            </strong>
                        </div><!--card-header-->

                        <div class="card-body">
                            {{ html()->form('POST', route('frontend.contact.send'))->open() }}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.name'))->for('name') }}

                                            {{ html()->text('name', optional(auth()->user())->name)
                                                ->class('form-control')
                                                ->placeholder(__('validation.attributes.frontend.name'))
                                                ->attribute('maxlength', 191)
                                                ->required()
                                                ->autofocus() }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                            {{ html()->email('email', optional(auth()->user())->email)
                                                ->class('form-control')
                                                ->placeholder(__('validation.attributes.frontend.email'))
                                                ->attribute('maxlength', 191)
                                                ->required() }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.phone'))->for('phone') }}

                                            {{ html()->text('phone')
                                                ->class('form-control')
                                                ->placeholder(__('validation.attributes.frontend.phone'))
                                                ->attribute('maxlength', 191)
                                                ->required() }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.message'))->for('message') }}

                                            {{ html()->textarea('message')
                                                ->class('form-control')
                                                ->placeholder(__('validation.attributes.frontend.message'))
                                                ->attribute('rows', 3) }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->
                                <div class="row">
                                    
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-0 clearfix update-btn">
                                            {{ form_submit(__('labels.frontend.contact.button')) }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->
                                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            {{ html()->form()->close() }}
                        </div><!--card-body-->
                        </div><!--card-->
                    
                </div><!--col-->

                {{-- Advertisement div --}}        
                <div class="col-md-3 col-sm-2">
                    @if(!empty($ads['right']))                 
                        @if($ads['right']['isgoogle']==1)
                            <div class="adv_div">                   
                                    {!! $ads['right']['description'] !!}                   
                            </div>
                        @else
                            <div class="adv_div">
                                @php
                                    $link = $ads['right']['link'];
                                    if(!strpos($link, '://')){
                                        $link = "http://".$link;
                                    }
                                @endphp
                                <a href="{{ $link }}" target="_blank">
                                    {{-- {{ $ads['right']['title'] }} --}}                       
                                    @if(!empty($ads['right']['image']))
                                        <img src="/addvs/{{ $ads['right']['image'] }}" alt="Image">
                                    @endif
                                </a>
                            </div>
                        @endif
                        
                    @endif
                </div>
           
        </div>
    </div><!--row-->

    {{-- Advertisement div --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(!empty($ads['bottom']))                 
                    @if($ads['bottom']['isgoogle']==1)
                        <div class="adv_div">                   
                                {!! $ads['bottom']['description'] !!}                   
                        </div>
                    @else
                        <div class="adv_div">
                            @php
                                $link = $ads['bottom']['link'];
                                if(!strpos($link, '://')){
                                    $link = "http://".$link;
                                }
                            @endphp
                            <a href="{{ $link }}" target="_blank">
                                {{-- {{ $ads['bottom']['title'] }} --}}                       
                                @if(!empty($ads['bottom']['image']))
                                    <img src="/addvs/{{ $ads['bottom']['image'] }}" alt="Image">
                                @endif
                            </a>
                        </div>
                    @endif
                    
                @endif
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
<script src='https://www.google.com/recaptcha/api.js?render={{$_ENV['NOCAPTCHA_SITEKEY']}}'></script>
<script type="text/javascript">
    grecaptcha.ready(function () {
        grecaptcha.execute('{{$_ENV['NOCAPTCHA_SITEKEY']}}', { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });

</script>
@endpush