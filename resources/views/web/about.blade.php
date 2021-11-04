@extends('layouts.web.master')
@section('title')
About US
@endsection
@section('active')
@php
$page = 'about';
@endphp
@endsection
@section('content')
<div role="main" class="main pgl-bg-grey">
    <!-- Begin page top -->
    <section class="page-top">
        <div class="container">
            <div class="page-top-in">
                <h2><span>About Us</span></h2>
            </div>
        </div>
    </section>
    <!-- End page top -->
    <!-- Begin content with sidebar -->
    <div class="container">
        <div class="row">
            <div class="about">
                <div class="inner">
                    <h3 class="text-center">About</h3>
                    <p>
                        Tekumatics is a management app developed to help landlord, real estate agent or property owners
                        and tenants to manage the property well and efficiently such as collection of rent, enforcing
                        and reminding tenants to take part in household duties or policies, provide an effective
                        platform that enhances friendly home, communication among landlord and tenants and for rental
                        payment. Tekumatics App takes over the landlord's management tasks and allows a landlord to save
                        time, effort, money, and increase its profitability. Tekumatics app is a customized solution
                        property manager app- designed and developed based on research and personal experience. This app
                        has a function to make a video, voice record, write notes, etc which can be of great use
                        especially during the inspection of the property. It can be a very good communication platform
                        between the tenant and the real estate agent. This app automates every aspect of managing
                        properties from the signing in of new tenants into a home, reminding them of their household
                        duties, collecting their rent, keeping records, and notify when to pay next; improves and
                        provide a very efficient communication platform between the household community including the
                        landlord itself.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End content with sidebar -->
</div>


@endsection
