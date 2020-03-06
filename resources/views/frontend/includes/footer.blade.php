<div class="footer">
	<div class="container">
		<div class="row">	
			<div class="col-md-3">
				<div class="footer-logo">
					<a href="{{ route('frontend.index') }}">
						@if(!empty($site_settings->sitelogo))
							<img src="/logo/{{ $site_settings->sitelogo }}">
						@else
							<img src="/img/footer-logo.jpg">
						@endif						 	
					</a>
				</div>
			</div>

			<div class="col-md-3">
				<div class="footer-part">
					
					<h4>{{ __('strings.new.social_media_text') }}</h4> 
					
					<a href="<?php if(!empty($site_settings->facebookurl)){ echo $site_settings->facebookurl; } ?>" target="_blank" class="social-icon">
						<i class="fab fa-facebook-square"></i>
					</a>
					<a href="<?php if(!empty($site_settings->twitterurl)){ echo $site_settings->twitterurl; } ?>" target="_blank" class="social-icon">
						<i class="fab fa-twitter"></i>
					</a>
					<a href="<?php if(!empty($site_settings->linkedinurl)){ echo $site_settings->linkedinurl; } ?>" target="_blank" class="social-icon">
						<i class="fab fa-linkedin"></i>
					</a>
					<a href="<?php if(!empty($site_settings->instagramurl)){ echo $site_settings->instagramurl; } ?>" target="_blank" class="social-icon">
						<i class="fab fa-instagram"></i>
					</a> 
				
				</div>
			</div>

			<div class="col-md-3">
				<div class="footer-part">
					<h4>@lang('navs.frontend.contact')</h4> 
					<p>@lang('strings.new.contact_footer_text') 
					<?php if(!empty($site_settings->phone)){ echo $site_settings->phone; } ?></p>
				</div>
			</div>

			<div class="col-md-3">
				<div class="footer-part">
					<h4>@lang('strings.new.address')</h4> 
					<p><?php if(!empty($site_settings->address)){ echo $site_settings->address; } ?></p>
				</div>	
			</div>
		</div>
	</div>
	<div class="copyright-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<p>&copy; {{ date('Y') }} @lang('labels.general.copyright_text')</p>
				</div>
				<div class="col-md-6">
					<ul>
						<li><a href="{{ route('frontend.index') }}">@lang('strings.new.home')</a></li>
						<li><a href="#">@lang('strings.new.about_us')</a></li>
						<li><a href="{{ route('frontend.contact') }}">@lang('navs.frontend.contact_us')</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>