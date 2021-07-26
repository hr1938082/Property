@extends('layouts.web.master')
@section('active')
	@php
		$page = 'index'
	@endphp
@endsection
@section('content')


	<!-- Begin Main -->
	<div role="main" class="main">
		<!-- Begin Main Slide -->
		<section class="main-slide">
			<div id="owl-main-slide" class="owl-carousel pgl-main-slide" data-plugin-options='{"autoPlay": true}'>
				<div class="item" id="item1"><img src="{{ asset('images/slides/slider1.jpg') }}" alt="Photo"
						class="img-responsive">
					<div class="item-caption">
						<div class="container">
							<div class="property-info">
								<div class="property-thumb-info-content">
									<h2>Chatham St NW, Roanoke, VA 24012</h2>
									<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
										doloremque laudantium, totam rem aperiam.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item" id="item2"><img src="{{ asset('images/slides/slider2.jpg') }}" alt="Photo"
						class="img-responsive">
					<div class="item-caption">
						<div class="container">
							<div class="property-info">
								<div class="property-thumb-info-content">
									<h2>Presidential Parcel Frames Command Views of Mt.
											Rushmore</h2>
									<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
										doloremque laudantium, totam rem aperiam.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item" id="item3"><img src="{{ asset('images/slides/slider3.jpg') }}" alt="Photo"
						class="img-responsive">
					<div class="item-caption">
						<div class="container">
							<div class="property-info">
								<div class="property-thumb-info-content">
									<h2>Alpine Rd, Stockton, CA 95215</h2>
									<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
										doloremque laudantium, totam rem aperiam.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Main Slide -->
		<!-- Begin Featured -->
		<section class="pgl-featured pgl-bg-grey">
			<div class="container">
				<div class="row">
					<div class="col-md-6 animation">
						<div class="pgl-property featured-item">
							<div class="property-thumb-info">
								<div class="property-thumb-info-image">
									<img alt="" class="img-responsive"
										src="{{ asset('images/properties/property-featured-1.jpg') }}">
								</div>
								<div class="property-thumb-info-content">
									<h3><a href="property-detail.html">Alpine Rd, Stockton, CA 95215</a></h3>
									<p>Amet luctus nisl tempus.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3 animation">
						<div class="pgl-property featured-item">
							<div class="property-thumb-info">
								<div class="property-thumb-info-image">
									<img alt="" class="img-responsive"
										src="{{ asset('images/properties/property-featured-2.jpg') }}">
								</div>
								<div class="property-thumb-info-content">
									<h3><a href="property-detail.html">J St, Modesto, CA 95351</a></h3>
									<p>Amet luctus nisl tempus.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3 animation">
						<div class="pgl-property featured-item">
							<div class="property-thumb-info">
								<div class="property-thumb-info-image">
									<img alt="" class="img-responsive"
										src="{{ asset('images/properties/property-featured-3.jpg') }}">
								</div>
								<div class="property-thumb-info-content">
									<h3><a href="property-detail.html">Spring Gate DrUNIT 4106</a></h3>
									<p>Amet luctus nisl tempus.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3 animation">
						<div class="pgl-property featured-item">
							<div class="property-thumb-info">
								<div class="property-thumb-info-image">
									<img alt="" class="img-responsive"
										src="{{ asset('images/properties/property-featured-4.jpg') }}">
								</div>
								<div class="property-thumb-info-content">
									<h3><a href="property-detail.html">Chatham St NW, Roanoke</a></h3>
									<p>Amet luctus nisl tempus.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3 animation">
						<div class="pgl-property featured-item">
							<div class="property-thumb-info">
								<div class="property-thumb-info-image">
									<img alt="" class="img-responsive"
										src="{{ asset('images/properties/property-featured-5.jpg') }}">
								</div>
								<div class="property-thumb-info-content">
									<h3><a href="property-detail.html">Stockton, CA 95215</a></h3>
									<p>Amet luctus nisl tempus.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr class="top-tall">
			</div>
		</section>
		<!-- End Featured -->

		<!-- Begin Properties -->
		<section class="pgl-properties pgl-bg-grey">
			<div class="container">
				<h2>Properties</h2>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs pgl-pro-tabs text-center animation" role="tablist">
					<li class="active"><a href="#all" role="tab" data-toggle="tab">All</a></li>
					<li><a href="#house" role="tab" data-toggle="tab">House</a></li>
					<li><a href="#offices" role="tab" data-toggle="tab">Offices</a></li>
					<li><a href="#apartment" role="tab" data-toggle="tab">Apartment</a></li>
					<li><a href="#residential" role="tab" data-toggle="tab">Residential</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="all">
						<div class="row">
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-1.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forrent">Rent</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Poolside character home on a wide
													422sqm</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-2.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Presidential Parcel Frames Command Views
													of Mt. Rushmore</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-3.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forsold">Sold</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Californian Class, Grand Family
													Proportions</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-4.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forrent">Rent</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-5.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-6.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="house">
						<div class="row">
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-4.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forrent">Rent</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-5.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-6.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="offices">
						<div class="row">
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-4.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forrent">Rent</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-5.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="apartment">
						<div class="row">
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-4.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forrent">Rent</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-5.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Chatham St NW, Roanoke, VA 24012</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="residential">
						<div class="row">
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-1.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forrent">Rent</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Poolside character home on a wide
													422sqm</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('images/properties/property-2.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Presidential Parcel Frames Command Views
													of Mt. Rushmore</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 animation">
								<div class="pgl-property">
									<div class="property-thumb-info">
										<div class="property-thumb-info-image">
											<img alt="" class="img-responsive"
												src="{{ asset('storeage/images/properties/property-3.jpg') }}">
											<span class="property-thumb-info-label">
												<span class="label price">$358,000</span>
												<span class="label forsold">Sold</span>
											</span>
										</div>
										<div class="property-thumb-info-content">
											<h3><a href="property-detail.html">Californian Class, Grand Family
													Proportions</a></h3>
											<address>Ferris Park, Jersey City Land in Sales</address>
										</div>
										<div class="amenities clearfix">
											<ul class="pull-left">
												<li><strong>Area:</strong> 450<sup>m2</sup></li>
											</ul>
											<ul class="pull-right">
												<li><i class="icons icon-bedroom"></i> 3</li>
												<li><i class="icons icon-bathroom"></i> 2</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>
		<!-- End Properties -->

		<!-- Begin About -->
		<section class="pgl-about">
			<div class="container">
				<div class="row">
					<div class="col-md-4 animation about-item">
						<h2>Who We Are</h2>
						<p><img src="{{ asset('images/content/demo-1.jpg') }}" alt="" class="img-responsive"></p>
						<p>We have a total of 25+ years combined experience dealing exclusively with New York buyers and
							sellers ipsum dolor sit amet, consectetur adipiscing elit.</p>
						<a href="about-us.html" class="btn btn-lg btn-default">View more</a>
					</div>
					<div class="col-md-4 animation about-item">
						<h2>Why Choose Us</h2>
						<div class="panel-group" id="accordion">
							<div class="panel panel-default pgl-panel">
								<div class="panel-heading">
									<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion"
											href="#collapseOne">Designed for your business</a> </h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
											doloremque laudantium, totam rem aperiam.</p>
									</div>
								</div>
							</div>
							<div class="panel panel-default pgl-panel">
								<div class="panel-heading">
									<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion"
											href="#collapseTwo" class="collapsed">Fully responsive</a> </h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
									<div class="panel-body">
										<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
											doloremque laudantium, totam rem aperiam.</p>
									</div>
								</div>
							</div>
							<div class="panel panel-default pgl-panel">
								<div class="panel-heading">
									<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion"
											href="#collapseThree" class="collapsed">Ample customizations</a> </h4>
								</div>
								<div id="collapseThree" class="panel-collapse collapse">
									<div class="panel-body">
										<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
											doloremque laudantium, totam rem aperiam.</p>
									</div>
								</div>
							</div>
							<div class="panel panel-default pgl-panel">
								<div class="panel-heading">
									<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion"
											href="#collapseFouth" class="collapsed">Bootstrap Compatible</a> </h4>
								</div>
								<div id="collapseFouth" class="panel-collapse collapse">
									<div class="panel-body">
										<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
											doloremque laudantium, totam rem aperiam.</p>
									</div>
								</div>
							</div>
							<div class="panel panel-default pgl-panel">
								<div class="panel-heading">
									<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion"
											href="#collapseFive" class="collapsed">Unique Design</a> </h4>
								</div>
								<div id="collapseFive" class="panel-collapse collapse">
									<div class="panel-body">
										<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
											doloremque laudantium, totam rem aperiam.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 animation about-item">
						<h2>Happy Clients</h2>
						<div class="owl-carousel pgl-bg-dark pgl-testimonial"
							data-plugin-options='{"items": 1, "pagination": false, "autoHeight": true}'>
							<div class="col-md-12">
								<div class="testimonial-author">
									<div class="img-thumbnail-small img-circle">
										<img src="{{ asset('images/agents/agent-1.jpg') }}" class="img-circle"
											alt="Andrew MCCarthy">
									</div>
									<h4>Andrew MCCarthy</h4>
									<p><strong>Selller</strong></p>
								</div>
								<div class="divider-quote-sign"><span>“</span></div>
								<blockquote class="testimonial">
									<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
										doloremque laudantium totam rem.</p>
								</blockquote>
							</div>
							<div class="col-md-12">
								<div class="testimonial-author">
									<div class="img-thumbnail-small img-circle">
										<img src="{{ asset('images/agents/team-1.jpeg') }}" class="img-circle"
											alt="John Smith">
									</div>
									<h4>John Smith</h4>
									<p><strong>Selller</strong></p>
								</div>
								<div class="divider-quote-sign"><span>“</span></div>
								<blockquote class="testimonial">
									<p>Sed perspiciatis unde omnisiste natus error voluptatem remopa accusantium
										doloremque laudantium totam rem.</p>
								</blockquote>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End About -->

	</div>
	<!-- End Main -->
</div>
@endsection