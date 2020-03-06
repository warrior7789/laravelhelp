@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.new.services'))

@section('content')
	<div class="container">
		<div class="row">
		    <div class="col-md-12">
		        <searchanywhere></searchanywhere>
		    </div>
		</div>
	</div>
	<div class="service-page">
			<div class="container-fluid">
				<div class="row psr">	
					<div class="our-services">		
						<div class="container">
							<div class="col-md-6 offset-md-3">	
								<h1>Our Services</h1>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
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

				<div class="row set-row">
		    		<div class="col-lg-6">
		    				<div class="parter-img first-part">
		    					<img src="/img/service1.jpg">
		    				</div>
		    		</div>
		    		<div class="col-lg-6">
		    			<div class="white-box">
		    				<h2>Lorem Ipsum is simply dummy</h2>
		    				<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
		    				<button class="btn">submit</button>
		    			</div>
		    		</div>
		    	</div>

		    	<div class="row set-row">
		    		<div class="col-lg-6">
		    			<div class="white-box-left">
		    				<h2>Lorem Ipsum is simply dummy</h2>
		    				<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
		    				<button class="btn">submit</button>
		    			</div>
		    		</div>
		    		<div class="col-lg-6">
		    				<div class="parter-img">
		    					<img src="/img/service2.jpg">
		    				</div>
		    		</div>
		    	</div>
		    	
		    	<div class="row set-row">
		    		<div class="col-lg-6">
		    				<div class="parter-img">
		    					<img src="/img/service3.jpg">
		    				</div>
		    		</div>
		    		<div class="col-lg-6">
		    			<div class="white-box">
		    				<h2>Lorem Ipsum is simply dummy</h2>
		    				<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
		    				<button class="btn">submit</button>
		    			</div>
		    		</div>
	    		</div>

			</div>

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
	</div>
@endsection

@push('after-styles')
@endpush

@push('after-scripts')
@endpush