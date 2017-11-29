@extends('layouts.app')

@section('content')

<?php
    use Carbon\Carbon;
?>

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Nota Barang Keluar</h3>
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
            <div class="row">
                <div class="col-md-3">
                    &nbsp;
                </div>

                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Dari</span>
                </div>

                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Sampai</span>
                </div>

                <div class="row" style="margin-bottom: 5px"></div>

                <div class="col-md-3">
                    &nbsp;
                </div>

                <div class="col-md-3">
                    <input id="filterDateFrom" type="text" class="form-control" name="filterDateFrom" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" @if(isset($_GET['dateFrom']) && $_GET['dateFrom'] != '') value="{{$_GET['dateFrom']}}" @endif />
                </div>

                <div class="col-md-3">
                    <input type="text" id ="filterDateTo" class="form-control filterDateTo" name="filterDateTo" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" @if(isset($_GET['dateTo']) && $_GET['dateTo'] != '') value="{{$_GET['dateTo']}}" @endif />
                </div>

                <div class="col-md-3">
                    <button type="button" id="filterProcess" class="btn btn-primary" style="width: 100%"><span class="fa fa-search"> </span>Cari</button>
                </div>
            </div>
        </div>

        <div class="row"></div>

        @if(session('success'))
            <div class="panel panel-success">
                <div class="panel-heading notification text-center">
                    {{session('success')}}
                </div>
            </div>
        @endif

        <div class="table-responsive">
        	<table id="materialTable" class="table-bordered" style="padding:">
        		<thead>
        			<tr>
        				<th class="text-center">Toko</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nota</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var t = $('#materialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('warehouse.deliveryNote.getDeliveryNote') }}'+"?dateFrom={{$dateFrom}}&dateTo={{$dateTo}}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'date_delivery', name: 'date_delivery', render: function(data, type, full){
                        var year = data.substring(0,4);
                        var month = data.substring(5,7);
                        var date = data.substring(8,10);
                        var dateTime = new Date(Date.UTC(year, month - 1, date));
                        var options = {weekday: "long", year: "numeric", month: "long", day: "numeric"};
                        data = dateTime.toLocaleString("in-ID", options);
                        return data;
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a href="/warehouse/delivery-note/download-note?id='+data+'" style="text-decoration: underline" target="_blank">download</a></div>';
                    }
                },
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $('#filterDateFrom, #filterDateTo').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });

        $('#filterDateFrom').keypress(function(event){
            event.preventDefault();
        });

        $('#filterDateTo').keypress(function(event){
            event.preventDefault();
        });

        $('#filterProcess').click(function(){
            window.location = "{{ route('warehouse.deliveryNote')}}" + '?&dateFrom='+$("#filterDateFrom").val()+'&dateTo='+$("#filterDateTo").val();
        });

	});
</script>

@endsection
