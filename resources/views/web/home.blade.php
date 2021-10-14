@extends('layouts.web.master')
@section('title')
Home
@endsection
@section('active')
@php
$page = 'home'
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
                                <p>
                                    This system is an easy tool which enable Landlords to upload, list and manage their
                                    properties and to find perfect renters. Also, the system can be use as a convenient
                                    means for landlords to get rentals from tenants and to manage utility bills.
                                </p>
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
                                <p>
                                    This system can be use by tenants to find properties for rent and for sales. Also,
                                    the system can be use by tenants as a platform for communication between other
                                    tenants and landlords.

                                </p>
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
                                <p>
                                    As a landlord or tenant Tekmatics system will make the search of properties seamless
                                    and rewarding.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Slide -->

    <!-- Begin Properties -->
    <section class="pgl-properties pgl-bg-grey">
        <div class="container">
            <h2>Properties</h2>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs pgl-pro-tabs text-center animation" role="tablist">
                <li class="active"><a href="#all" role="tab" data-toggle="tab">All</a></li>
                <li><a href="#room" role="tab" data-toggle="tab">Rooms</a></li>
                <li><a href="#house" role="tab" data-toggle="tab">House</a></li>
                <li><a href="#offices" role="tab" data-toggle="tab">Offices</a></li>
                <li><a href="#apartment" role="tab" data-toggle="tab">Apartment</a></li>
                <li><a href="#residential" role="tab" data-toggle="tab">Residential</a></li>
                <li><a href="{{ route('adds.request') }}" class="btn btn-lg btn-default" style="margin: 10px 0">Apply
                        for Ad</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="all">
                    <div style="display: flex; flex-wrap: wrap;">
                        @foreach ($select as $item)
                        <div class="col-xs-4 animation">
                            <div class="pgl-property">
                                <div class="property-thumb-info">
                                    <div class="property-thumb-info-image">
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($select_images as $images)
                                        @if ($item->id === $images->id && $count === 0)
                                        <img style="height: 200px; overflow: hidden;" alt="" class="img-responsive"
                                            src="{{ asset($images->name_dir) }}">
                                        $count ++;
                                        @endif
                                        @endforeach
                                        <span class="property-thumb-info-label">
                                            <span class="label price">{{"$item->rent $item->currency_name"}}</span>
                                            <span class="label forrent text-capitalize">{{$item->for_type}}</span>
                                        </span>
                                    </div>
                                    <div class="property-thumb-info-content">
                                        <h3>
                                            {{Str::substr($item->description, 0,50)}}
                                        </h3>
                                        <a href="{{ route('web.add', ['id'=>$item->id]) }}"
                                            class="btn btn-lg btn-default">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="room">
                    <div style="display: flex; flex-wrap: wrap;">
                        @foreach ($select as $item)
                        @if ($item->type == "room")
                        <div class="col-xs-4 animation">
                            <div class="pgl-property">
                                <div class="property-thumb-info">
                                    <div class="property-thumb-info-image">
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($select_images as $images)
                                        @if ($item->id === $images->id && $count === 0)
                                        <img style="height: 200px; overflow: hidden;" alt="" class="img-responsive"
                                            src="{{ asset($images->name_dir) }}">
                                        $count ++;
                                        @endif
                                        @endforeach
                                        <span class="property-thumb-info-label">
                                            <span class="label price">{{"$item->rent $item->currency_name"}}</span>
                                            <span class="label forrent text-capitalize">{{$item->for_type}}</span>
                                        </span>
                                    </div>
                                    <div class="property-thumb-info-content">
                                        <h3>
                                            {{Str::substr($item->description, 0,50)}}
                                        </h3>
                                        <a href="{{ route('web.add', ['id'=>$item->id]) }}"
                                            class="btn btn-lg btn-default">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="house">
                    <div style="display: flex; flex-wrap: wrap;">
                        @foreach ($select as $item)
                        @if ($item->type == "house")
                        <div class="col-xs-4 animation">
                            <div class="pgl-property">
                                <div class="property-thumb-info">
                                    <div class="property-thumb-info-image">
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($select_images as $images)
                                        @if ($item->id === $images->id && $count === 0)
                                        <img style="height: 200px; overflow: hidden;" alt="" class="img-responsive"
                                            src="{{ asset($images->name_dir) }}">
                                        $count ++;
                                        @endif
                                        @endforeach
                                        <span class="property-thumb-info-label">
                                            <span class="label price">{{"$item->rent $item->currency_name"}}</span>
                                            <span class="label forrent text-capitalize">{{$item->for_type}}</span>
                                        </span>
                                    </div>
                                    <div class="property-thumb-info-content">
                                        <h3>
                                            {{Str::substr($item->description, 0,50)}}
                                        </h3>
                                        <a href="{{ route('web.add', ['id'=>$item->id]) }}"
                                            class="btn btn-lg btn-default">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="offices">
                    <div style="display: flex; flex-wrap: wrap;">
                        @foreach ($select as $item)
                        @if ($item->type == "offices")
                        <div class="col-xs-4 animation">
                            <div class="pgl-property">
                                <div class="property-thumb-info">
                                    <div class="property-thumb-info-image">
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($select_images as $images)
                                        @if ($item->id === $images->id && $count === 0)
                                        <img style="height: 200px; overflow: hidden;" alt="" class="img-responsive"
                                            src="{{ asset($images->name_dir) }}">
                                        $count ++;
                                        @endif
                                        @endforeach
                                        <span class="property-thumb-info-label">
                                            <span class="label price">{{"$item->rent $item->currency_name"}}</span>
                                            <span class="label forrent text-capitalize">{{$item->for_type}}</span>
                                        </span>
                                    </div>
                                    <div class="property-thumb-info-content">
                                        <h3>
                                            {{Str::substr($item->description, 0,50)}}
                                        </h3>
                                        <a href="{{ route('web.add', ['id'=>$item->id]) }}"
                                            class="btn btn-lg btn-default">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="apartment">
                    <div style="display: flex; flex-wrap: wrap;">
                        @foreach ($select as $item)
                        @if ($item->type == "apartment")
                        <div class="col-xs-4 animation">
                            <div class="pgl-property">
                                <div class="property-thumb-info">
                                    <div class="property-thumb-info-image">
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($select_images as $images)
                                        @if ($item->id === $images->id && $count === 0)
                                        <img style="height: 200px; overflow: hidden;" alt="" class="img-responsive"
                                            src="{{ asset($images->name_dir) }}">
                                        $count ++;
                                        @endif
                                        @endforeach
                                        <span class="property-thumb-info-label">
                                            <span class="label price">{{"$item->rent $item->currency_name"}}</span>
                                            <span class="label forrent text-capitalize">{{$item->for_type}}</span>
                                        </span>
                                    </div>
                                    <div class="property-thumb-info-content">
                                        <h3>
                                            {{Str::substr($item->description, 0,50)}}
                                        </h3>
                                        <a href="{{ route('web.add', ['id'=>$item->id]) }}"
                                            class="btn btn-lg btn-default">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="residential">
                    <div style="display: flex; flex-wrap: wrap;">
                        @foreach ($select as $item)
                        @if ($item->type == "residential")
                        <div class="col-xs-4 animation">
                            <div class="pgl-property">
                                <div class="property-thumb-info">
                                    <div class="property-thumb-info-image">
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($select_images as $images)
                                        @if ($item->id === $images->id && $count === 0)
                                        <img style="height: 200px; overflow: hidden;" alt="" class="img-responsive"
                                            src="{{ asset($images->name_dir) }}">
                                        $count ++;
                                        @endif
                                        @endforeach
                                        <span class="property-thumb-info-label">
                                            <span class="label price">{{"$item->rent $item->currency_name"}}</span>
                                            <span class="label forrent text-capitalize">{{$item->for_type}}</span>
                                        </span>
                                    </div>
                                    <div class="property-thumb-info-content">
                                        <h3>
                                            {{Str::substr($item->description, 0,50)}}
                                        </h3>
                                        <a href="{{ route('web.add', ['id'=>$item->id]) }}"
                                            class="btn btn-lg btn-default">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="float-right">
                    @if ($select instanceof \Illuminate\Pagination\AbstractPaginator)
                    {{$select->links()}}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End Properties -->

    <!-- Begin About -->
    <section class="pgl-about">
        <div class="container">
            <div class="row" style="display: flex; justify-content: space-between;">
                <div class="col-md-4 animation about-item">
                    <h2>Who We Are</h2>
                    <p><img src="{{ asset('images/content/demo-1.jpg') }}" alt="" class="img-responsive"></p>
                    <p>Tekumatics Homemanager is the management app that helps the landlord/real estate agent or
                        property owners/renters to manage the home...</p>
                    <a href="{{ route('about') }}" class="btn btn-lg btn-default">View more</a>
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
                                <p><strong>Landlord</strong></p>
                            </div>
                            <div class="divider-quote-sign"><span>“</span></div>
                            <blockquote class="testimonial">
                                <p>As a Landlord, I love this tool, it has been very helpful as a good source for my
                                    property management</p>
                            </blockquote>
                        </div>
                        <div class="col-md-12">
                            <div class="testimonial-author">
                                <div class="img-thumbnail-small img-circle">
                                    <img src="{{ asset('images/agents/team-1.jpeg') }}" class="img-circle"
                                        alt="John Smith">
                                </div>
                                <h4>John Smith</h4>
                                <p><strong>Tenant</strong></p>
                            </div>
                            <div class="divider-quote-sign"><span>“</span></div>
                            <blockquote class="testimonial">
                                <p>The system enables me to track and manage my rentals and utilities also, it allow me
                                    communicate with my landlord concerning any issue and with other tenants</p>
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
