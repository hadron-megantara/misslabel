@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>

        <div class="row">
	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Omset</span>
		              	<span class="info-box-number">Rp 370.000.000</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-money"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Hutang</span>
		              	<span class="info-box-number">Rp 250.000.000</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-money"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Piutang</span>
		              	<span class="info-box-number">Rp 305.000.000</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-th-list "></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Stok</span>
		              	<span class="info-box-number">12.500</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="row"></div>

	    	<div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div>

	    	<div class="col-md-12">
		    	<div id="chartExpense" style="height:300px;">
		    		
		    	</div>
		    </div>

		    <div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div>

		    <div class="col-md-12">
		    	<div id="chartDebt" style="height:300px;">
		    		
		    	</div>
		    </div>

		    <div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div>

		    <div class="col-md-12">
		    	<div id="chartStock" style="height:300px;">
		    		
		    	</div>
		    </div>

		    <div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div>

		    <div class="col-md-12">
		    	<div id="stockChart" style="height:300px;">
		    		
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
		            text: 'Pengeluaran & Omset'
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

		var hutang = [300000000, 350000000, 550000000, 610000000, 640000000, 690000000, 800000000, 810000000, 850000000];
		var piutang = [500000000, 700000000, 650000000, 800000000, 830000000, 900000000, 1050000000, 940000000, 1050000000];

		$(function () { 
		    var myChart = Highcharts.chart('chartDebt', {
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Hutang & Piutang'
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
		            name: 'Hutang',
		            data: hutang,
		        },{
		            name: 'Piutang',
		            data: piutang,
		        }]
		    });
		});

		var stock = [2900, 3100, 4200, 5500, 6300, 6900, 7200, 8600, 11000];

		$(function () { 
		    var myChart = Highcharts.chart('chartStock', {
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Stok'
		        },
		        xAxis: {
		        	title: {
		                text: 'Tahun 2017'
		            },
		            categories: month
		        },
		        yAxis: {
		            title: {
		                text: 'Total Stok'
		            }
		        },
		        series: [{
		            name: 'Stok',
		            data: stock,
		        }]
		    });
		});

		$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {
		    // Create the chart
		    Highcharts.stockChart('stockChart', {
		        rangeSelector: {
		            selected: 1
		        },

		        title: {
		            text: 'AAPL Stock Price'
		        },

		        series: [{
		            name: 'AAPL',
		            data: data,
		            tooltip: {
		                valueDecimals: 2
		            }
		        }]
		    });
		});

	});
</script>

@endsection
