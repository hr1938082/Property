@extends('layouts.admin.master')

@section('title')
Dashboard
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')
<div class="row justify-content-end align-items-center pr-5 m-0" style="height: 90vh; margin-top: 10vh !important">
  <div class="col-8 mr-5">
    <div class="row justify-content-between">
      <div class="col-lg-5 bg-primary rounded-lg shadow-lg text-white text-center">
        <h5 class="m-0 mt-2 font-weight-bold">Total Rent</h5>
        <p class="mb-2text-white" style="letter-spacing: -0.5px">Total rent paid by Tenants</p>
        <h5 class="font-weight-bold">{{$rent->rent}}</h5>
      </div>
      <div class="col-lg-5 bg-danger rounded-lg shadow-lg text-center text-white">
        <h5 class="m-0 mt-2 font-weight-bold">Average Utility</h5>
        <p class="mb-2 " style="letter-spacing: -0.5px">Average Utility paid by Tenants</p>
        <h5 class="font-weight-bold">{{$utility->utility}}</h5>
      </div>
    </div>
    <figure class="highcharts-figure shadow-lg border">
      <div id="container"></div>
    </figure>
  </div>
</div>
@endsection
@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
  const data = <?php
    echo json_encode($datas);
  ?>;
  const cat = [];
  const rent = [];
  for (const iterator of data) {
    rent.push(iterator.rent)
  }
  for (const iterator of data) {
    cat.push(iterator.month)
  }
  Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Yearly Rent Paid'
    },
    xAxis: {
        categories: cat,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rent ($)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} $</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Rent',
        data: rent

    }]
});
</script>
@endsection
