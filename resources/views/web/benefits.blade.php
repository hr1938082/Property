@extends('layouts.web.master')
@section('title')
Benefits
@endsection
@section('active')
@php
$page = 'benefits';
@endphp
@endsection
@section('content')
<div role="main" class="main pgl-bg-grey">
    <!-- Begin page top -->
    <section class="page-top">
        <div class="container">
            <div class="page-top-in">
                <h2><span>Benifits</span></h2>
            </div>
        </div>
    </section>
    <!-- End page top -->
    <!-- Begin content with sidebar -->
    <div class="container">
        <div class="row">
            <div class="about">
                <div class="inner">
                    <h3 class="text-center">Benefit</h3>
                    <h4>BENEFITS OF USING OUR APP</h4>
                    <p>Tekumatics property management platform is designed to solve day to day hurdles and problems
                        faced by real estate agent or landlords when managing their property on rent. This app
                        automatically takes care of every aspect of your property management and significantly reduces
                        the time, effort, and energy use towards managing your property. By doing so, it increases your
                        profitability, savings, etc. Some of the benefits:</p>
                    <ul>
                        <li>
                            <h5>Automated Rent Collection</h5>
                            <p>Tekumatics App will manage your worry and stress about late rent collections. Our smart
                                algorithm will enable you to know when exactly to send rent alert messages to tenants
                                and to collect rent quickly. If the tenant's account was to bounce, the app will give
                                logged notifications and reminders on your behalf and report yourself and your tenant on
                                your behalf. </p>
                        </li>
                        <li>
                            <h5>Financial Statement </h5>
                            <p>Tekumatics App produces an end of the year mini financial statement for your properties
                                that captures rent financial histories of every individual tenant. The app provides
                                revenue vs expenditure and total revenue generated end of the financial year. The app
                                algorithm takes away the burden of doing manual accounting. </p>
                        </li>
                        <li>
                            <h5>Free Listing and marketing </h5>
                            <p>Tekumatics system freely allow the landlord or property owners to list and market their
                                rooms or properties in order to find tenants. We have numerous contacts of users
                                registered in our system which can be also reached for marketing purposes. 
                            </p>
                        </li>
                        <li>
                            <h5>Pay bills via our app </h5>
                            <p>Tenants/landlords don’t have to go to post office, banks, or agents to pay for their
                                water, gas, or electricity bills thereby wasting time and energy. It can be done easily
                                via tekumatics app from the convenience of their time and location. </p>
                        </li>
                        <li>
                            <h5>Manages and enforce every tenant of their home duties </h5>
                            <p>The landlord through its profile via the landlord version of the app can create a roaster
                                for every tenant to participate in their home duties like cleaning, taking the rubbish
                                out, etc. Our App automates it and send alerts/reminders to make sure all assigned
                                duties are done.</p>
                        </li>
                        <li>
                            <h5>Provide communication platform </h5>
                            <p>Tekumatics app has a feature that allow household/community discussion done openly or
                                done privately between tenants or tenant to landlord. Thus, any issue concerning
                                household can be discussed through the app using the chat features. The landlord/real
                                estate agent can pretty much manage everything via the app remotely without going to the
                                property.</p>
                        </li>
                        <li>
                            <h5>Solves issues and Provides a peaceful friendly home</h5>
                            <p>Our app promotes communication and understanding amongst the tenants. Our app acts as a
                                home mother and assigns and enforces every tenant to participate in household duties
                                etc. For example, if the app asks Peter to take the Rubbish out and, John to clean the
                                kitchen, etc</p>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- <div class="col-md-8 col-sm-offset-2 content">

            </div> --}}
        </div>
    </div>
    <!-- End content with sidebar -->
</div>


@endsection
