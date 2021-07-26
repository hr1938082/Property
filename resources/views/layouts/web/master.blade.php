<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from pixelgeeklab.com/html/realestast/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Mar 2021 12:33:52 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="keywords" content="HTML5 Template" />
	<meta name="description" content="Flatize - Shop HTML5 Responsive Template">
	<meta name="author" content="pixelgeeklab.com">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Property</title>

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>

	<!-- Bootstrap -->
	<link href="{{ asset('bootstrap3/css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- Libs CSS -->
	<link href="{{ asset('css/fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" media="screen">
	<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/owl.theme.css') }}" media="screen">
	<link rel="stylesheet" href="{{ asset('vendor/flexslider/flexslider.css') }}" media="screen">
	<link rel="stylesheet" href="{{ asset('vendor/chosen/chosen.css') }}" media="screen">

	<!-- Theme -->
	<link href="{{ asset('css/theme-animate.css') }}" rel="stylesheet">
	<link href="{{ asset('css/theme-elements.css') }}" rel="stylesheet">
	<link href="{{ asset('css/theme-blog.css') }}" rel="stylesheet">
	<link href="{{ asset('css/theme-map.css') }}" rel="stylesheet">
	<link href="{{ asset('css/theme.css') }}" rel="stylesheet">

	<!-- Theme Responsive-->
	<link href="{{ asset('css/theme-responsive.css') }}" rel="stylesheet">
</head>

<body>
	<div id="page">
		<header>
			<div id="top">
				<div class="container">
					<p class="pull-left text-note hidden-xs"><i class="fa fa-phone"></i> Need Support? 1-800-666-8888
					</p>
					<ul class="nav nav-pills nav-top navbar-right">
						<li class="login"><a href="javascript:void(0);"><i class="fa fa-user"></i></a></li>
						<li><a href="#" title="" data-placement="bottom" data-toggle="tooltip"
								data-original-title="Email"><i class="fa fa-envelope-o"></i></a></li>
						<li><a href="#" title="" data-placement="bottom" data-toggle="tooltip"
								data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#" title="" data-placement="bottom" data-toggle="tooltip"
								data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#" title="" data-placement="bottom" data-toggle="tooltip"
								data-original-title="Google+"><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
			</div>
			<nav class="navbar navbar-default pgl-navbar-main" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
							data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
								class="icon-bar"></span> <span class="icon-bar"></span> </button>
						<a class="logo" href="index-2.html"><img src="{{ asset('images/logo.png') }}" alt="Flatize"></a>
					</div>

					<div class="navbar-collapse collapse width">
						<ul class="nav navbar-nav pull-right">
							@yield('active')
							<li class="@if ($page == 'index')
								{{'active'}}
							@endif"><a href="{{ route('index') }}">Home</a></li>
							<li class="@if ($page == 'contact')
								{{'active'}}
							@endif"><a href="{{ route('contact') }}">Contact Us</a></li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
				<!--/.container-fluid -->
			</nav>
		</header>
		@yield('content')
		<footer class="pgl-footer">
			<div class="container">
				<div class="pgl-upper-foot">
					<div class="row">
						<div class="col-sm-4">
							<h2>Contact detail</h2>
							<p>Pellentesque nec erat. Aenean semper, neque non faucis. Malesuada, dui felis tempor
								felis,
								vel varius ante diam ut mauris.</p>
							<address>
								<i class="fa fa-map-marker"></i> Office : 1-800-666-8888<br>
								<i class="fa fa-phone"></i> Mobile : 0800-666-6666<br>
								<i class="fa fa-fax"></i> Fax : 1-800-666-8888<br>
								<i class="fa fa-envelope-o"></i> Mail: <a
									href="mailto:pixelgeklab@gmail.com">Pixelgeklab@gmail.com</a>
							</address>
						</div>
						<div class="col-sm-2">
							<h2>Useful links</h2>
							<ul class="list-unstyled">
								<li><a href="#">Help and FAQs</a></li>
								<li><a href="#">Home Price</a></li>
								<li><a href="#">Market View</a></li>
								<li><a href="#">Free Credit Report</a></li>
								<li><a href="#">Terms and Conditions</a></li>
								<li><a href="#">Privacy Policy</a></li>
								<li><a href="#">Community Guidelines</a></li>
							</ul>
						</div>
						<div class="col-sm-2">
							<h2>Pages</h2>
							<ul class="list-unstyled">
								<li><a href="#">Font &amp; Color</a></li>
								<li><a href="#">Blogs</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">404 Page</a></li>
								<li><a href="#">Advanced Search</a></li>
								<li><a href="#">Property Custom Field</a></li>
								<li><a href="#">Google Map</a></li>
							</ul>
						</div>
						<div class="col-sm-4">
							<h2>Don’t miss out</h2>
							<p>In venenatis neque a eros laoreet eu placerat erat suscipit. Fusce cursus, erat ut
								scelerisque condimentum, quam odio ultrices leo.</p>
							<form class="form-inline pgl-form-newsletter" role="form">
								<div class="form-group">
									<label class="sr-only" for="exampleInputEmail2">Email address</label>
									<input type="email" class="form-control" id="exampleInputEmail2"
										placeholder="Enter your email here">
								</div>
								<button type="submit" class="btn btn-submit"><i class="icons icon-submit"></i></button>
							</form>
						</div>
					</div>
				</div>
				<div class="pgl-copyrights">
					<p>Copyright © 2014 RealEstast. Designed by <a href="http://pixelgeeklab.com/">PixelGeekLab</a></p>
				</div>
			</div>
		</footer>
		<!-- End footer -->

	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="{{ asset('vendor/jquery.min.js') }}"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="{{ asset('bootstrap3/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendor/owl-carousel/owl.carousel.js') }}"></script>
	<script src="{{ asset('vendor/flexslider/jquery.flexslider-min.js') }}"></script>
	<script src="{{ asset('vendor/chosen/chosen.jquery.min.js') }}"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true"></script>
	<script src="{{ asset('vendor/gmap/gmap3.infobox.min.js') }}"></script>

	<!-- Theme Initializer -->
	<script src="{{ asset('js/theme.plugins.js') }}"></script>
	<script src="{{ asset('js/theme.js') }}"></script>
	@yield('script')

</body>

<!-- Mirrored from pixelgeeklab.com/html/realestast/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Mar 2021 12:35:23 GMT -->

</html>