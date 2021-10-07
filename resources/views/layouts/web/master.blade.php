<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from pixelgeeklab.com/html/realestast/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Mar 2021 12:33:52 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="Tekumatics" />
    <meta name="description" content="Your home and property manager">
    <meta name="author" content="Tekumatics">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tekumatics  | @yield('title')</title>

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link href="{{ asset('bootstrap3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
                    <ul class="nav nav-pills nav-top navbar-right">
                        @php
                            $social = DB::table('social_links')->get();
                            $socialLinks = [
                                $social[0]->name => $social[0]->link,
                                $social[1]->name => $social[1]->link,
                                $social[2]->name => $social[2]->link,
                                $social[3]->name => $social[3]->link,
                            ];
                        @endphp
                        <li><a href="{{$socialLinks['facebook']}}" title="" data-placement="bottom" data-toggle="tooltip"
                                data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="{{$socialLinks['insta']}}" title="" data-placement="bottom" data-toggle="tooltip"
                                data-original-title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="{{$socialLinks['twitter']}}" title="" data-placement="bottom" data-toggle="tooltip"
                                data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="{{$socialLinks['linkedin']}}" title="" data-placement="bottom" data-toggle="tooltip"
                            data-original-title="LinkedIn"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
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
                        <a class="logo" style="overflow: hidden" href="{{ route('index') }}">
                            <img height="100%" width="100%" src="{{ asset('images/logo.png') }}" alt="Flatize">
                        </a>
                    </div>

                    <div class="navbar-collapse collapse width">
                        <ul class="nav navbar-nav pull-right">
                            @yield('active')
                            <li class="@if ($page == 'home')
								{{'active'}}
							@endif"><a href="{{ route('index') }}">Home</a></li>
                            <li class="@if ($page == 'contact')
								{{'active'}}
							@endif"><a href="{{ route('contact') }}">Contact</a></li>
                            <li class="@if ($page == 'privacy')
								{{'active'}}
							@endif"><a href="{{ route('policy') }}">Privacy Policy</a></li>
                            <li class="@if ($page == 'about')
								{{'active'}}
							@endif"><a href="{{ route('about') }}">About</a></li>
                            <li class="@if ($page == 'benefits')
								{{'active'}}
							@endif"><a href="{{ route('benefits') }}">Benefits</a></li>
                            <li class="@if ($page == 'functionality')
								{{'active'}}
							@endif"><a href="{{ route('functionality') }}">Functionality</a></li>

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
                    <div class="row" style="display: flex; justify-content: space-between">
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
                        {{-- <div class="col-sm-2">
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
                        </div> --}}
                        <div class="col-sm-4">

                            <h2 style="margin-bottom:10px">Extra Links</h2>
                            <ul style="list-style: none;">
                                <li class="@if ($page == 'contact')
                                {{'active'}}
                            @endif"><a href="{{ route('contact') }}">Contact</a></li>
                            <li class="@if ($page == 'privacy')
                                {{'active'}}
                            @endif"><a href="{{ route('policy') }}">Privacy Policy</a></li>
                                </ul>
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
                    <p id="copyright">Copyright © {{date('Y')}} Tekumatics. Designed by <a href="http://pixelgeeklab.com/">PixelGeekLab</a></p>
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
