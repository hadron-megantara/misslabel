@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>

        <div class="row">
        	<div class="col-md-4 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Omset</span>
		              	<span class="info-box-number">Rp {{number_format($omset->total,2,",",".")}}</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-4 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Profit</span>
		              	<span class="info-box-number">Rp {{number_format($profit,2,",",".")}}</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-4 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar "></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Pengeluaran</span>
		              	<span class="info-box-number">Rp {{number_format($expense->total,2,",",".")}}</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-4 col-sm-6 col-xs-12">
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

	    	<div class="col-md-4 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-money"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Piutang</span>
		              	<span class="info-box-number">Rp {{number_format($receivable->total,2,",",".")}}</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-4 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-google "></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Stok Gudang</span>
		              	<span class="info-box-number">{{number_format($stockWarehouse->total,0,".",".")}} pcs</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-4 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-text-width "></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Stok Toko - Total</span>
		              	<span class="info-box-number">{{number_format($stockStore->total,0,".",".")}} pcs</span>
		            </div>
	    		</div>
	    	</div>

	    	@foreach($stockStoreDetail as $stockStoreDetail2)
		    	<div class="col-md-4 col-sm-6 col-xs-12">
		    		<div class="info-box">
		    			<span class="info-box-icon bg-yellow">
		    				<span class="fa fa-text-width "></span>
		    			</span>

		    			<div class="info-box-content">
			              	<span class="info-box-text">Stok Toko - {{$stockStoreDetail2->name}}</span>
			              	<span class="info-box-number">{{number_format($stockStoreDetail2->total,0,".",".")}} pcs</span>
			            </div>
		    		</div>
		    	</div>
		    @endforeach

	    	<div class="row"></div>

	    	{{-- <div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div>

	    	<div class="col-md-12">
		    	<div id="chartExpense" style="height:300px;">
		    		
		    	</div>
		    </div>

		    <div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div> --}}
	    </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		var expenseValue = [670000000, 720000000, 650000000, 710000000, 800000000, 750000000, 680000000, 720000000, 760000000, 800000000, 820000000];
		var omset = [1000000000, 1300000000, 1250000000, 1400000000, 1800000000, 1350000000, 1400000000, 1430000000, 1480000000, 1520000000, 1550000000];
		var profit = [200000000, 250000000, 300000000, 350000000, 420000000, 470000000, 480000000, 490000000, 530000000, 550000000, 590000000];

		$(function () { 
		    var myChart = Highcharts.chart('chartExpense', {
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Pengeluaran - Omset - Profit'
		        },
		        xAxis: {
		        	title: {
		                text: 'Tahun 2017'
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
		            name: 'Pengeluaran',
		            data: expenseValue,
		        },{
		            name: 'Omset',
		            data: omset,
		        },{
		            name: 'Profit',
		            data: profit,
		        }]
		    });
		});

	});
</script>

@endsection
