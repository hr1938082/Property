@extends('layouts.admin.master')

@section('title')
Add Properties
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="width-100">
    <div class="width-300">
        <form enctype="multipart/form-data" action="{{ route('insert-properties') }}" id="property" class="w-100 d-flex mt-2" method="post">
            @csrf
            <div class="wrapper fadeInDown align-items-center" style="height: 100vh">
                <div id="formContent">
                    <div class="fadeIn first my-2">
                        {{ __('Property Information') }}
                    </div>
                    <div class="form-group">
                        <input id="name" type="text" class="fadeIn second" placeholder="Name" name="property_name"
                            autocomplete="off" autofocus>
                        <div class="text-danger" id="name-span"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-inline justify-content-center">
                            <select class="fadeIn px-1" name="bed_rooms" id="bed_rooms" style="width: 115px">
                                <option selected disabled>Bed Rooms</option>
                                <option class="text-capitalize" value="1">1</option>
                                <option class="text-capitalize" value="2">2</option>
                                <option class="text-capitalize" value="3">3</option>
                            </select>
                            <select class="fadeIn px-1" name="bath_rooms" id="bath_rooms" style="width: 115px">
                                <option selected disabled>Bath Rooms</option>
                                <option class="text-capitalize" value="1">1</option>
                                <option class="text-capitalize" value="2">2</option>
                                <option class="text-capitalize" value="3">3</option>
                            </select>
                            <select class="fadeIn px-1" name="toilets" id="toilets" style="width: 115px">
                                <option selected disabled>Toilets</option>
                                <option class="text-capitalize" value="1">1</option>
                                <option class="text-capitalize" value="2">2</option>
                                <option class="text-capitalize" value="3">3</option>
                            </select>
                        </div>
                        <div class="text-danger" id="room-span"></div>
                    </div>
                    <div class="form-group">
                        <textarea id="description" autocomplete="none" type="text" class="fadeIn third shadow-none"
                            placeholder="Description" name="description"></textarea>
                        <div class="text-danger" id="description-span"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-inline justify-content-center">
                            <div style="width: 190px">
                                <select class="fadeIn" name="currency_id" id="currency_id">
                                    <option selected disabled>currency</option>
                                    @foreach ($currency as $curr)
                                        <option value="{{$curr->id}}">{{$curr->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="width: 190px">
                                <input id="Rent" type="text" class="fadeIn third" name="rent" placeholder="Rent"
                                    autocomplete="none">
                            </div>
                            <div class="text-danger" id="Rent-span"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Year Build</label>
                        <div class="form-inline justify-content-center">
                            <select class="fadeIn third px-1 rounded-0 m-0" name="build_date" id="build_date"
                                style="width: 70px; border-top-left-radius: 5px !important;border-bottom-left-radius: 5px !important;">
                                <option selected disabled>Date</option>
                                @for ($i = 1; $i <= 31; $i++) <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
                            <select class="fadeIn third px-1 rounded-0 m-0" name="build_month" id="build_month"
                                style="width: 90px">
                                <option selected disabled>Month</option>
                                @for ($i = 1; $i <= 12; $i++) <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
                            <select class="fadeIn third px-1 rounded-0 m-0" name="build_year" id="build_year"
                                style="width: 90px">
                                <option selected disabled>Year</option>
                                @for ($i = $date; $i >= ($date-100); $i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="text-danger" id="year_build"></div>
                    </div>
                    <input id="first" type="button" class="fadeIn fourth" value="{{ __('Next') }}">
                </div>
            </div>
            <div class="wrapper fadeInDown align-items-center" style="height: 100vh">
                <div id="formContent">
                    <div class="fadeIn first my-2">
                        {{ __('Property Address') }}
                    </div>
                    <div class="form-group">
                        <div class="form-inline justify-content-center">
                            <select class="fadeIn px-1" name="country" id="country-input">
                                <option selected disabled>Country</option>
                                @foreach ($country as $stateval)
                                    <option value="{{$stateval->country}}">{{$stateval->country}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-danger" id="country-span"></div>
                    </div>
                    <div class="form-group">
                        <div class="form-inline justify-content-center">
                            <select class="fadeIn px-1" name="state" id="state-input" style="width: 185px">
                                <option selected disabled>State</option>
                            </select>
                            <select class="fadeIn px-1" name="city" id="city-input" style="width: 185px">
                                <option selected disabled>City</option>
                            </select>
                        </div>
                        <div class="text-danger" id="city_sate-span"></div>
                    </div>
                    <div class="form-group">
                        <input id="street" type="text" placeholder="Street" name="street" autocomplete="none" autofocus>
                        <div class="text-danger" id="street-span"></div>
                    </div>
                    <div class="form-group">
                        <input id="zipcode" type="text" placeholder="Zip code" name="zip_code" autocomplete="none"
                            autofocus>
                        <div class="text-danger" id="zipcode-span"></div>
                    </div>
                    <input id="second" type="button" class="fadeIn fourth" value="{{ __('Next') }}">
                </div>
            </div>
            <div class="wrapper fadeInDown align-items-center" style="height: 100vh">
                <div id="formContent">
                    <div class="fadeIn first my-2">
                        {{ __('Property Images') }}
                    </div>
                    <div class="col-md-12">
                        <div class="card shadow-sm w-100">
                            <div class="card-header d-flex justify-content-center">
                                <input type="file" name="images[]" id="inpImg" multiple hidden>
                                <input type="button" id="image_btn"
                                    value="{{ __('Choose Images') }}">
                            </div>
                            <div class="card-body d-flex flex-wrap justify-content-center" id="imgContainerMulti">
                            </div>
                            <p class="d-none" id="cardBodyPara">File Not Supported</p>
                        </div>
                    </div>
                    <input type="submit" id="third" value="{{ __('Submit') }}">
                    </>
                </div>
            </div>
        </form>
    </div>
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
@section('js')
<script>
    const inpImg = document.querySelector('#inpImg');
    const image_btn = document.querySelector('#image_btn');
    const cardBody = document.querySelector('.card-body');
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
                    }, false)
                    reader.readAsDataURL(fileFill);
                } else {
                    cardBodyPara.classList.remove('d-none');
                    cardBodyPara.classList.add('d-block');
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
    });
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
            } else if ($('#description').val() == "") {
                $('#Rent').css('border', 'none');
                $('#Rent-span').text("");
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', '1px solid red')
                $('#description-span').text("Provide Some details!!")
            }else if ($('#currency_id').val() == null){
                $('#name-span').text("")
                $('#name').css('border', 'none');
                $('#bed_rooms').css('border', 'none');
                $('#bath_rooms').css('border', 'none');
                $('#room-span').text("");
                $('#description').css('border', 'none');
                $('#description-span').text("");
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
                $('#Rent-span').text("");
                $('#build_date').css('border', 'none');
                $('#build_month').css('border', 'none');
                $('#build_year').css('border', '1px solid red');
                $('#year_build').text("Year of build!!");
            } else {
                $('.width-300').addClass('active100');
            }

        });
        $('#second').click(() => {
            if ($('#country-input').val() == "") {
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("");
                $('#country-input').css('border','1px solid red');
                $('#country-span').text('Country is Required!!');
            }else if ($('#state-input').val() == "") {
                $('#country-input').css('border','none');
                $('#country-span').text('');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', '1px solid red');
                $('#city_sate-span').text("State is Required!!")
            } else if ($('#city-input').val() == "") {
                $('#country-input').css('border','none');
                $('#country-span').text('');
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#state-input').css('border', 'none');
                $('#city-input').css('border', '1px solid red');
                $('#city_sate-span').text("City is Required!!")
            } else if ($('#street').val() == "") {
                $('#country-input').css('border','none');
                $('#country-span').text('');
                $('#zipcode').css('border', 'none');
                $('#zipcode-span').text("")
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', '1px solid red');
                $('#street-span').text("Street is Required!!")
            } else if ($('#zipcode').val() == "") {
                $('#country-input').css('border','none');
                $('#country-span').text('');
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', '1px solid red');
                $('#zipcode-span').text("Zipcode is Required!!")
            } else if (isNaN(parseInt($('#zipcode').val()))) {
                $('#country-input').css('border','none');
                $('#country-span').text('');
                $('#city-input').css('border', 'none');
                $('#state-input').css('border', 'none');
                $('#city_sate-span').text("")
                $('#street').css('border', 'none');
                $('#street-span').text("")
                $('#zipcode').css('border', '1px solid red');
                $('#zipcode-span').text("Only Numbers are allowed!!")
            } else {
                $('.width-300').addClass('active200');
            }
        })
        $('#third').click((e) => {
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

