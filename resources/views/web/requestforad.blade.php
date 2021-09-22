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
<div class="container-fluid">
    @if (session('status'))
        <h3 class="alert alert-success " style="text-align: center; margin-top: 10ewm">{{session('status')}}</h3>
    @endif
    <form action="{{ route('adds.request.send') }}" enctype="multipart/form-data" method="post" style="display: flex; justify-content: space-around; flex-wrap: wrap">
        @csrf
        <div class="advertisement-form">
            <h3>Advertisement Information</h3>
                <div class="form-group">
                    <input id="name" type="text" class="form-control" placeholder="Name" name="property_name"
                        autocomplete="off" autofocus>
                    <div class="text-danger" id="name-span"></div>
                </div>
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                        <select class="form-control" name="bed_rooms" id="bed_rooms">
                            <option selected disabled>Bed Rooms</option>
                            <option class="text-capitalize" value="1">1</option>
                            <option class="text-capitalize" value="2">2</option>
                            <option class="text-capitalize" value="3">3</option>
                        </select>
                        <select class="form-control" name="bath_rooms" id="bath_rooms">
                            <option selected disabled>Bath Rooms</option>
                            <option class="text-capitalize" value="1">1</option>
                            <option class="text-capitalize" value="2">2</option>
                            <option class="text-capitalize" value="3">3</option>
                        </select>
                        <select class="form-control" name="toilets" id="toilets" style="width: 121px">
                            <option selected disabled>Toilets</option>
                            <option class="text-capitalize" value="1">1</option>
                            <option class="text-capitalize" value="2">2</option>
                            <option class="text-capitalize" value="3">3</option>
                        </select>
                    </div>
                    <div class="text-danger" id="room-span"></div>
                </div>
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                            <select class="form-control" name="currency_id" id="currency_id">
                                <option selected disabled>Currency</option>
                                @foreach ($currency as $curr)
                                    <option value="{{$curr->id}}">{{$curr->currency}}</option>
                                @endforeach
                            </select>
                            <input id="Rent" type="text" class="form-control" name="rent" placeholder="Price"
                                autocomplete="none">
                            <select class="form-control" name="for" id="for_id">
                                <option selected disabled>For</option>
                                <option value="sale">Sale</option>
                                <option value="rent">Rent</option>
                            </select>
                    </div>
                    <div class="text-danger" id="Rent-span"></div>
                </div>
                <div class="form-group">
                    <div class="form-inline justify-content-center">
                        <label>Year Build</label>
                        <div class="form-inline">
                            <select class="form-control" name="build_date" id="build_date">
                                <option selected disabled>Date</option>
                                @for ($i = 1; $i <= 31; $i++) <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
                            <select class="form-control" name="build_month" id="build_month">
                                <option selected disabled>Month</option>
                                @for ($i = 1; $i <= 12; $i++) <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
                            <select class="form-control" name="build_year" id="build_year">
                                <option selected disabled>Year</option>
                                @for ($i = $date; $i >= ($date-100); $i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <select class="form-control"name="type" id="type_id">
                                <option selected disabled>Type</option>
                                <option value="house">House</option>
                                <option value="offices">Offices</option>
                                <option value="apartment">Apartment</option>
                                <option value="residential">Residential</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-danger" id="year_build"></div>
                </div>
                <div class="form-group">
                    <textarea id="description" autocomplete="none" type="text" class="form-control"
                        placeholder="Description" name="description"></textarea>
                    <div class="text-danger" id="description-span"></div>
                </div>
                <button type="button" id="first" class="btn btn-primary btn-block">Next</button>
        </div>
        <div class="advertisement-form address" id="address">
            <h3>Address</h3>
            <div class="form-group">
                <select class="form-control" name="country" id="country-input">
                    <option selected disabled>Country</option>
                    @foreach ($country as $stateval)
                        <option value="{{$stateval->country}}">{{$stateval->country}}</option>
                    @endforeach
                </select>
                <div class="text-danger" id="country-span"></div>
            </div>
            <div class="form-group">
                <div class="form-inline">
                    <select class="form-control" style="width: 195px;" name="state" id="state-input">
                        <option selected disabled>State</option>
                        @foreach ($state as $stateval)
                            <option value="{{$stateval->state}}">{{$stateval->state}}</option>
                        @endforeach
                    </select>
                    <select class="form-control" style="width: 195px;" name="city" id="city-input">
                        <option selected disabled>City</option>
                    </select>
                </div>
                <div class="text-danger" id="city_sate-span"></div>
            </div>
            <div class="form-group">
                <input id="street" class="form-control" type="text" placeholder="Street" name="street" autocomplete="none">
                <div class="text-danger" id="street-span"></div>
            </div>
            <div class="form-group">
                <input id="zipcode" class="form-control" type="text" placeholder="Zip code" name="zip_code" autocomplete="none"
                    autofocus>
                <div class="text-danger" id="zipcode-span"></div>
            </div>
            <button type="button" id="second" class="btn btn-primary btn-block">Next</button>
        </div>
        <div class="advertisement-form owner" id="owner">
            <h3>Owner Details</h3>
            <div class="form-group">
                <input id="owner_name" class="form-control" type="text" placeholder="Name" name="owner_name" autocomplete="none">
                <div class="text-danger" id="owner_name-span"></div>
            </div>
            <div class="form-group">
                <input id="owner_email" class="form-control" type="text" placeholder="Email" name="owner_email" autocomplete="none">
                <div class="text-danger" id="owner_email-span"></div>
            </div>
            <div class="form-group">
                <input id="owner_phone" class="form-control" type="text" placeholder="Phone" name="owner_phone" autocomplete="none">
                <div class="text-danger" id="owner_phone-span"></div>
            </div>
            <button type="button" id="third" class="btn btn-primary btn-block">Next</button>
        </div>
        <div class="advertisement-form image" id="image">
            <h3>Images</h3>
            <div class="d-flex justify-content-center">
                <input type="file" style="display: none" name="images[]" id="inpImg" multiple hidden>
                <input type="button" class="btn btn-default" id="image_btn"
                    value="{{ __('Choose Images') }}">
            </div>
            <div id="imgContainerMulti" style="margin: 1rem 0; border: 1px solid; border-radius: 2rem; padding: 1rem 1rem">
            </div>
            <p style="display: none" id="cardBodyPara">File Not Supported</p>
            <input type="submit" id="forth" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>
<!-- Modal -->
<div class="modal fade" id="verifyEmpty" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body bg-light">
                <p class="text-danger">Are you sure You want to upload property without images</p>
                <div class="d-flex justify-content-center">
                    <button type="submit" form="property" id="modalPropertySubmit" class="btn btn-warning btn-sm w-25 ">Yes</button>
                    <button type="button" class="btn btn-secondary btn-sm w-25 mx-2" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const inpImg = document.querySelector('#inpImg');
    const image_btn = document.querySelector('#image_btn');
    const cardBody = document.querySelector('#imgContainerMulti');
    const cardBodyPara = document.querySelector('#cardBodyPara');
    // const host = "http://127.0.0.1:8000"
    const country = document.querySelector('#country-input');
    const state = document.querySelector('#state-input');
    const city = document.querySelector('#city-input');
    let images = [];
    image_btn.addEventListener('click', () => {
        inpImg.click();
    });
    inpImg.addEventListener('change', (e) => {
        const file = inpImg.files;
        cardBody.innerHTML = "";
        for (const fileFill of file) {
            if (fileFill) {
                if ((/\.(gif|jpe?g|tiff?|png|webp|bmp)$/i).test(fileFill.name)) {
                    cardBodyPara.classList.remove('d-block');
                    cardBodyPara.classList.add('d-none');
                    const reader = new FileReader();
                    reader.addEventListener("load", () => {
                        const img = document.createElement('img');
                        img.src = reader.result;
                        cardBody.appendChild(img);
                        img.style.margin = '1rem 1rem'
                    })
                    reader.readAsDataURL(fileFill);
                } else {
                    cardBodyPara.style.display = "block"
                }
            }
        }
    });
    country.addEventListener('change',()=>{
        $.ajax({
            type:"GET",
            headers:{
                "Accept":"application/json"
            },
            url:`/territory/state/select/${country.value}`,
            success:(res)=>{
                state.innerHTML = "";
                const data= res.data;
                const statesget = data[0].state
                data.map((value)=>{
                    const option = document.createElement("option");
                    option.text = value.state;
                    option.value = value.state;
                    state.appendChild(option);
                });

                $.ajax({
                    type:"GET",
                    headers:{
                        "Accept":"application/json"
                    },
                    url:`/territory/city/select/${statesget}`,
                    success:(res)=>{
                        city.innerHTML = "";
                        const data= res.data;
                        data.map((value)=>{

                            const option = document.createElement("option");
                            option.text = value.city;
                            option.value = value.city;
                            city.appendChild(option);
                        });
                    }
                })
            }
        })
    })
    state.addEventListener('change',()=>{
        $.ajax({
            type:"GET",
            headers:{
                "Accept":"application/json"
            },
            url:`/territory/city/select/${state.value}`,
            success:(res)=>{
                city.innerHTML = "";
                const data= res.data;
                data.map((value)=>{

                    const option = document.createElement("option");
                    option.text = value.city;
                    option.value = value.city;
                    city.appendChild(option);
                });
            }
        })

    });
    $(document).ready(() => {
        // validation start
        $('#first').click(() => {
            if ($('#name').val() == "") {
                $('#description').css('border', 'none')
                $('#description-span').text("")
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name').css('border', '1px solid red');
                $('#name-span').text("Name is Required!!")
            } else if ($('#name').val().length <= 3) {
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("")
                $('#description').css('border', 'none')
                $('#description-span').text("")
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name-span').text("")
                $('#name').css('border', '1px solid red');
                $('#name-span').text("Name is too short!!")
            } else if ($('#bed_rooms').val() == null) {
                $('#bath_rooms').css('border', 'none');
                $('#description').css('border', 'none')
                $('#description-span').text("")
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', '1px solid red');
                $('#room-span').text("How many Bed Rooms does it have!!")
            } else if ($('#bath_rooms').val() == null) {
                $('#description').css('border', 'none')
                $('#description-span').text("")
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', '1px solid red');
                $('#room-span').text("How many Bath Rooms does it have!!")
            } else if($('#toilets').val() == null) {
                $('#description').css('border', 'none')
                $('#description-span').text("")
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#toilets').css('border','1px solid red')
                $('#room-span').text("How many Toilets does it have!!")
            } else if ($('#currency_id').val() == null){
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#toilets').css('border','none')
                $('#currency_id').css('border', '1px solid red');
                $('#Rent-span').text("Please select currency of this property!!");
            } else if ($('#Rent').val() == "") {
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#Rent').css('border', '1px solid red');
                $('#currency_id').css('border', 'none');
                $('#Rent-span').text("Please Provide Rent of this property!!");
            } else if (isNaN(parseInt($('#Rent').val()))) {
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#currency_id').css('border', 'none');
                $('#Rent').css('border', '1px solid red');
                $('#Rent-span').text("Only numbers are allowed!!");
            }else if($('#for_id').val() == null){
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#currency_id').css('border', 'none');
                $('#Rent').css('border', 'none');
                $('#for_id').css('border', '1px solid red');
                $('#Rent-span').text("For rent or for sale!!");
            } else if ($('#build_date').val() == null) {
                $('#build_month').css('border', 'none');
                $('#build_year').css('border', 'none');
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#currency_id').css('border', 'none');
                $('#for_id').css('border', 'none');
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#build_date').css('border', '1px solid red');
                $('#year_build').text("Date of build!!");
            } else if ($('#build_month').val() == null) {
                $('#build_year').css('border', 'none');
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#currency_id').css('border', 'none');
                $('#Rent').css('border', 'none');
                $('#for_id').css('border', 'none')
                $('#Rent-span').text("");
                $('#build_date').css('border', 'none');
                $('#build_month').css('border', '1px solid red');
                $('#year_build').text("Month of build!!");
            } else if ($('#build_year').val() == null) {
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#currency_id').css('border', 'none');
                $('#Rent').css('border', 'none');
                $('#for_id').css('border', 'none')
                $('#Rent-span').text("");
                $('#build_date').css('border', 'none');
                $('#build_month').css('border', 'none');
                $('#build_year').css('border', '1px solid red');
                $('#year_build').text("Year of build!!");
            }else if($('#type_id').val() == null){
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
                $('#currency_id').css('border', 'none');
                $('#Rent').css('border', 'none');
                $('#for_id').css('border', 'none')
                $('#Rent-span').text("");
                $('#build_date').css('border', 'none');
                $('#build_month').css('border', 'none');
                $('#build_year').css('border', 'none');
                $('#type_id').css('border', '1px solid red');
                $('#year_build').text("Select property type!!");
            }else if ($('#description').val() == "") {
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', '1px solid red')
                $('#description-span').text("Provide Some details!!")
            } else {
                $('#address').addClass('active');
            }

        });
        $('#second').click(() => {
            if ($('#country-input').val() == "") {
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#country-input').css('border', '1px solid red');
                $('#country-span').text("City is Required!!")
            }else if ($('#city-input').val() == "") {
                $('#country-input').css('border', 'none');
                $('#country-span').text("")
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', '1px solid red');
                $('#city_sate-span').text("City is Required!!")
            } else if ($('#state-input').val() == "") {
                $('#country-input').css('border', 'none');
                $('#country-span').text("")
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', '1px solid red');
                $('#city_sate-span').text("State is Required!!")
            } else if ($('#street').val() == "") {
                $('#country-input').css('border', 'none');
                $('#country-span').text("")
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', '1px solid red');
                $('#street-span').text("Street is Required!!")
            } else if ($('#zipcode').val() == "") {
                $('#country-input').css('border', 'none');
                $('#country-span').text("")
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', '1px solid red');
                $('#zipcode-span').text("Zipcode is Required!!")
            } else if (isNaN(parseInt($('#zipcode').val()))) {
                $('#country-input').css('border', 'none');
                $('#country-span').text("")
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', '1px solid red');
                $('#zipcode-span').text("Only Numbers are allowed!!")
            }else {
                $('.owner').addClass('active');
            }
        })
        $('#third').click((e)=>{
            if($('#owner_name').val() == ""){
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#owner_name').css('border', '1px solid red');
                $('#owner_name-span').text("Owner name is required!!")
            }else if($('#owner_email').val() == ""){
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("")
                $('#owner_email').css('border', '1px solid red');
                $('#owner_email-span').text("Owner Email is required");
            }else if(!(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/).test($('#owner_email').val())){
                $('#owner_phone').css('border', 'none');
                $('#owner_phone-span').text("");
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("");
                $('#owner_email').css('border', '1px solid red');
                $('#owner_email-span').text("Invalid Email");
            }else if($('#owner_phone').val() == ""){
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#owner_name').css('border', 'none');
                $('#owner_name-span').text("");
                $('#owner_email').css('border', 'none');
                $('#owner_email-span').text("");
                $('#owner_phone').css('border', '1px solid red');
                $('#owner_phone-span').text("Owner Phone is required");
            }else{
                $('.image').addClass('active');
            }
        })
        $('#forth').click((e) => {
            if ($('#inpImg').val() == "") {
                e.preventDefault();
                $('#modalPropertySubmit').attr('form','property');
                $('#verifyEmpty').modal('show')

            }
            else
            {
                $(this).attr('form','property');
            }
        });
        // validation end
    })
</script>
@endsection
