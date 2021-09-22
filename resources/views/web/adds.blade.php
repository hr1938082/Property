@extends('layouts.web.master')
@section('title')
Privacy Policy
@endsection
@section('active')
@php
$page = 'privacy';
@endphp
@endsection
@section('content')
<div role="main" class="main pgl-bg-grey">
    <!-- Begin page top -->
    <section class="page-top">
        <div class="container">
            <div class="page-top-in">
                <h2><span>Property Details</span></h2>
            </div>
        </div>
    </section>
    <!-- End page top -->
    <!-- Begin content with sidebar -->
    <div class="container">
        <div class="row">
            <div class="privacyPolicy">
                <h2>{{$select->ad_name}}</h2>
                <p>
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    {{$select->street}}
                </p>
                <section class="main-slide">
                    <div id="owl-main-slide" class="owl-carousel pgl-main-slide"
                        data-plugin-options='{"autoPlay": true}'>
                        @foreach ($select_images as $item)
                            @if ($item->property_id === $select->id)
                            <div class="item" id="item1">
                                <img src="{{ asset($item->name_dir) }}" alt="Photo"class="img-responsive">
                            </div>
                            @endif
                        @endforeach
                    </div>
                </section>
                <h3 style="margin-top: 2rem">Property Details</h3>
                <p>
                    {{$select->description}}
                </p>
                <hr>
                <h3>Essential Information</h3>
                <div style="display: flex">
                    <div style="width: 50%;">
                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Price: {{"$select->rent $select->currency_name"}}
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            For: Sale
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Bedrooms: {{$select->bed_rooms}}
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Bathrooms: {{$select->bath_rooms}}
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Toilets: {{$select->toilets}}
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Year Build: {{$select->year_build}}
                        </p>
                    </div>
                    <div style="width: 50%;">

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Owner: {{$select->owner}}
                        </p>
                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Email: {{$select->owner_email}}
                        </p>
                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Contact: {{$select->owner_phone}}
                        </p>
                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            State: {{$select->state}}
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            City: {{$select->city}}
                        </p>

                        <p style="font-size: 1.7rem">
                            <i class="fa fa-check-square text-success" aria-hidden="true"></i>
                            Zip Code: {{$select->zip_code}}
                        </p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-8 col-sm-offset-2 content">

			</div> --}}
        </div>
    </div>
    <!-- End content with sidebar -->
</div>


@endsection
