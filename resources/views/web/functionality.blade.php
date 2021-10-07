@extends('layouts.web.master')
@section('title')
Functionality
@endsection
@section('active')
@php
$page = 'functionality';
@endphp
@endsection
@section('content')
<div role="main" class="main pgl-bg-grey">
    <!-- Begin page top -->
    <section class="page-top">
        <div class="container">
            <div class="page-top-in">
                <h2><span>Funclionality</span></h2>
            </div>
        </div>
    </section>
    <!-- End page top -->
    <!-- Begin content with sidebar -->
    <div class="container">
        <div class="row">
            <div class="about">
                <div class="inner">
                    <h3 class="text-center">Functionality</h3>
                    <h4>App description/functionality</h4>
                    <p>There are two versions of the app, they are the Landlord version which can also be used by Real
                        Estate Agent, and the tenant versions.
                        The Landlord installs the landlord version and creates his/her profile. Then As part of the
                        contract/agreement, the Landlord has to send the link and tell the tenants to install this app
                        on their phone. The Landlord version is pretty much an admin version which the admin installs on
                        its phone and sends the link to the tenants to download their tenant version of the app. The
                        Landlord will need to spend about 20 minutes going through the app filling the information and
                        can prefill or leave blank for the tenants which tenants themselves could complete via the
                        tenant version of the app. Dates when the tenant first moved in and then the next rent due date
                        (how many days later) etc. are some of the information. Whatever days/week the landlord assigns,
                        the app will automatically send the reminder alerts a day or two in advance. The app will follow
                        up and collect the rent, keep records, and tell both landlord and tenants when the next rent is
                        due. The App will automatically collect the rent online. The App will then make a record and
                        generate a mini financial statement of how much being collected, spent if any, the time when it
                        is collected, how much balance, etc.
                        The Landlord will also assign the rooster. Assign every tenant with household duties like who is
                        cleaning the shower room, who is cleaning the toilet, taking the rubbish out, etc. The landlord
                        via the Landlord version can assign and make a roaster which the app will automatically act on
                        it and send alerts and a reminder when approaching the date.
                        The app has a community noticeboard. This feature provides a platform for all the house
                        occupants to discuss concerns, issues, agendas, etc. concerning the house or anything amongst
                        them. For example like if the toilet is blocked or, washing machine not working, etc. will be
                        needed to be discussed by everyone. The app can take videos/photos. If the Toilet is a block or
                        the washing machine is not working etc. any tenants can make a video/photo and post it directly
                        to the landlord or the community discussion board. The landlord does not need to drive all the
                        way to see what's going on, instead, the video/photos can be okay for him to know what's going
                        on. The app has a link of an external- nearby service providers provider like plumber,
                        electricians, etc., or even their preferred service providers. The Landlord can forward the
                        video/photo plus the description to the plumber or their preferred plumbers just via the app.
                        Every property management task will be automated and the app will continue to routinely execute
                        the tasks. The Landlord doesn’t need to tell its tenants what to do like household duties etc,
                        instead, the app will routinely do that. Once programmed by filling out space via the Landlord
                        version, the app will continue to communicate and manage the home affair on behalf of the
                        landlord. The app will collect and keep records of rents on behalf of the landlord, the app will
                        maintain the household community relationship amongst the tenants and the landlord; the app will
                        improve the communication level, foster understanding and agreeing home responsibilities, etc.
                        The App will automatically do everything for the Landlord </p>

                <ul>
                    <li>
                        <h5>Search Property/shared house for rent</h5>
                        <p>
                            Whether you are looking for a room for rent in a shared house, shared apartment, housemates, or the whole house for rent, we have them all here for you. Enter your state, suburb, and postcode of the preferred area you are searching and we will bring you up what we have on our system. Landlords/property owners using our property manager app can market/list their properties here with us for free.
                        </p>
                    </li>
                    <li>
                        <h5>Price/Service Fee</h5>
                        <p>
                            We charge 10 dollars per property per month after 3 months of a free trial. Tenants will use it for free. Landlord/agent can sign out if they are not happy after the 3 months trial. As part of the contract, the landlord can create their
                        </p>
                    </li>
                    <li>
                        <h5>How to use/sign up</h5>
                        <p>
                            We have two versions of the app. The landlord and the tenant versions. The landlord/real estate agent can download the landlord version of the app, install it on their phone/laptop and then create their profile that includes the address of the property, rates of rent, etc. As a part of the tenancy agreement or contract, the landlord can send the link to their tenants to download the tenant version of the app.
                        </p>
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
