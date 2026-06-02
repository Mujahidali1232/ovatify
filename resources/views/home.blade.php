<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
	<title>{{ \App\Models\SiteSetting::get('branding.site_name', 'Ovatify') }}</title>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<link rel="stylesheet" href="{{ asset('theme/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('theme/css/main.css') }}" id="color-switcher-link">
	<link rel="stylesheet" href="{{ asset('theme/css/animations.css') }}">
	<link rel="stylesheet" href="{{ asset('theme/css/fonts.css') }}">
	<script src="{{ asset('theme/js/vendor/modernizr-2.6.2.min.js') }}"></script>

	<!--[if lt IE 9]>
		<script src="{{ asset('theme/js/vendor/html5shiv.min.js') }}"></script>
		<script src="{{ asset('theme/js/vendor/respond.min.js') }}"></script>
		<script src="{{ asset('theme/js/vendor/jquery-1.12.4.min.js') }}"></script>
	<![endif]-->

</head>

<body>
	<!--[if lt IE 9]>
		<div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your experience.</div>
	<![endif]-->

	<div class="preloader">
		<div class="preloader_image"></div>
	</div>


	<!-- search modal -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal" id="search_modal">
		<div class="widget widget_search">
			<form method="get" class="searchform form-inline" action="/">
				<div class="form-group">
					<input type="text" value="" name="search" class="form-control" placeholder="Search keyword" id="modal-search-input">
				</div>
				<button type="submit" class="theme_button">Search</button>
			</form>
		</div>
	</div>

	<!-- wrappers for visual page editor and boxed version of template -->
	<div id="canvas">
		<div id="box_wrapper">

			<!-- template sections -->

			<header class="page_header transparent_header doted_items section_padding_10 columns_padding_0 table_section">
				<div class="container-fluid">
					<div class="row">
						@php
							$logoText  = \App\Models\SiteSetting::get('branding.logo_text', 'Ovatify');
							$logoImage = \App\Models\SiteSetting::image('branding.logo_image');
							$primary   = \App\Models\SiteSetting::get('branding.primary_color', '#FF00FF');
						@endphp
						<div class="col-md-2 col-sm-5 col-xs-6">
							<a href="{{ url('/') }}" class="logo" style="display:inline-block; padding:10px 0;">
								@if($logoImage)
									<img src="{{ $logoImage }}" alt="{{ $logoText }}" style="max-height:48px; width:auto;">
								@else
									<span style="font-family:'Inter','Helvetica Neue',Arial,sans-serif; font-size:32px; font-weight:700; letter-spacing:-0.5px; color:{{ $primary }};">{{ $logoText }}</span>
								@endif
							</a>
							<span class="toggle_menu visible-xs">
								<span></span>
							</span>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-2 col-xs-6 text-center">
							<!-- main nav start -->
								<nav class="mainmenu_wrapper">
									<ul class="mainmenu nav sf-menu">
										<li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
										<li class="{{ request()->is('music*') ? 'active' : '' }}"><a href="{{ url('/music') }}">Music</a></li>
										<li class="{{ request()->is('images*') ? 'active' : '' }}"><a href="{{ url('/images') }}">Images</a></li>
										<li class="{{ request()->is('merchandise*') ? 'active' : '' }}"><a href="{{ url('/merchandise') }}">Merchandise</a></li>
										<li class="{{ request()->is('business*') ? 'active' : '' }}"><a href="{{ url('/business') }}">Business</a></li>
										<li class="{{ request()->is('register*') ? 'active' : '' }}"><a href="{{ route('register') }}">Join</a></li>
										<li class="{{ request()->is('login*') ? 'active' : '' }}"><a href="{{ route('login') }}">Login</a></li>
									</ul>
							</nav>
							<!-- eof main nav -->
							<span class="toggle_menu hidden-xs">
								<span></span>
							</span>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-5 text-right hidden-xs">
							<form method="GET" action="{{ url('/') }}" role="search"
							      style="display:flex; align-items:center; gap:8px; margin:0; padding:8px 0;">
								<div style="position:relative; flex:1;">
									<input type="text" name="q" value="{{ request('q') }}"
									       placeholder="Search {{ $logoText }}..."
									       style="width:100%; padding:10px 14px 10px 38px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.04); border-radius:24px; color:#fff; font-size:13px; outline:none; transition:border-color .2s;"
									       onfocus="this.style.borderColor='{{ $primary }}';"
									       onblur="this.style.borderColor='rgba(255,255,255,0.15)';">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $primary }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
									     style="position:absolute; left:14px; top:50%; transform:translateY(-50%); pointer-events:none;">
										<circle cx="11" cy="11" r="7"></circle>
										<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
									</svg>
								</div>
							</form>
						</div>
					</div>
				</div>
			</header>

			<section class="intro_section page_mainslider ds">
				<div class="flexslider">
					<ul class="slides">
						@php
							$multiHero = \App\Models\SiteSetting::get('hero.slides.enabled', '1') === '1';

							$heroSlides = [
								[
									'image' => \App\Models\SiteSetting::image('hero.slide1.image'),
									'heading' => \App\Models\SiteSetting::get('hero.slide1.heading', 'Music. Ownership. Reinvented.'),
									'subheading' => \App\Models\SiteSetting::get('hero.slide1.subheading', ''),
									'cta_text' => \App\Models\SiteSetting::get('hero.slide1.cta_text', 'Get Started'),
									'cta_url' => \App\Models\SiteSetting::get('hero.slide1.cta_url', '/register'),
								],
								[
									'image' => \App\Models\SiteSetting::image('hero.slide2.image'),
									'heading' => \App\Models\SiteSetting::get('hero.slide2.heading', ''),
									'subheading' => \App\Models\SiteSetting::get('hero.slide2.subheading', ''),
									'cta_text' => \App\Models\SiteSetting::get('hero.slide2.cta_text', ''),
									'cta_url' => \App\Models\SiteSetting::get('hero.slide2.cta_url', ''),
								],
								[
									'image' => \App\Models\SiteSetting::image('hero.slide3.image'),
									'heading' => \App\Models\SiteSetting::get('hero.slide3.heading', ''),
									'subheading' => \App\Models\SiteSetting::get('hero.slide3.subheading', ''),
									'cta_text' => \App\Models\SiteSetting::get('hero.slide3.cta_text', ''),
									'cta_url' => \App\Models\SiteSetting::get('hero.slide3.cta_url', ''),
								],
							];

							// Filter out slides without an image.
							$heroSlides = collect($heroSlides)->filter(fn ($s) => !empty($s['image']))->values();
						@endphp

						@foreach(($multiHero ? $heroSlides : $heroSlides->take(1)) as $slide)
						<li class="">
							<img src="{{ $slide['image'] }}" alt="">
							<div class="container">
								<div class="row">
									<div class="col-sm-12 text-center text-md-right">
										<div class="slide_description_wrapper">
											<div class="slide_description text-center">
												<div class="heading text-center bottom_border bottommargin_25">
													<p class="text-uppercase josefin grey">Welcome</p>
													<h1 class="text-uppercase topmargin_0">{{ $slide['heading'] }}</h1>
												</div>
												@if(!empty($slide['subheading']))
													<p class="bottommargin_40">
														{{ $slide['subheading'] }}
													</p>
												@endif
												@if(!empty($slide['cta_text']) && !empty($slide['cta_url']))
													<a href="{{ $slide['cta_url'] }}" class="theme_button margin_0">{{ $slide['cta_text'] }}</a>
												@endif
											</div>
										</div>
										<!-- eof .slide_description_wrapper -->
									</div>
									<!-- eof .col-* -->
								</div>
								<!-- eof .row -->
							</div>
							<!-- eof .container -->
							<div class="slide_social">
								@php
									$sFacebook  = \App\Models\SiteSetting::get('social.facebook');
									$sTwitter   = \App\Models\SiteSetting::get('social.twitter');
									$sInstagram = \App\Models\SiteSetting::get('social.instagram');
								@endphp
								@if(!empty($sFacebook))
									<a href="{{ $sFacebook }}" target="_blank" rel="noopener"
									   class="social-icon monochrome-icon rounded-icon soc-facebook"></a>
								@endif
								@if(!empty($sTwitter))
									<a href="{{ $sTwitter }}" target="_blank" rel="noopener"
									   class="social-icon monochrome-icon rounded-icon soc-twitter"></a>
								@endif
								@if(!empty($sInstagram))
									<a href="{{ $sInstagram }}" target="_blank" rel="noopener"
									   class="social-icon monochrome-icon rounded-icon soc-instagram"></a>
								@endif
							</div>
						</li>
						@endforeach
					</ul>
				</div>
				<!-- eof flexslider -->
			</section>

			<section class="ls section_padding_top_110 columns_margin_0 image-overflow">
				@php
					$aboutTitle = \App\Models\SiteSetting::get('about.title', 'About Ovatify');
					$aboutBody  = \App\Models\SiteSetting::get('about.body', '');
					$aboutImage = \App\Models\SiteSetting::image('about.image');
							$portfolioPlaceholder = \App\Models\SiteSetting::image('home.portfolio.placeholder_image');
							$songsPlaceholder     = \App\Models\SiteSetting::image('home.songs.placeholder_image');
							$creatorPlaceholder   = \App\Models\SiteSetting::image('home.creators.placeholder_avatar');
				@endphp
				<div class="container">
					<div class="row">
						<div class="col-md-offset-1 col-md-10 col-lg-offset-0 col-lg-6">
							<div class="heading bottommargin_40">
								<p class="text-uppercase josefin grey fontsize_20">History</p>
								<h2 class="section_header topmargin_5 bottommargin_0">{{ $aboutTitle }}</h2>
							</div>
							@if(!empty($aboutBody))
								<p>{{ $aboutBody }}</p>
							@endif
							<ul class="list2 leftmargin_50 topmargin_30">
								<li>Vestibulum eget elit sed elit pulvinar tempor nec sed ipsum;</li>
								<li>Duis sit amet laoreet orci, vitae convallis ante;</li>
								<li>Aliquam non nulla volutpat, venenatis enim et, venenatis est.;</li>
								<li>Mauris consequat, neque ac pharetra mattis, orci diam malesuada purus;</li>
								<li>Aliquam pharetra in eros sit amet cursus. </li>
							</ul>
						</div>
						<div class="col-md-offset-1 col-md-10 col-lg-offset-0 col-lg-6 text-center text-lg-right to_animate" data-animation="fadeInRight">
							@if($aboutImage)
								<img src="{{ $aboutImage }}" alt="" class="top-overlap-small right-offset">
							@endif
						</div>
					</div>
				</div>
			</section>

			<section class="ls ms columns_margin_0 columns_padding_0 page_portfolio">
				@php
					$portfolioEnabled = \App\Models\SiteSetting::get('home.sections.portfolio_enabled', '1') === '1';
					$portfolioKicker  = \App\Models\SiteSetting::get('home.portfolio.kicker', 'Portfolio');
					$portfolioTitle   = \App\Models\SiteSetting::get('home.portfolio.title', 'Our beautiful works');
					$portfolioMoreTxt = \App\Models\SiteSetting::get('home.portfolio.load_more_text', 'Explore more');
					$portfolioMoreUrl = \App\Models\SiteSetting::get('home.portfolio.load_more_url', '/images');

					$songsEnabled = \App\Models\SiteSetting::get('home.sections.songs_enabled', '1') === '1';
					$songsKicker  = \App\Models\SiteSetting::get('home.songs.kicker', 'Music');
					$songsTitle   = \App\Models\SiteSetting::get('home.songs.title', 'Trending songs');
					$songsMoreTxt = \App\Models\SiteSetting::get('home.songs.more_text', 'Explore songs');
					$songsMoreUrl = \App\Models\SiteSetting::get('home.songs.more_url', '/music');
				@endphp
				@if($portfolioEnabled)
				<div class="container-fluid">
					<div class="isotope_container isotope row masonry-layout" data-filters=".isotope_filters">
						@php
							$portfolioItems = collect([1, 2, 3, 4])->map(function ($i) use ($portfolioPlaceholder) {
								$key = "home.portfolio.cms{$i}";
								$url = \App\Models\SiteSetting::get("{$key}.url", '');
								if ($url && !\Illuminate\Support\Str::startsWith($url, ['http://', 'https://', '/'])) {
									$url = '/'.$url;
								}

								return [
									'image' => \App\Models\SiteSetting::image("{$key}.image") ?: ($portfolioPlaceholder ?: ''),
									'title' => \App\Models\SiteSetting::get("{$key}.title", ''),
									'by' => \App\Models\SiteSetting::get("{$key}.by", ''),
									'genre' => \App\Models\SiteSetting::get("{$key}.genre", ''),
									'url' => $url ? url($url) : '#',
								];
							})->filter(function ($it) {
								return !empty($it['image']) || !empty($it['title']) || !empty($it['by']) || !empty($it['genre']);
							})->values();
						@endphp

						@if($portfolioItems->isEmpty())
							<div class="isotope-item col-xs-6 col-md-4 col-lg-3 text-center fashion studio session">
								<div class="vertical-item content-absolute vertical-center portfolio-filters">
									<div class="item-media">
										@if($portfolioPlaceholder)
											<img src="{{ $portfolioPlaceholder }}" alt="">
										@endif
									</div>
									<div class="item-content">
										<div class="display_table">
											<div class="display_table_cell text-left">
												<div class="heading bottommargin_35">
													<p class="text-uppercase josefin grey fontsize_20">{{ $portfolioKicker }}</p>
													<h2 class="section_header topmargin_5 bottommargin_0">{{ $portfolioTitle }}</h2>
												</div>
												<p class="grey">Add portfolio items in Admin → Site Content.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						@else
							@foreach($portfolioItems as $item)
								<div class="isotope-item col-sm-6 col-md-4 col-lg-3 fashion">
									<div class="vertical-item gallery-item content-absolute text-center">
										<div class="item-media">
											@if(!empty($item['image']))
												<img src="{{ $item['image'] }}" alt="{{ $item['title'] ?: 'Portfolio' }}" style="width:100%; height:260px; object-fit:cover;">
											@endif
											<div class="media-links">
												<div class="links-wrap">
													<a class="p-link" title="" href="{{ $item['url'] }}"></a>
												</div>
											</div>
										</div>
										<div class="item-content theme_background">
											<h4 class="item-meta">
												<a href="{{ $item['url'] }}">{{ $item['title'] ?: 'Untitled' }}</a>
											</h4>
											@if(!empty($item['by']))
												<p class="small grey bottommargin_0">by {{ $item['by'] }}</p>
											@endif
											@if(!empty($item['genre']))
												<p class="small grey bottommargin_0">{{ $item['genre'] }}</p>
											@endif
										</div>
									</div>
								</div>
							@endforeach
						@endif
						<div class="isotope-item col-sm-6 col-md-4 col-lg-3 fashion studio session">
							<div class="vertical-item portfolio-load-more content-absolute vertical-center text-center">
								<div class="item-media">
									@if($portfolioPlaceholder)
										<img src="{{ $portfolioPlaceholder }}" alt="">
									@endif
								</div>
								<div class="item-content">
									<div class="display_table">
										<div class="display_table_cell darklinks">
											<a href="{{ $portfolioMoreUrl }}" class="theme_link fontsize_20">{{ $portfolioMoreTxt }}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
			</section>

			{{-- Songs covers grid --}}
			@if($songsEnabled)
			<section class="ls ms columns_margin_0 columns_padding_0 page_portfolio">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="heading text-center topmargin_40 bottommargin_40">
								<p class="text-uppercase josefin grey fontsize_20">{{ $songsKicker }}</p>
								<h2 class="section_header topmargin_5 bottommargin_0">{{ $songsTitle }}</h2>
							</div>
						</div>
					</div>

					@php $songs = ($featuredSongs ?? collect()); @endphp

					@if($songs->isEmpty())
						<div class="row">
							<div class="col-xs-12 text-center">
								<p class="grey">No songs yet.</p>
							</div>
						</div>
					@else
						<div class="row">
							<div class="col-sm-12">
								<div class="owl-carousel numbered-dots margin_0" data-themeclass="owl-theme" data-dots="true" data-items="9" data-responsive-lg="3" data-responsive-md="2" data-responsive-sm="1" data-responsive-xs="1" data-margin="30">
									@foreach($songs as $song)
										@php
											$cover = !empty($song->cover_image)
												? (\Illuminate\Support\Str::startsWith($song->cover_image, ['http://','https://'])
													? $song->cover_image
													: (\Illuminate\Support\Str::startsWith($song->cover_image, ['theme/','images/'])
														? '/'.ltrim($song->cover_image, '/')
														: \Illuminate\Support\Facades\Storage::url($song->cover_image)))
												: ($songsPlaceholder ?: '');
										@endphp
										<div class="vertical-item item-type1">
											<div class="item-content theme_background" style="display:flex; gap:16px; align-items:center; padding:18px;">
												@if(!empty($cover))
													<div style="width:120px; height:120px; flex:0 0 120px; overflow:hidden; border-radius:6px;">
														<img src="{{ $cover }}" alt="{{ $song->title }}" style="width:100%; height:100%; object-fit:cover;">
													</div>
												@endif
												<div style="flex:1 1 auto; min-width:0;">
													<h4 class="item-meta bottommargin_5" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
														<a href="{{ url('/music') }}">{{ $song->title }}</a>
													</h4>
													@if(!empty($song->user?->username))
														<p class="small grey bottommargin_0">by {{ $song->user->username }}</p>
													@endif
													@if(!empty($song->genre))
														<p class="small grey bottommargin_0">{{ $song->genre }}</p>
													@endif
													<p class="darklinks topmargin_10 bottommargin_0">
														<a href="{{ url('/music') }}" class="theme_link">Open
															<i class="fa fa-plus" aria-hidden="true"></i>
														</a>
													</p>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					@endif

					<div class="row">
						<div class="col-xs-12 text-center topmargin_30 bottommargin_40">
							<a href="{{ $songsMoreUrl }}" class="theme_button">{{ $songsMoreTxt }}</a>
						</div>
					</div>
				</div>
			</section>
			@endif

			<section class="ls section_padding_top_110 columns_margin_0">
				@php
					$castingEnabled = \App\Models\SiteSetting::get('home.sections.casting_enabled', '1') === '1';
					$castingKicker  = \App\Models\SiteSetting::get('home.casting.kicker', 'Casting');
					$castingTitle   = \App\Models\SiteSetting::get('home.casting.title', 'Do you want be a');
					$castingSub     = \App\Models\SiteSetting::get('home.casting.subtitle', 'Creator');
					$castingBody    = \App\Models\SiteSetting::get('home.casting.body', '');
					$castingCtaText = \App\Models\SiteSetting::get('home.casting.cta_text', 'Discover more');
					$castingCtaUrl  = \App\Models\SiteSetting::get('home.casting.cta_url', '/register');
					$castingImg     = \App\Models\SiteSetting::image('home.casting.image');
				@endphp
				@if($castingEnabled)
				<div class="container">
					<div class="row">

						<div class="col-md-10 col-md-offset-1 col-lg-offset-0 col-lg-6 col-lg-push-6">
							<div class="heading bottommargin_35">
								<p class="text-uppercase josefin grey fontsize_20">{{ $castingKicker }}</p>
								<h2 class="section_header bottommargin_0">{{ $castingTitle }}</h2>
								<p class="josefin text-uppercase grey no-lines">{{ $castingSub }}</p>
							</div>
							@if(!empty($castingBody))
								<p>{{ $castingBody }}</p>
							@endif
							<p class="darklinks topmargin_40">
								<a href="{{ $castingCtaUrl }}" class="theme_link bottommargin_30">{{ $castingCtaText }}
									<i class="fa fa-plus" aria-hidden="true"></i>
								</a>
							</p>

						</div>
						<div class="col-md-10 col-md-offset-1 col-lg-offset-0 col-lg-6 col-lg-pull-6 text-center">
							<img src="{{ $castingImg ?: asset('theme/images/model2.jpg') }}" alt="" class="top-overlap-very-small">
						</div>
					</div>
				</div>
				@endif
			</section>

			<section class="cs parallax page_testimonials section_padding_100">
				<div class="flexslider">
					<ul class="slides">
						<li>
							<div class="container">
								<div class="row">
									<div class="col-sm-12 text-center text-md-right">
										<div class="slide_description_wrapper">
											<div class="slide_description text-center">
												<div class="quote-sign josefin grey bottommargin_50"></div>
												<div class="heading text-center">
													<h2 class="section_header bottommargin_0 grey">What people say</h2>
													<p class="josefin text-uppercase grey">About us</p>
												</div>
												<div class="row">
													<div class="col-md-8 col-md-offset-2">
														<blockquote class="no-border margin_0">
															Mauris hendrerit eget orci ut pretium. Donec purus est, aliquet tempus rhoncus a, sollicitudin in erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque vel lacinia enim, a feugiat lorem. In vitae leo
															vulputate libero aliquam lacinia. Mauris rhoncus vel neque vitae.

															<div class="item-meta fontsize_16 topmargin_75">
																<span class="bold josefin fontsize_20 grey">Donald Phelps - </span> Manager Co.
															</div>
														</blockquote>
													</div>
												</div>
											</div>
										</div>
										<!-- eof .slide_description_wrapper -->
									</div>
									<!-- eof .col-* -->
								</div>
								<!-- eof .row -->
							</div>
							<!-- eof .container -->
						</li>
						<li>
							<div class="container">
								<div class="row">
									<div class="col-sm-12 text-center text-md-right">
										<div class="slide_description_wrapper">
											<div class="slide_description text-center">
												<div class="quote-sign josefin grey bottommargin_50"></div>
												<div class="heading text-center">
													<h2 class="section_header bottommargin_0 grey">What people say</h2>
													<p class="josefin text-uppercase grey">About us</p>
												</div>
												<div class="row">
													<div class="col-md-8 col-md-offset-2">
														<blockquote class="no-border margin_0">
															Fusce mollis dapibus ipsum eu tempor. Vivamus tempus, nisi quis luctus placerat, diam lectus pretium felis, a laoreet risus odio nec elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum feugiat augue
															ac blandit imperdiet. Suspendisse ut massa fringilla.

															<div class="item-meta fontsize_16 topmargin_75">
																<span class="bold josefin fontsize_20 grey">Derrick Rodgers - </span> Manager
															</div>
														</blockquote>
													</div>
												</div>
											</div>
										</div>
										<!-- eof .slide_description_wrapper -->
									</div>
									<!-- eof .col-* -->
								</div>
								<!-- eof .row -->
							</div>
							<!-- eof .container -->
						</li>
						<li>
							<div class="container">
								<div class="row">
									<div class="col-sm-12 text-center text-md-right">
										<div class="slide_description_wrapper">
											<div class="slide_description text-center">
												<div class="quote-sign josefin grey bottommargin_50"></div>
												<div class="heading text-center">
													<h2 class="section_header bottommargin_0 grey">What people say</h2>
													<p class="josefin text-uppercase grey">About us</p>
												</div>
												<div class="row">
													<div class="col-md-8 col-md-offset-2">
														<blockquote class="no-border margin_0">
															Mauris hendrerit eget orci ut pretium. Donec purus est, aliquet tempus rhoncus a, sollicitudin in erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque vel lacinia enim, a feugiat lorem. In vitae leo
															vulputate libero aliquam lacinia. Mauris rhoncus vel neque vitae.

															<div class="item-meta fontsize_16 topmargin_75">
																<span class="bold josefin fontsize_20 grey">Donald Phelps - </span> Manager Co.
															</div>
														</blockquote>
													</div>
												</div>
											</div>
										</div>
										<!-- eof .slide_description_wrapper -->
									</div>
									<!-- eof .col-* -->
								</div>
								<!-- eof .row -->
							</div>
							<!-- eof .container -->
						</li>
						<li>
							<div class="container">
								<div class="row">
									<div class="col-sm-12 text-center text-md-right">
										<div class="slide_description_wrapper">
											<div class="slide_description text-center">
												<div class="quote-sign josefin grey bottommargin_50"></div>
												<div class="heading text-center">
													<h2 class="section_header bottommargin_0 grey">What people say</h2>
													<p class="josefin text-uppercase grey">About us</p>
												</div>
												<div class="row">
													<div class="col-md-8 col-md-offset-2">
														<blockquote class="no-border margin_0">
															Phasellus in efficitur sem. Mauris mi risus, efficitur in ultricies a, aliquam eu mi. Nullam justo mauris, venenatis id ipsum ac, ultrices gravida metus. Sed maximus augue nec mi porttitor, sed tempor elit facilisis. Vestibulum hendrerit pharetra consectetur.
															Sed nec bibendum nisi, ut vulputate mauris.

															<div class="item-meta fontsize_16 topmargin_75">
																<span class="bold josefin fontsize_20 grey">Minerva Ferguson - </span> Founder &amp; CEO
															</div>
														</blockquote>
													</div>
												</div>
											</div>
										</div>
										<!-- eof .slide_description_wrapper -->
									</div>
									<!-- eof .col-* -->
								</div>
								<!-- eof .row -->
							</div>
							<!-- eof .container -->
						</li>
					</ul>
				</div>
				<!-- eof flexslider -->
			</section>

			@php
				$creatorsEnabled = \App\Models\SiteSetting::get('home.sections.creators_enabled', '1') === '1';
				$creatorsKicker  = \App\Models\SiteSetting::get('home.creators.kicker', 'Creators');
				$creatorsTitle   = \App\Models\SiteSetting::get('home.creators.title', 'Featured creators');
			@endphp
			@if($creatorsEnabled)
			<section class="ls section_padding_110">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 text-center">
							<div class="heading text-center">
								<p class="text-uppercase josefin grey fontsize_20">{{ $creatorsKicker }}</p>
								<h2 class="section_header bottommargin_0">{{ $creatorsTitle }}</h2>
							</div>
						</div>
					</div>
					<div class="row topmargin_50">
						<div class="col-sm-12">
							<div class="owl-carousel numbered-dots margin_0" data-themeclass="owl-theme" data-dots="true" data-items="9" data-responsive-lg="3" data-responsive-md="2" data-responsive-sm="2" data-responsive-xs="1" data-margin="30">

								@php
									$creators = ($featuredCreators ?? collect());
								@endphp

								@if($creators->isEmpty())
									<div class="vertical-item item-type1">
										<div class="item-media">
											@if($creatorPlaceholder)
												<img src="{{ $creatorPlaceholder }}" alt="Creator">
											@endif
										</div>
										<div class="item-content">
											<h3><span>No creators yet</span></h3>
											<p class="fontsize_18">Create a creator/artist user to show here.</p>
										</div>
									</div>
								@else
									@foreach($creators as $creator)
										@php
											$rawAvatar = $creator->profile_image ?? '';
											if (!empty($rawAvatar)) {
												if (\Illuminate\Support\Str::startsWith($rawAvatar, ['http://', 'https://'])) {
													$avatar = $rawAvatar;
												} elseif (\Illuminate\Support\Str::startsWith($rawAvatar, ['theme/', 'images/'])) {
													$avatar = url('/' . ltrim($rawAvatar, '/'));
												} else {
													$avatar = url(\Illuminate\Support\Facades\Storage::url($rawAvatar));
												}
											} else {
												$avatar = ($creatorPlaceholder ?: '');
											}
										@endphp
										<div class="vertical-item item-type1">
											<div class="item-media">
												@if(!empty($avatar))
													<img src="{{ $avatar }}" alt="{{ $creator->username ?: 'Creator' }}" style="width:100%; height:420px; object-fit:cover;">
												@endif
											</div>
											<div class="item-content">
												<h3>
													<span>{{ $creator->username ?: 'Creator' }}</span>
												</h3>
												<p class="fontsize_18">Creator</p>
												@if(!empty($creator->bio))
													<p class="small grey">{{ \Illuminate\Support\Str::limit($creator->bio, 90) }}</p>
												@endif
											</div>
										</div>
									@endforeach
								@endif

								{{-- converted to dynamic creators carousel --}}
								{{-- converted: removed static "models" cards --}}
								{{-- converted: removed remaining static "models" cards --}}

							</div>
						</div>
					</div>
				</div>
			</section>
			@endif

			<section class="cs section_padding_110 page_banner parallax">
				@php
					$bannerEnabled = \App\Models\SiteSetting::get('home.sections.banner_enabled', '1') === '1';
					$bannerLine1   = \App\Models\SiteSetting::get('home.banner.line1', 'Discover trending songs from creators worldwide');
					$bannerLine2   = \App\Models\SiteSetting::get('home.banner.line2', 'License, buy, or invest in tracks you love');
					$bannerCtaText = \App\Models\SiteSetting::get('home.banner.cta_text', 'Explore Songs');
					$bannerCtaUrl  = \App\Models\SiteSetting::get('home.banner.cta_url', '/music');
				@endphp
				@if($bannerEnabled)
				<div class="container">
					<div class="row topmargin_30 bottommargin_30">
						<div class="col-sm-12 text-center">
							<p class="margin_0 fontsize_40 josefin bold grey text-uppercase">{{ $bannerLine1 }}</p>
							<p class="fontsize_30 josefin thin grey text-uppercase topmargin_5 bottommargin_50">{{ $bannerLine2 }}</p>
							<a href="{{ $bannerCtaUrl }}" class="theme_button margin_0">{{ $bannerCtaText }}</a>
						</div>
					</div>
				</div>
				@endif
			</section>

			<section class="ls section_padding_top_110 section_padding_bottom_75 page_blog">
				@php
					$blogEnabled = \App\Models\SiteSetting::get('home.sections.blog_enabled', '0') === '1';
					$blogKicker  = \App\Models\SiteSetting::get('home.blog.kicker', 'Blog');
					$blogTitle   = \App\Models\SiteSetting::get('home.blog.title', 'Last News');
					$blogMoreTxt = \App\Models\SiteSetting::get('home.blog.more_text', 'Discover more posts');
					$blogMoreUrl = \App\Models\SiteSetting::get('home.blog.more_url', '/blog');
				@endphp
				@if($blogEnabled)
				<div class="container">
					<div class="isotope_container isotope blog_isotope row masonry-layout columns_margin_bottom_30" data-filters=".blog_filters">

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 fashion studio session news">

							<div class="vertical-item vertical-center blog-filters-container">
								<div class="item-content">
									<div class="display_table">
										<div class="display_table_cell text-left">
											<div class="heading bottommargin_45">
												<p class="text-uppercase josefin grey fontsize_20">{{ $blogKicker }}</p>
												<h2 class="section_header topmargin_5 bottommargin_0">{{ $blogTitle }}</h2>
											</div>
											<div class="filters blog_filters">
												<a href="#" data-filter="*" class="selected">All</a>
												<a href="#" data-filter=".fashion">Fashion</a>
												<a href="#" data-filter=".studio">Studio</a>
												<a href="#" data-filter=".session">Session</a>
												<a href="#" data-filter=".news">World News</a>
											</div>
											<p class="darklinks topmargin_90">
												<a href="{{ $blogMoreUrl }}" class="theme_link">{{ $blogMoreTxt }}
													<i class="rt-icon2-chevron-thin-right" aria-hidden="true"></i>
												</a>
											</p>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/15.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Elizabeth</span> - model experiment, Seoul, Korea.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 fashion studio">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/03.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Fashion</a>,
										<a href="#">Studio</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Nora</span> - model experience in 17 years, Bangkok, Thailand.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/23.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Fiona</span> - first modeling experience, Seoul, Korea..</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session studio">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/06.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>,
										<a href="#">Studio</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Bess</span> - model experience in the winter-spring season 2015.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/21.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Lucille</span> - the first modeling experience in 13 years, Tokyo.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session fashion">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/01.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>,
										<a href="#">Fashion</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Rhoda</span> - first modeling experience, Thailand.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session studio">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/18.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>,
										<a href="#">Studio</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Edna</span> - model experience in 15 years, Mumbai, India.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session fashion">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/16.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>,
										<a href="#">Fashion</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Frances</span> - first modeling experience, Shanghai, China.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 news">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/11.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">World news</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">Cinderella story in the pages of the portal Niklife.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 fashion studio">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/09.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">fashion</a>,
										<a href="#">studio</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Susan</span> - for "Laha" magazine, Beirut, Lebanon.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>

						<div class="isotope-item col-lg-3 col-md-4 col-sm-6 session">
							<article class="vertical-item item-type1 post">
								<div class="item-media">
									<img src="{{ asset('theme/images/models_portrait/02.jpg') }}" alt="s">
								</div>
								<div class="item-content">
									<div class="categories-links bottommargin_5 highlight">
										<a href="#">Session</a>
									</div>
									<p class="fontsize_18 bold darklinks2">
										<a href="/theme/blog-single-right.html">
											<span class="text-uppercase">Beatrice</span> - for lookbook TM "WHO.A.U.", Korea.</a>
									</p>
									<div class="item-meta">
										<p>
											Suspendisse vulputate nisl ut magna iaculis, vitae congue risus dictum. Integer dui.
										</p>
									</div>
									<div class="post-social lightgreylinks">
										<a href="#" class="social-icon soc-facebook"></a>
										<a href="#" class="social-icon soc-twitter"></a>
										<a href="#" class="social-icon soc-google"></a>
										<a href="#" class="social-icon soc-instagram"></a>
									</div>
								</div>
							</article>
						</div>


					</div>
					<!-- eof .isotope_container.row -->
				</div>
				@endif
			</section>

			{{-- Use the shared dynamic footer (Admin → Site Content) --}}
			@include('partials.footer')

		</div>
		<!-- eof #box_wrapper -->
	</div>
	<!-- eof #canvas -->

	<script src="{{ asset('theme/js/compressed.js') }}"></script>
	<script src="{{ asset('theme/js/main.js') }}"></script>


</body>

</html>

