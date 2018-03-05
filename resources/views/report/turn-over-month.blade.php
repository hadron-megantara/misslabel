@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Omset - Bulanan</h3>
        </div>

        <div class="row">
	    	<div class="col-md-12">
	    		<hr style="border-top: 2px solid #949494;">
	    	</div>

	    	<div class="col-md-12">
		    	<div id="chartTurnOver" style="height:300px;">
		    		
		    	</div>
		    </div>
	    </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var month = [];
		var omset = [];
		@if(count($transactionDataArray) > 0)
			@foreach($transactionDataArray as $transactionDataArray2)
				month.push('{{$transactionDataArray2["month"]}}');
				omset.push({{$transactionDataArray2["value"]}});
			@endforeach
		@endif

		$(function () { 
		    var myChart = Highcharts.chart('chartTurnOver', {
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
		        }]
		    });
		});

		$('#filterProcess').click(function(){
            window.location = "{{ route('report.salesMonth')}}" + '?store='+$("#searchMaterialBy").val()+'&payment='+$("#searchMaterialByPaymentType").val()+'&year='+$("#searchMaterialByYear").val();
        });
	});
</script>

@endsection
