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
                        Estate Agent, and the tenant versions. The Landlord installs the landlord version and creates
                        his/her profile. Then As part of the contract/agreement, the Landlord send the link and tell the
                        tenants to install this app on their phone. The Landlord version is pretty much an admin version
                        which the admin installs on its phone and sends the link to the tenants to download their tenant
                        version of the app for free. The Landlord will need to spend about 20 minutes going through the
                        app
                        filling the information and can prefill or leave blank for the tenants which tenants themselves
                        could complete via the tenant version of the app. Dates when the tenant first moved in and when
                        the rent is due are some of the information. Whatever days/week the landlord assigns, the app
                        will automatically send the reminder alerts a day or two in advance. The app enable follow up
                        and the collection of rent and tell both landlord and tenants when the next rent is due. The App
                        will then make a record and generate a mini financial statement of total amount collected, spent
                        if any, the time when it is collected, and the total balance. The Landlord also create the
                        rooster, where tenants are assigned with household duties like the person to clean the shower
                        room, clean the toilet, taking the rubbish out. The app will automatically act on it and send
                        alerts and a reminder when the dates assigned is approaching. </p>

                    <ul>
                        <li>
                            <h5>Search Property/shared house for rent</h5>
                            <p>
                                Whether you are looking for a room for rent in a shared house, shared apartment,
                                housemates, or the whole house for rent, all these can be done through the app. All you
                                have to do is enter your state, suburb, and postcode of the preferred area you are
                                searching, which will pop up based on your search and what we have on our system.
                            </p>
                        </li>
                        <li>
                            <h5>Price/Service Fee</h5>
                            <p>
                                We charge 10 dollars for each property uploaded per month after 3 months of a free
                                trial. Tenants will use it for free. Landlord/agent can sign out if they are not happy
                                after the 3 months trial.
                            </p>
                        </li>
                        <li>
                            <h5>How to use/sign up</h5>
                            <p>
                                We have two versions of the app. The landlord and the tenant versions. The landlord/real
                                estate agent can download the landlord version of the app from play store, install it on
                                their phone/laptop and then create their profile that includes the address of the
                                property, rates of rent, etc. As a part of the tenancy agreement or contract, the
                                landlord can send the link to their tenants to download the tenant version of the app
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End content with sidebar -->
</div>


@endsection
