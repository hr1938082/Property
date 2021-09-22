@extends('layouts.admin.master')

@section('title')
Edit Property Details
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection
@section('content')
<div class="row justify-content-center align-items-center m-0" id="register">
    <div class="col-md-6 col-10 form active" style="margin-top: 150px;">
        <div class="row mt-3 justify-content-center">
            <div class="col-12 position-relative">
                <h5 class="text-center">Images</h5>
                <a href="{{ route('adds.editimages', ['id'=>$data[0]['id']]) }}" class="property_image_edit" style="transform: translate(-50%,-30%);color:white">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            <div id="waterwheel-carousel">
                @foreach ($data[0]['images'] as $items)
                    <div class="char">
                        @php
                            $item = $items['path'];
                        @endphp
                        <img src='{{ asset("$item") }}' alt="" >
                    </div>
                @endforeach
            </div>
        </div>
        <table class="table table-borderless">
            <tbody>
                <tr class="text-center">
                    <th colspan="2" class="position-relative">
                        Information
                        <a href="{{ route('adds.editinfo', ['id'=>$data[0]['id']]) }}" class="property_image_edit" type="button"style="transform: translate(-50%,-30%);color:white">
                            <i class="fas fa-edit"></i>
                        </a>
                    </th>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Name</th>
                    <td class="text-capitalize">
                        {{$data[0]["name"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Bed room</th>
                    <td>
                        {{$data[0]["bed_rooms"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Bath Room</th>
                    <td>
                        {{$data[0]["bath_rooms"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Toilets</th>
                    <td>
                        {{$data[0]["toilets"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Price</th>
                    <td>
                        {{$data[0]["rent"]}}
                    </td>
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Currency</th>
                    <td>
                        {{$data[0]["currency"]}}
                    </td>
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Year Build</th>
                    <td>
                        {{$data[0]["year_build"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Description</th>
                    <td>
                        {{$data[0]["description"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">For</th>
                    <td class="text-capitalize">
                        {{$data[0]["for"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Type</th>
                    <td class="text-capitalize">
                        {{$data[0]["type"]}}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-borderless">
            <tbody>
                <tr class="text-center">
                    <th colspan="2" class="position-relative">
                        Address
                        <a href="{{ route('adds.editaddress', ['id'=>$data[0]['id']]) }}" class="property_image_edit" type="button"style="transform: translate(-50%,-30%);color:white">
                            <i class="fas fa-edit"></i>
                        </a>
                    </th>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Country</th>
                    <td class="text-capitalize">
                        {{$data[0]["country"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">City</th>
                    <td class="text-capitalize">
                        {{$data[0]["city"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">State</th>
                    <td class="text-capitalize">
                        {{$data[0]["state"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Street</th>
                    <td class="text-capitalize">
                        {{$data[0]["street"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Zip Code</th>
                    <td>
                        {{$data[0]["zip_code"]}}
                    </td>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-borderless">
            <tbody>
                <tr class="text-center">
                    <th colspan="2" class="position-relative">
                        Owner's Details
                        <a href="{{ route('adds.editowner', ['id'=>$data[0]['id']]) }}" class="property_image_edit" type="button"style="transform: translate(-50%,-30%);color:white">
                            <i class="fas fa-edit"></i>
                        </a>
                    </th>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Name</th>
                    <td class="text-capitalize">
                        {{$data[0]["owner"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Email</th>
                    <td class="text-capitalize">
                        {{$data[0]["owner_email"]}}
                    </td>
                </tr>
                <tr class="text-center">
                    <th class="w-25">Phone</th>
                    <td class="text-capitalize">
                        {{$data[0]["owner_phone"]}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('js')
<script
  src="https://code.jquery.com/jquery-1.9.0.min.js"
  integrity="sha256-f6DVw/U4x2+HjgEqw5BZf67Kq/5vudRZuRkljnbF344="
  crossorigin="anonymous"></script>
  <script src="{{ asset('js/jquery.waterwheelCarousel.min.js') }}"></script>
<script>
    $(document).ready(function () {
    var carousel = $("#waterwheel-carousel").waterwheelCarousel({
      horizon: 110,
      horizonOffset: 0,
      horizonOffsetMultiplier: .7,
      activeClassName: "active",
      separation: 90,
      flankingItems: 3,
      keyboardNav: true,
      edgeFadeEnabled: false,
      separationMultiplier: .8
    });

          $('#prev').bind('click', function () {
            carousel.prev();
            return false
          });

          $('#next').bind('click', function () {
            carousel.next();
            return false;
          });


    });
</script>
@endsection
