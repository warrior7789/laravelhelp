@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.new.service'))

@section('content')
	<div class="container">
		<div class="row">
		    <div class="col-md-12">
		        <searchanywhere></searchanywhere>
		    </div>
		</div>
	</div>	

	

	
    <div class="aboutus_main">
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
	    		<div class="innerpart_about">
	    			<div class="col-md-12">

	    				<div class="row">
			    			<div class="col-md-6 col-sm-12 col-12 no-padding">
			    				<h1>For fortag</h1>
			    				<iframe class="first-vids" width="100%" height="315" src="https://www.youtube.com/embed/5-u5a_tE9oM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			    			</div>

			    			<div class="col-md-6 col-sm-12 col-12">
				    				<ul class="details-part">
				    					<h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>
				    					<span class="span-line"></span>
				    					<li>
				    						<div class="rounds"><span>1</span><i class="fa fa-circle"></i></div>
				    						<h2>Lorem Ipsum is simply dummy</h2>
				    						<p>Lorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem</p>
				    					</li>
				    					<li>
				    						<div class="rounds"><span>2</span><i class="fa fa-circle"></i></div>
				    						<h2>Lorem Ipsum is simply dummy</h2>
				    						<p>Lorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
				    					</li>
				    					<li>
				    						<div class="rounds"><span>3</span><i class="fa fa-circle"></i></div>
				    						<h2>Lorem Ipsum is simply dummy</h2>
				    						<p>Lorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
				    					</li>
				    				</ul>
			    			</div>
			    		</div>

		    		</div>
	    		</div>
	    	</div>

	    	<div class="second-part-main">
	    		<div class="container">
	    				<div class="col-lg-12">

			    			<div class="row">
				    			<div class="second-part">
				    				<h1>Lorem Ipsum is simply dummy</h1>
				    				<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
				    			</div>
				    		</div>

				    		<div class="row set-row">
					    		<div class="col-lg-6">
					    				<div class="parter-img first-part">
					    					<img src="/storage//chat/1547794320FRESH-FITNESS-FOOD-EMBODY-FITNESS-BANK-LONDON-3.jpg">
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
					    					<img src="/storage//chat/1547794320FRESH-FITNESS-FOOD-EMBODY-FITNESS-BANK-LONDON-3.jpg">
					    				</div>
					    		</div>
					    	</div>
					    	
					    	<div class="row set-row">
					    		<div class="col-lg-6">
					    				<div class="parter-img">
					    					<img src="/storage//chat/1547794320FRESH-FITNESS-FOOD-EMBODY-FITNESS-BANK-LONDON-3.jpg">
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
		    	</div>
	    	</div>

	    	<div class="third-part-boxes">
	    		<div class="container">
	    			<div class="inner-third">
				    	<h1>Lorem Ipsum is simply dummy</h1>
				    	<div class="row">
					    	<div class="col-md-4 col-12">
					    		<div class="row">
					    			<div class="col-md-6  col-6">
					    				<div class="">
					    					<img class="third-img" src="../img/box-img-1.jpg">
					    				</div>
					    			</div>
					    			<div class="col-md-6 col-6">
					    					<h3>Lorem Ipsum is simply</h3>
					    					<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply</p>
					    			</div>
					    		</div>
					    	</div>

					    	<div class="col-md-4 col-12">
					    		<div class="row">
					    			<div class="col-md-6 col-6">
					    				<div class="">
					    					<img class="third-img" src="../img/box-img-2.jpg">
					    				</div>
					    			</div>
					    			<div class="col-md-6 col-6">
					    					<h3>Lorem Ipsum is simply</h3>
					    					<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply</p>
					    			</div>
					    		</div>
					    	</div>

					    	<div class="col-md-4 col-12">
					    		<div class="row">
					    			<div class="col-md-6 col-6">
					    				<div class="">
					    					<img class="third-img" src="../img/box-img-3.jpg">
					    				</div>
					    			</div>
					    			<div class="col-md-6 col-6">
					    					<h3>Lorem Ipsum is simply</h3>
					    					<p>Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply</p>
					    			</div>
					    		</div>
					    	</div>
						</div>
				    </div>
					<button class="btn third-part-btn">submit</button>
	    		</div>
	    	</div>

	    	<div class="fouth-part">
	    		<div class="container">
	    			<div class="inner-fourth">
				    	<h1>Lorem Ipsum</h1>
				    	<ul>
					    	<li>
			    				<div class="">
			    					<img class="forth-img" src="../img/logo-1.png">
			    				</div>					    			
					    	</li>

					    	<li>
			    				<div class="">
			    					<img class="forth-img" src="../img/logo-2.png">
			    				</div>					    			
					    	</li>

					    	<li>
			    				<div class="">
			    					<img class="forth-img" src="../img/logo-3.png">
			    				</div>					    			
					    	</li>
					    	
					    	<li>
			    				<div class="">
			    					<img class="forth-img" src="../img/logo-4.png">
			    				</div>
					    	</li>

					    	<li>
			    				<div class="">
			    					<img class="forth-img" src="../img/logo-5.png">
			    				</div>
					    	</li>
						</ul>
				    </div>
	    		</div>
	    	</div>

	    	<div class="testimonials">
			    <div class="container">	
			    	<div class="col-md-12">
			    		<ul class="bxslider">
						  
						  <li>
						  	<p>"Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simplyLorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply"</p>
							<div class="u-box">  	
							  	<img class="user" src="slider-images/testimonial-profile.png" />
							  	<h4>Lorem Ipsum</h4>
							  	<span>Lorem Ipsum is simply</span>
						  	</div>
						  </li>
						  <li>
						  	<p>"Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simplyLorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply"</p>
						  	<div class="u-box">  	
							  	<img class="user" src="slider-images/testimonial-profile.png" />
							  	<h4>Lorem Ipsum</h4>
							  	<span>Lorem Ipsum is simply</span>
						  	</div>
						  </li>
						  <li>
						  	<p>"Lorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simplyLorem Ipsum is simply dumLorem Ipsum is simply dummyLorem Ipsum is simply"</p>
						  	<div class="u-box">  	
							  	<img class="user" src="slider-images/testimonial-profile.png" />
							  	<h4>Lorem Ipsum</h4>
							  	<span>Lorem Ipsum is simply</span>
						  	</div>
						  </li>
						</ul>
			    	</div>
			    </div>
	    	</div>

	    	{{-- Advertisement div --}}
			<div class="testimonials  bottom-ads">
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
												<img src="/addvs/{{ $ads['bottom']['image'] }}" alt="Image" >
											@endif
										</a>
									</div>
								@endif
								
							@endif
					    </div>
					</div>
				</div>
			</div>

	    	<div class="subscribeer">
	    		<div class="container">
	    			<div class="row">
	    				<div class="col-md-7">
	    					<p><i class="fas fa-briefcase"></i>rem Ipsum is simply dumLorem Ipsum is simply?</p>
	    				</div>

	    				<div class="col-md-5">
	    					<div class="mail-subcr">
	    						<input type="text" name="" placeholder="Enter your email">
	    						<button class="btn">Subscribe</button>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>

	    	
    </div>

    

  
@endsection
@push('after-styles')
	 <link rel="stylesheet" type="text/css" href="/css/jquery.bxslider.css">
@endpush
@push('after-scripts')
	<script type="text/javascript" src="/js/jquery.bxslider.js"></script>  
	<script type="text/javascript">
		$(document).ready(function(){
			var width = $(window).width();
			var minSlides = 2;
			if(width < 600)
				minSlides = 1;
			
	        $('.bxslider').bxSlider({
	            mode: 'horizontal',
	            moveSlides: 1,
	            slideMargin: 40,
	            infiniteLoop: true,
	            slideWidth: 660,
	            minSlides: minSlides,
	            maxSlides: minSlides,
	            speed: 800,
	            pager: false,
	        });        
	        
	    });
	</script>
@endpush


