@extends('layouts.web.master')
@section('title')
Contact US
@endsection
@section('active')
@php
$page = 'contact'
@endphp
@endsection
@section('content')
<!-- Begin Main -->
<div role="main" class="main pgl-bg-grey">
    <!-- Begin page top -->
    <section class="page-top">
        <div class="container">
            <div class="page-top-in">
                <h2><span>Contact Us</span></h2>
            </div>
        </div>
    </section>
    <!-- End page top -->
    <!-- Begin content with sidebar -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-offset-2 content">
                <div class="contact">
                    @if (session('status'))
                    @if (session("status") == 'Message has been sent')
                    <div class="alert alert-success" id="contactsuccess">
                        <strong>Success!</strong> Your message has been sent to us.
                    </div>
                    @endif
                    @if (session("status") == 'Message did not send')
                    <div class="alert alert-danger" id="contacterror">
                        <strong>Error!</strong> There was an error sending your message.
                    </div>
                    @endif
                    @endif

                    <form id="contact-form" class="form-contact" action="{{ route('contact-mail-send') }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="name">Your Name*</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        data-msg-required="Please enter your name." required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="email">Your Email*</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        data-msg-required="Please enter your email address."
                                        data-msg-email="Please enter a valid email address." required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="subject">Subject*</label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        data-msg-required="Please enter the subject." required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message*</label>
                            <textarea rows="9" name="message" id="message" class="form-control"
                                data-msg-required="Please enter your message." required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit" class="btn btn-primary min-wide"
                                data-loading-text="Loading...">
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Your address</strong>
                            <address>4 Jasmine Rd, Cairnlea (in Melbourne), Victoria, 3023, Australia</address>
                        </div>
                        <div class="col-sm-6">
                            <address>
                                <strong>Mobile.</strong> +61 413455576<br>
                                <strong>Email.</strong> support@tekumatics.com
                            </address>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End content with sidebar -->
</div>
<!-- End Main -->
@endsection
