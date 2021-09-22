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
				<h2><span>Privacy Policy</span></h2>
			</div>
		</div>
	</section>
	<!-- End page top -->
	<!-- Begin content with sidebar -->
	<div class="container">
		<div class="row">
            <div class="privacyPolicy">
                <div class="inner">


                    <img src="{{ asset('images/Data_security_28.jpg') }}" alt="Privacy Policy">
                    maihommanager is the management tool that helps the landlord/real estate agent or property owners/renters to manage
                    the home, collect the rent, remind/enforce the occupants to take part in their house hold duties/policies, provide
                        an effective platform that enhances friendly home, communications amongst households and the landlord and home
                        affairs etc.
                        Apart from just turning up to collect the rent, it is very hard to manage overall aspact of house/property for rents
                        by the land lord. So many Landlords who has people in their house for rents face challenges trying to make sure
                        their property is well managed and looked after. Arguments between the tenants, late or untimely rent payment, lack
                        of communication between the landlord and tenants etc. are some of those areas challenging for the landlord.
                        Especially for those shared house (Renting rooms) it is even more bizarre. Hence maihommanager is the management
                        tool that helps the landlord/real estate agent or property owners/renters to manage the home, collect the rent,
                        remind/enforce the occupants to take part in their house hold duties/policies, provide an effective platform that
                        enhances friendly home, communications amongst households and the landlord and home affairs etc.
                        The system is a customised solution property manager app- designed and developed based on research and personal
                        experience living in number of years in shared accommodations. Living in a shared house/accomodation is sometimes
                        worse given the people with a different ways of living and doing things. App is designed to work on those areas and
                        help the landlord manage its property well and efficiently. The app takes over the landlords management tasks and
                        allows landlord to save time, effort, money and increase its profitability.
                </div>
            </div>
			{{-- <div class="col-md-8 col-sm-offset-2 content">

			</div> --}}
		</div>
	</div>
	<!-- End content with sidebar -->
</div>


@endsection
