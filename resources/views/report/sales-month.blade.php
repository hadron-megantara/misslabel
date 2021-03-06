@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Report - Penjualan Bulanan</h3>
        </div>

        <div class="col-md-12" style="margin-top: -15px;margin-bottom: 10px;padding-right: 0px;text-align: right;">
            <a href="#materialModalPrint" class="btn btn-danger" data-toggle="modal">
                <span class="fa fa-print"> </span>Print
            </a>

            <a href="#materialModalExport" class="btn btn-danger" data-toggle="modal">
                <span class="fa fa-cloud-download"> </span>Download
            </a>
        </div>

        <div class="row"></div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
        	<div class="col-md-3">
	        	<select id="searchMaterialBy" name="searchMaterialBy" class="form-control">
	                @foreach($storeList as $storeList2)
	                    <option value="{{$storeList2->id}}" @if($store == $storeList2->id) selected="" @endif>{{$storeList2->name}}</option>
	                @endforeach
	                <option value="0" @if($store == 0) selected="" @endif >Semua Toko</option>
	            </select>
	        </div>

	        <div class="col-md-3">
	            <select id="searchMaterialByPaymentType" name="searchMaterialByPaymentType" class="form-control">
	                @foreach($paymentType as $paymentType2)
	                    <option value="{{$paymentType2->id}}" @if($payment == $paymentType2->id) selected="" @endif>{{$paymentType2->name}}</option>
	                @endforeach
	                <option value="0" @if($payment == 0) selected="" @endif >Semua Tipe Pembayaran</option>
	            </select>
	        </div>

	        <div class="col-md-3">
	            <select id="searchMaterialByYear" name="searchMaterialByYear" class="form-control">
	                @foreach($yearList as $yearList2)
	                    <option value="{{$yearList2}}" @if($year == $yearList2) selected="" @endif>{{$yearList2}}</option>
	                @endforeach
	            </select>
	        </div>

            <div class="col-md-3">
            	<button type="button" id="filterProcess" class="btn btn-primary" style="width: 100%;"><span class="fa fa-search"> </span>Cari</button>
            </div>
        </div>

        <div class="row"></div>

        <div class="row">
	    	<div class="col-md-12">
		    	<div id="chartOmset" style="height:300px;">
		    		
		    	</div>
		    </div>
	    </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var month = [];
		var omset = [];
		var expense = [];

		@if(count($transactionDataArray) > 0)
			@foreach($transactionDataArray as $transactionDataArray2)
				month.push('{{$transactionDataArray2["month"]}}');
				omset.push({{$transactionDataArray2["value"]}});
			@endforeach
		@endif

		@if(count($expenseDataArray) > 0)
			@foreach($expenseDataArray as $expenseDataArray2)
				expense.push({{$expenseDataArray2["value"]}});
			@endforeach
		@endif

		$(function () { 
		    var myChart = Highcharts.chart('chartOmset', {
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Omset Toko {{$storeName}}'
		        },
		        xAxis: {
		        	title: {
		                text: 'Tahun {{$year}}'
		            },
		            categories: month
		        },
		        yAxis: {
		            tickInterval: 20,
		            lineColor: '#FF0000',
		            lineWidth: 1,
		            title: {
		                text: 'Dalam rupiah'

		            },
		            plotLines: [{
		                value: 0,
		                width: 10,
		                color: '#808080'
		            }]
		        },
		        series: [{
		            name: 'Omset',
		            data: omset,
		        }, {
		        	name: 'Pengeluaran',
		        	data: expense,
		        }]
		    });
		});

		$('#filterProcess').click(function(){
            window.location = "{{ route('report.salesMonth')}}" + '?store='+$("#searchMaterialBy").val()+'&payment='+$("#searchMaterialByPaymentType").val()+'&year='+$("#searchMaterialByYear").val();
        });

	});
</script>

@endsection
