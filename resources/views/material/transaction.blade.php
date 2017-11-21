@extends('layouts.app')

@section('content')

<?php
    use Carbon\Carbon;
?>

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Nota Pembelian Bahan</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#materialModalPrint" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-print"> </span>Print
                </a>

                <a href="#materialModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>

                <a href="#materialModalAdd" class="btn btn-success btnAddMaterial" data-toggle="modal">
                    <span class="fa fa-plus"></span> Tambah Nota
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
        				<th class="text-center">Penjual</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Total Harga</th>
                        <th class="text-center">Tanggal Pembelian</th>
                        <th class="text-center">Nota</th>
        				<th class="actions-column text-center">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialModalAdd" class="modal fade" role="dialog" style="margin-bottom: 20px">
    <div class="modal-dialog full-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Nota</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.transaction.addTransaction') }}" role="form" id="addForm" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3" style="border-right: solid 2px #BDBDBD">
                                <div style="margin-bottom: 10px">
                                    <label for="materialDatePurchase" class="col-md-12 control-label">Tanggal Pembelian</label>

                                    <div class="col-md-12">
                                        <input id="materialDatePurchase" type="text" class="form-control" name="materialDatePurchase" required placeholder="Tanggal Pembelian">
                                        <input id="materialId" type="hidden" class="form-control" name="materialId">
                                    </div>

                                    <label for="materialDescription" class="col-md-12 control-label">Penjual</label>

                                    <div class="col-md-12">
                                        <select id="materialSeller" class="form-control" name="materialSeller" required="">
                                            <option value="">--- Pilih Penjual ---</option>
                                            @foreach($seller as $seller)
                                                <option value="{{$seller->id}}">{{$seller->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label for="materialDescription" class="col-md-12 control-label">Keterangan</label>

                                    <div class="col-md-12">
                                        <textarea id="materialDescription" class="form-control" name="materialDescription" style="resize: none" rows="4" placeholder="Keterangan"></textarea>
                                    </div>

                                    <label for="materialNote" class="col-md-12 control-label">Nota Pembelian</label>
                                    <div class="row"></div>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    <span class="fa fa-file"></span><input id="materialNote" type="file" style="display: none;" name="materialNote">
                                                </span>
                                            </label>
                                            <input type="text" id="materialNoteShow" class="form-control" readonly placeholder="Lampirkan nota">
                                        </div>
                                    </div>

                                    <label for="materialPrice" class="col-md-12 control-label">Total Harga</label>

                                    <div class="col-md-12">
                                        <input id="materialTotalPrice" type="text" class="form-control number" placeholder="Rp 0">
                                        <input id="materialTotalPriceHidden" type="hidden" name="materialTotalPrice" required>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="totalMaterial" id="totalMaterial" value="1" />

                            <div class="col-md-9">
                                <div id="materialInputArea" class="inputArea">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-success" form="addForm"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="materialInputAreaHidden" class="inputArea" style="display: none">
    <div class="form-group inputAddedArea newAdded">
        <div class="col-md-12 border-space" style="margin-top:-20px">
            <hr>
        </div>

        <div class="col-md-3">
            <select class="form-control materialName" name="materialName[]" required>
                <option value="">Pilih Bahan</option>
                @foreach($materialType as $materialType2)
                    <option value="{{$materialType2->name}}">{{$materialType2->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2" style="padding-right: 5px">
            <input type="text" class="form-control materialLength" required placeholder="Panjang bahan">
            <input type="hidden" class="materialLengthHidden" name="materialLength[]" required>
        </div>

        <div class="col-md-1" style="padding-left: 0">
            <select name="materialLengthUnit[]" class="form-control materialLengthUnit">
                <option value="yard">yard</option>
                <option value="meter">meter</option>
            </select>
        </div>

        <div class="col-md-2" style="padding-right: 0">
            <select class="form-control materialColor" name="materialColor[]" required>
                <option value="">Pilih Warna</option>

                @foreach($color as $colorAdded)
                    <option value="{{$colorAdded->name}}">{{$colorAdded->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3" style="padding-right: 0">
            <input type="text" class="form-control number materialPrice" required placeholder="Masukkan Harga">
            <input type="hidden" name="materialPrice[]" class="materialPriceHidden" required>
        </div>

        <div class="col-md-1 addMoreRegion" style="padding-right: 0">
            <button type="button" class="btn btn-danger pull-right deleteBtnAction" title="Hapus Bahan"><span class="fa fa-close deleteBtn"></span></button>
        </div>

    </div>
</div>

<div id="materialModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Pembelian Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.transaction.deleteTransaction') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus pembelian bahan "<b id="materialDeleteType"></b>" di tanggal "<b id="materialDeleteDatePurchase"></b>" dengan harga "<b id="materialDeletePrice"></b>" ?</label>
                    <input id="materialId" type="hidden" class="form-control" name="materialId">
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="deleteForm"><span class="fa fa-trash"></span> Hapus</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var indexCounter = 1;
        var totalPrice = 0;
        var spinner = "";

        var opts = {
              lines: 13, // The number of lines to draw
              length: 28, // The length of each line
              width: 14, // The line thickness
              radius: 42, // The radius of the inner circle
              scale: 1, // Scales overall size of the spinner
              corners: 1, // Corner roundness (0..1)
              color: '#000', // #rgb or #rrggbb or array of colors
              opacity: 0.25, // Opacity of the lines
              rotate: 0, // The rotation offset
              direction: 1, // 1: clockwise, -1: counterclockwise
              speed: 1, // Rounds per second
              trail: 60, // Afterglow percentage
              fps: 20, // Frames per second when using setTimeout() as a fallback in IE 9
              zIndex: 2e9, // The z-index (defaults to 2000000000)
              className: 'spinner', // The CSS class to assign to the spinner
              top: '50%', // Top position relative to parent
              left: '50%', // Left position relative to parent
              shadow: false, // Whether to render a shadow
              position: 'absolute' // Element positioning
            };

        var t = $('#materialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('material.transaction.getTransaction') }}'+"?dateFrom={{$dateFrom}}&dateTo={{$dateTo}}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
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
                        return '<div class="text-center"><a href="/material/transaction/download-note?id='+data+'" style="text-decoration: underline" target="_blank">download</a></div>';
                    } 
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        var dataReturn = '<div class="text-center"><a class="btn btn-success editMaterialBtn" id="edit_'+data+'" href="" data-toggle="modal" title="Ubah Data"><span class="fa fa-pencil"></span></a></div><input type="hidden" id="hidden_datePurchase_'+data+'" value="'+full.date_purchase+'"><input type="hidden" id="hidden_seller_'+data+'" value="'+full.name+'"><input type="hidden" id="hidden_sellerId_'+data+'" value="'+full.seller_id+'"><input type="hidden" id="hidden_description_'+data+'" value="'+full.description+'"><input type="hidden" id="hidden_price_'+data+'" value="'+full.price+'"><input type="hidden" id="hidden_datePurchase_'+data+'" value="'+full.date_purchase+'">';

                        return dataReturn;
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#materialModalAdd").click(function(){
            totalMaterial = 1;
            totalPrice = 0;
        });

        $("#materialTable").on("click", ".deleteMaterialBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#materialId").val(id);
            $("#materialDeleteType").html($('#materialType_'+id).val());
            $("#materialDeleteDatePurchase").html($('#materialDatePurchase_'+id).val());

            var price = $('#materialPrice_'+id).val();
            price = price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#materialDeletePrice").html('Rp '+price);
        });

        $("body").on("click", ".btnAddMaterial", function(e){
            $('#addForm').attr('action', "{{ route('material.transaction.addTransaction') }}");
            $('#materialId').val("");

            $('.newAdded').remove();

            $('#materialInputArea').append("<div class='form-group inputAddedArea newAdded'><div class='col-md-3'><select class='form-control materialName' name='materialName[]' required><option value=''>Pilih Bahan</option>@foreach($materialType as $materialType2)<option value='{{$materialType2->name}}'>{{$materialType2->name}}</option>@endforeach</select></div><div class='col-md-2' style='padding-right: 5px'><input type='text' class='form-control materialLength' required placeholder='Panjang bahan'><input type='hidden' class='materialLengthHidden' name='materialLength[]' required></div><div class='col-md-1' style='padding-left: 0'><select name='materialLengthUnit[]' class='form-control materialLengthUnit'><option value='yard'>yard</option><option value='meter'>meter</option></select></div><div class='col-md-2' style='padding-right: 0'><select class='form-control materialColor' name='materialColor[]' required><option value=''>Pilih Warna</option>@foreach($color as $color2)<option value='{{$color2->name}}'>{{$color2->name}}</option>@endforeach</select></div><div class='col-md-3' style='padding-right: 0'><input type='text' class='form-control number materialPrice' required placeholder='Masukkan Harga'><input type='hidden' name='materialPrice[]' class='materialPriceHidden' required></div><div class='col-md-1 addMoreRegion' style='padding-right: 0'><button type='button' class='btn btn-danger pull-right deleteBtnAction'><span class='fa fa-close deleteBtn'></span></button></div></div><div class='col-md-12 pull-right'><div class='addMoreRegion' style='padding-right: 0;margin-top:10px;margin-right: -30px;'><button type='button' class='btn btn-success pull-right addMore addBtn'><span class='fa fa-plus addBtn' title='Tambah Bahan'></span> Tambah Bahan</button></div></div>");
        });

        $("#materialTable").on("click", ".editMaterialBtn", function(e){
            var target = document.getElementById('body');
            spinner = new Spinner(opts).spin(target);

            $.blockUI({ message: null, overlayCSS: { backgroundColor: '#ddd' } });

            var id = this.id;
            id = id.substring(5);

            $.ajax({
                url: '{{ route('material.getMaterialByTransactionId') }}'+"?id="+id,
                method: "GET",
                dataType: "json",
                data: "",
            }).done(function(data) {
                spinner.stop();

                $('#materialId').val(id);
                $('#materialDatePurchase').val($('#hidden_datePurchase_'+id).val());
                $('#materialSeller').val($('#hidden_sellerId_'+id).val());
                $('#materialDescription').val($('#hidden_description_'+id).val());
                
                $("#materialTotalPriceHidden").val($('#hidden_price_'+id).val());
                $("#materialTotalPrice").val($('#hidden_price_'+id).val());

                $('#materialTotalPrice').priceFormat({
                    prefix: 'Rp ',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });

                $('.newAdded').remove();

                var counted = 0;
                var addedContent = "";
                $.each(data, function( index, value ) {
                    addedContent = "<div class='form-group inputAddedArea newAdded'>";

                    var tempLength = value.length;
                    tempLength = tempLength.toString();
                    tempLength = tempLength.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

                    var tempMaterialPrice = value.price;
                    var tempMaterialPriceFormated = tempMaterialPrice;
                    tempMaterialPriceFormated = tempMaterialPriceFormated.toString();
                    tempMaterialPriceFormated = 'Rp '+tempMaterialPriceFormated.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

                    if(counted > 0){
                        $("#materialModalAdd").closest('.addMoreRegion').html('<button type="button" class="btn btn-danger pull-right deleteBtnAction" title="Hapus Bahan"><span class="fa fa-close deleteBtn"></span></button>');

                        addedContent = addedContent+"<div class='col-md-12 border-space' style='margin-top:-20px'><hr></div>";
                        
                    }

                    addedContent = addedContent+"<div class='col-md-3'><select class='form-control materialName' name='materialName[]' required><option value=''>Pilih Bahan</option>@foreach($materialType as $materialType2)<option value='{{$materialType2->name}}' "+(value.material_type == '{{$materialType2->name}}' ? "selected=''" : "")  +" >{{$materialType2->name}}</option>@endforeach</select></div><div class='col-md-2' style='padding-right: 5px'><input type='text' class='form-control materialLength' required placeholder='Panjang bahan' value='"+tempLength+"'><input type='hidden' class='materialLengthHidden' name='materialLength[]' required></div><div class='col-md-1' style='padding-left: 0'><select name='materialLengthUnit[]' class='form-control materialLengthUnit'><option value='yard'>yard</option><option value='meter'>meter</option></select></div><div class='col-md-2' style='padding-right: 0'><select class='form-control materialColor' name='materialColor[]' required><option value=''>Pilih Warna</option>@foreach($color as $color3)<option value='{{$color3->name}}' "+(value.color == '{{$color3->name}}' ? "selected=''" : "")  +">{{$color3->name}}</option>@endforeach</select></div><div class='col-md-3' style='padding-right: 0'><input type='text' class='form-control number materialPrice' required placeholder='Masukkan Harga' value='"+tempMaterialPriceFormated+"'><input type='hidden' name='materialPrice[]' class='materialPriceHidden' value='"+tempMaterialPrice+"' required></div><div class='col-md-1 addMoreRegion' style='padding-right: 0'><button type='button' class='btn btn-success pull-right' id='addMore'><span class='fa fa-plus addBtn' title='Tambah Bahan'></span></button></div></div>";

                    $('#materialInputArea').append(addedContent);

                    counted++;
                });

                $('#addForm').attr('action', "{{ route('material.transaction.editTransaction') }}");

                $('#materialModalAdd').modal('show');

                $.unblockUI();
            }).fail(function( jqXHR, textStatus ) {
                spinner.stop();
                $.unblockUI();
            });
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
            $("#sendMaterialColorHidden").val($('#materialColor_'+id).val());
            $("#sendMaterialDescription").val($('#materialDescription_'+id).val());

            var price = $('#materialPrice_'+id).val();
            price = 'Rp '+price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

            $("#sendMaterialPrice").val(price);
            $("#sendMaterialDatePurchase").val($('#materialDatePurchase_'+id).val());
        });

        $('#materialDatePurchase, #editMaterialDatePurchase, #filterDateFrom, #filterDateTo').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });

        $('#materialDatePurchase').keypress(function(event){
            event.preventDefault();
        });

        $('#editMaterialDatePurchase').keypress(function(event){
            event.preventDefault();
        });

        $("#materialInputArea").on("keyup", ".materialLength", function(){
            var number = $(this).val().split('.').join("");
            $(this).closest('.inputAddedArea').find('.materialLengthHidden').val(number);

            number = number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $(this).val(number);
        });

        $("#materialInputArea").on("keyup", ".materialPrice", function(){
            $('.materialPrice').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });

            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $(this).closest('.inputAddedArea').find('.materialPriceHidden').val(number);

            totalPrice = 0;
            $(this).closest('#materialInputArea').find('.materialPriceHidden').each(function(){
                var number2 = $(this).val().split('.').join("");
                number2 = number2.replace(/Rp /gi,'');

                if(number2 == ""){
                    number2 = 0;
                }

                totalPrice = parseInt(totalPrice) + parseInt(number2);
            });
            
            $("#materialTotalPriceHidden").val(totalPrice);
            $("#materialTotalPrice").val(totalPrice);

            $('#materialTotalPrice').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });

        });

        $('#editMaterialLength').keyup(function(){
            var number = $(this).val().split('.').join("");
            $('#editMaterialLengthHidden').val(number);

            number = number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $(this).val(number);
        });

        $('#editMaterialPrice').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#editMaterialPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#editMaterialPriceHidden').val(number);
        });

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('material.transaction')}}" + '?status='+ $(this).val();
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
            window.location = "{{ route('material.transaction')}}" + '?status='+$("#searchMaterialBy").val()+'&dateFrom='+$("#filterDateFrom").val()+'&dateTo='+$("#filterDateTo").val();
        });

        $("#materialLength").keypress(function (e) {
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $('#saveCurrentData').click(function(){
            $('#hiddenMaterialData').prepend('<div class="col-md-12"><div class="alert alert-info materialAdded"><label style="font-weight:bold;color:#1791d6">'+$('#materialName').val()+' - '+$('#materialColor').val()+' - '+$('#materialLength').val()+' '+$('#materialLengthUnit').val()+' - '+$('#materialPrice').val()+'<a href="#" class="pull-right" data-dismiss="alert" title="hapus"><span class="fa fa-close"></span></a></label></div></div><div class="row"></div>');
            $('#materialInputArea').hide();
            $('#addMoreArea').height($('#hiddenMaterialData').height());
            $('#addMoreArea').show();
        });

        $("#materialInputArea").on("click", ".addMore", function(){
            $('#materialInputArea').append("<div class='form-group inputAddedArea newAdded'><div class='col-md-3'><select class='form-control materialName' name='materialName[]' required><option value=''>Pilih Bahan</option>@foreach($materialType as $materialType2)<option value='{{$materialType2->name}}'>{{$materialType2->name}}</option>@endforeach</select></div><div class='col-md-2' style='padding-right: 5px'><input type='text' class='form-control materialLength' required placeholder='Panjang bahan'><input type='hidden' class='materialLengthHidden' name='materialLength[]' required></div><div class='col-md-1' style='padding-left: 0'><select name='materialLengthUnit[]' class='form-control materialLengthUnit'><option value='yard'>yard</option><option value='meter'>meter</option></select></div><div class='col-md-2' style='padding-right: 0'><select class='form-control materialColor' name='materialColor[]' required><option value=''>Pilih Warna</option>@foreach($color as $color2)<option value='{{$color2->name}}'>{{$color2->name}}</option>@endforeach</select></div><div class='col-md-3' style='padding-right: 0'><input type='text' class='form-control number materialPrice' required placeholder='Masukkan Harga'><input type='hidden' name='materialPrice[]' class='materialPriceHidden' required></div><div class='col-md-1 addMoreRegion' style='padding-right: 0'><button type='button' class='btn btn-danger pull-right deleteBtnAction'><span class='fa fa-close deleteBtn'></span></button></div></div><div class='col-md-12 pull-right'></div>");
        });

        $("#materialInputArea").on("click", ".deleteBtnAction", function(){
            $(this).closest('.inputAddedArea').remove();

            if($('.inputAddedArea').length <= 2){
                $('.border-space').remove();
            }
        });

        $('#materialNote').change(function(){
            $('#materialNoteShow').val($(this).val());
        });

	});
</script>

@endsection
