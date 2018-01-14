@extends('layouts.app')

@section('content')

<?php
    use Carbon\Carbon;
?>

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>List Bahan</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right" style="margin-top: 5px">
                <a href="#materialModalPrint" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-print"> </span>Print
                </a>

                <a href="#materialModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="row"></div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <div class="row">
                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Filter Data</span>
                </div>

                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Dari</span>
                </div>

                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Sampai</span>
                </div>

                <div class="row" style="margin-bottom: 5px"></div>

                <div class="col-md-3">
                    <select id="searchMaterialBy" name="searchMaterialBy">
                        <option value="0" @if(!isset($_GET['status']) || $_GET['status'] == 0) selected="" @endif>Baru dibeli</option>
                        <option value="1" @if(isset($_GET['status']) && $_GET['status'] == 1) selected="" @endif>Masuk di Konveksi</option>
                        <option value="2" @if(isset($_GET['status']) && $_GET['status'] == 2) selected="" @endif>Semua Pembelian</option>
                    </select>
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
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a> {{session('success')}}
                </div>
            </div>
        @endif

        <div class="table-responsive">
        	<table id="materialTable" class="table-bordered" style="padding:">
        		<thead>
        			<tr>
        				<th class="text-center" style="padding: 10px 18px">Tipe Bahan</th>
                        <th class="text-center">Panjang</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Tanggal Pembelian</th>
        				<th class="actions-column text-center">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialModalSend" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kirim Bahan ke Konveksi</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.sendMaterial') }}" role="form" id="sendForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="sendMaterialType" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="sendMaterialType" type="text" class="form-control" disabled="">
                            <input type="hidden" id="sendMaterialId" name="materialId" />
                            <input type="hidden" id="sendMaterialTypeHidden" name="materialType" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialLength" class="col-md-4 control-label">Panjang</label>

                        <div class="col-md-6">
                            <input id="sendMaterialLength" type="text" class="form-control" disabled="">
                            <input id="sendMaterialLengthHidden" type="hidden" name="materialLength" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialColor" class="col-md-4 control-label">Warna</label>

                        <div class="col-md-6">
                            <input id="sendMaterialColor" type="text" class="form-control" disabled="">
                            <input id="sendMaterialColorHidden" type="hidden" name="materialColor" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialPrice" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="sendMaterialPrice" type="text" class="form-control" disabled="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialDatePurchase" class="col-md-4 control-label">Tanggal Pembelian</label>

                        <div class="col-md-6">
                            <input id="sendMaterialDatePurchase" type="text" class="form-control" disabled="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialConvection" class="col-md-4 control-label">Pilih Konveksi</label>

                        <div class="col-md-6">
                            <select id="sendMaterialConvection" name="convectionId" class="form-control">
                                @foreach($convectionList as $convectionList)
                                    <option value="{{$convectionList->id}}">{{$convectionList->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="sendForm"><span class="fa fa-sign-out"></span> Kirim</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var indexCounter = 1;

        var t = $('#materialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('material.getMaterial') }}'+"?status={{$status}}&dateFrom={{$dateFrom}}&dateTo={{$dateTo}}",
            columns: [
                { data: 'material_type', name: 'material_type' },
                { data: 'length', name: 'length', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data+' yard';
                    }
                },
                { data: 'color', name: 'color'},
                { data: 'price', name: 'price', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    } 
                },
                { data: 'date_purchase', name: 'date_purchase', render: function(data, type, full){
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
                        var dataReturn = '<div class="text-center"><input type="hidden" id="materialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="materialLength_'+data+'" value="'+full.length+'" /><input type="hidden" id="materialColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="materialColorId_'+data+'" value="'+full.color_id+'" /><input type="hidden" id="materialPrice_'+data+'" value="'+full.price+'" /><input type="hidden" id="materialDatePurchase_'+data+'" value="'+full.date_purchase+'" />';

                        if(full.status == 0){
                            dataReturn = dataReturn + ' <a class="btn btn-primary sendMaterialBtn" id="send_'+data+'" href="#materialModalSend" data-toggle="modal" title="Kirim ke Konveksi"><span class="fa fa-sign-out"></span></a>';
                        } else{
                            dataReturn = dataReturn +'<a class="btn btn-success" href="#" title="Terkirim ke Konveksi"><span class="fa fa-check"></span></a>';
                        }

                        dataReturn = dataReturn + ' </div>';


                        return dataReturn;
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#materialTable").on("click", ".sendMaterialBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#sendMaterialId").val(id);
            $("#sendMaterialType").val($('#materialType_'+id).val());
            $("#sendMaterialTypeHidden").val($('#materialType_'+id).val());

            var length = $('#materialLength_'+id).val();
            $("#sendMaterialLengthHidden").val(length);
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#sendMaterialLength").val(length+' yard');

            $("#sendMaterialColor").val($('#materialColor_'+id).val());
            $("#sendMaterialColorHidden").val($('#materialColorId_'+id).val());

            var price = $('#materialPrice_'+id).val();
            price = 'Rp '+price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

            $("#sendMaterialPrice").val(price);
            $("#sendMaterialDatePurchase").val($('#materialDatePurchase_'+id).val());
        });

        $('#materialDatePurchase, #editMaterialDatePurchase, #filterDateFrom, #filterDateTo').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto"
        });

        $('#materialDatePurchase').keypress(function(event){
            event.preventDefault();
        });

        $('#editMaterialDatePurchase').keypress(function(event){
            event.preventDefault();
        });

        $('#materialLength').keyup(function(){
            var number = $(this).val().split('.').join("");
            $('#materialLengthHidden').val(number);

            number = number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $(this).val(number);
        });

        $('#materialPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#materialPriceHidden').val(number);
        });

        $('#materialPrice').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('material.index')}}" + '?status='+ $(this).val();
        });

        $('#materialTotalPrice').keypress(function(){
            event.preventDefault();
        });

        $('#filterDateFrom').keypress(function(event){
            event.preventDefault();
        });

        $('#filterDateTo').keypress(function(event){
            event.preventDefault();
        });

        $('#filterProcess').click(function(){
            window.location = "{{ route('material.index')}}" + '?status='+$("#searchMaterialBy").val()+'&dateFrom='+$("#filterDateFrom").val()+'&dateTo='+$("#filterDateTo").val();
        });

        $("#materialLength").keypress(function (e) {
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

	});
</script>

@endsection
