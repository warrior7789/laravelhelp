@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

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
   
    {{-- <homesearch-component></homesearch-component> --}}
    <router-view></router-view>
        
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
        <div style="height:250px;"></div>
	</div>
    
@endsection
