@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Report - Penjualan Tahunan</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#materialModalPrint" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-print"> </span>Print
                </a>

                <a href="#materialModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
        	<div class="col-md-3">
	            <span style="font-weight: bold; margin-right: 10px">Filter Toko</span>

	            <select id="searchMaterialBy" name="searchMaterialBy">
	                @foreach($storeList as $storeList2)
	                    <option value="{{$storeList2->id}}" @if($store == $storeList2->id) selected="" @endif>{{$storeList2->name}}</option>
	                @endforeach
	                <option value="" @if($store == 0) selected="" @endif >Semua Toko</option>
	            </select>
	        </div>

	        <div class="col-md-3">
	            <span style="font-weight: bold;">Filter Pembayaran</span>

	            <select id="searchMaterialByPaymentType" name="searchMaterialByPaymentType">
	                @foreach($paymentType as $paymentType2)
	                    <option value="{{$paymentType2->id}}" @if($payment == $paymentType2->id) selected="" @endif>{{$paymentType2->name}}</option>
	                @endforeach
	                <option value="" @if($store == 0) selected="" @endif >Semua Tipe Pembayaran</option>
	            </select>
	        </div>

	        <div class="col-md-3">
	            {{-- <span style="font-weight: bold; margin-right: 10px">Filter Toko</span>

	            <select id="searchMaterialBy" name="searchMaterialBy">
	                @foreach($storeList as $storeList2)
	                    <option value="{{$storeList2->id}}" @if($store == $storeList2->id) selected="" @endif>{{$storeList2->name}}</option>
	                @endforeach
	                <option value="" @if($store == 0) selected="" @endif >Semua Toko</option>
	            </select> --}}
	        </div>

            <div class="col-md-3">
            	<button type="button" id="filterProcess" class="btn btn-primary" style="width: 100%;margin-top:15px"><span class="fa fa-search"> </span>Cari</button>
            </div>
        </div>

        <div class="row"></div>

        <div class="row">
	    	<div class="col-md-12">
		    	<div id="chartExpense" style="height:300px;">
		    		
		    	</div>
		    </div>
	    </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		var expenseValue = [670000000, 720000000, 650000000, 710000000, 800000000, 750000000, 680000000, 720000000, 760000000];
		var income = [1000000000, 1300000000, 1250000000, 1400000000, 1800000000, 1350000000, 1400000000, 1430000000, 1480000000];

		$(function () { 
		    var myChart = Highcharts.chart('chartExpense', {
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Penjualan'
		        },
		        xAxis: {
		        	title: {
		                text: 'Tahun 2017'
		            },
		            categories: month
		        },
		        yAxis: {
		            title: {
		                text: 'Dalam rupiah'
		            }
		        },
		        series: [{
		            name: 'Pengeluaran',
		            data: expenseValue,
		        },{
		            name: 'Omset',
		            data: income,
		        }]
		    });
		});

	});
</script>

@endsection
