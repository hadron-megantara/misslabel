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
              <div class="panel-heading notification text-center">{{session('success')}}</div>
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
                                    </div>

                                    <label for="materialDescription" class="col-md-12 control-label">Penjual</label>

                                    <div class="col-md-12">
                                        <input type="text" id="materialSeller" class="form-control" name="materialSeller" required style="resize: none" rows="4" placeholder="Masukkan Penjual" />
                                    </div>

                                    <label for="materialDescription" class="col-md-12 control-label">Keterangan</label>

                                    <div class="col-md-12">
                                        <textarea id="materialDescription" class="form-control" name="materialDescription" required style="resize: none" rows="4" placeholder="Keterangan"></textarea>
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
                                    <div class="form-group inputAddedArea">
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
                                                <option value="Putih">Putih</option>
                                                <option value="Hitam">Hitam</option>
                                                <option value="Biru">Biru</option>
                                                <option value="Biru Muda">Biru Muda</option>
                                                <option value="Hijau">Hijau</option>
                                                <option value="Hijau Muda">Hijau Muda</option>
                                                <option value="Kuning">Kuning</option>
                                                <option value="Kuning Muda">Kuning Muda</option>
                                                <option value="Merah">Merah</option>
                                                <option value="Merah Muda">Merah Muda</option>
                                                <option value="Ungu">Ungu</option>
                                                <option value="Perak">Perak</option>
                                                <option value="Emas">Emas</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3" style="padding-right: 0">
                                            <input type="text" class="form-control number materialPrice" required placeholder="Masukkan Harga">
                                            <input type="hidden" name="materialPrice[]" class="materialPriceHidden" required>
                                        </div>

                                        <div class="col-md-1 addMoreRegion" style="padding-right: 0">
                                            <button type="button" class="btn btn-success pull-right" id="addMore"><span class="fa fa-plus addBtn" title="Tambah Bahan"></span></button>
                                        </div>
                                    </div>
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
    <div class="form-group inputAddedArea">
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
                <option value="Putih">Putih</option>
                <option value="Hitam">Hitam</option>
                <option value="Biru">Biru</option>
                <option value="Biru Muda">Biru Muda</option>
                <option value="Hijau">Hijau</option>
                <option value="Hijau Muda">Hijau Muda</option>
                <option value="Kuning">Kuning</option>
                <option value="Kuning Muda">Kuning Muda</option>
                <option value="Merah">Merah</option>
                <option value="Merah Muda">Merah Muda</option>
                <option value="Ungu">Ungu</option>
                <option value="Perak">Perak</option>
                <option value="Emas">Emas</option>
            </select>
        </div>

        <div class="col-md-3" style="padding-right: 0">
            <input type="text" class="form-control number materialPrice" required placeholder="Masukkan Harga">
            <input type="hidden" name="materialPrice[]" class="materialPriceHidden" required>
        </div>

        <div class="col-md-1 addMoreRegion" style="padding-right: 0">
            <button type="button" class="btn btn-success pull-right" id="addMore"><span class="fa fa-plus addBtn" title="Tambah Bahan"></span></button>
        </div>

    </div>
</div>

<div id="materialModalEdit" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Pembelian Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.transaction.editTransaction') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editMaterialType" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <select id="editMaterialType" class="form-control" name="materialName" required>
                                @foreach($materialType as $materialType3)
                                    <option value="{{$materialType3->name}}">{{$materialType3->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="editMaterialId" name="materialId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialLength" class="col-md-4 control-label">Panjang</label>

                        <div class="col-md-6">
                            <input id="editMaterialLength" type="text" class="form-control" required placeholder="Dalam Yard">
                            <input id="editMaterialLengthHidden" type="hidden" name="materialLength" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialColor" class="col-md-4 control-label">Lebar</label>

                        <div class="col-md-6">
                            <select id="editMaterialColor" class="form-control" name="materialColor" required>
                                <option value="Putih">Putih</option>
                                <option value="Hitam">Hitam</option>
                                <option value="Biru">Biru</option>
                                <option value="Biru Muda">Biru Muda</option>
                                <option value="Hijau">Hijau</option>
                                <option value="Hijau Muda">Hijau Muda</option>
                                <option value="Kuning">Kuning</option>
                                <option value="Kuning Muda">Kuning Muda</option>
                                <option value="Merah">Merah</option>
                                <option value="Merah Muda">Merah Muda</option>
                                <option value="Ungu">Ungu</option>
                                <option value="Perak">Perak</option>
                                <option value="Emas">Emas</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="editMaterialDescription" class="form-control" name="materialDescription" required style="resize: none"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialPrice" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="editMaterialPrice" type="text" class="form-control number" required>
                            <input id="editMaterialPriceHidden" type="hidden" name="materialPrice" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialDatePurchase" class="col-md-4 control-label">Tanggal Pembelian</label>

                        <div class="col-md-6">
                            <input id="editMaterialDatePurchase" type="text" class="form-control" name="materialDatePurchase" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductDeliveryNote" class="col-md-4 control-label">Nota Pembelian</label>

                        <div class="col-md-6">
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        <span class="fa fa-file"></span><input id="sendProductDeliveryNote" type="file" style="display: none;" name="deliveryNote">
                                    </span>
                                </label>
                                <input type="text" id="sendProductDeliveryNoteHidden" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="editForm"><span class="fa fa-save"></span> Simpan</button>
            </div>
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

        var t = $('#materialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('material.transaction.getTransaction') }}'+"?status={{$status}}&dateFrom={{$dateFrom}}&dateTo={{$dateTo}}",
            columns: [
                { data: 'seller', name: 'seller' },
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
                { data: 'id', name: 'id', render: function(data, type, full) {
                        return '<div class="text-center"><a href="/material/transaction/download-note?id='+data+'" style="text-decoration: underline" target="_blank">download</a></div>';
                    } 
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        var dataReturn = '<div class="text-center"><a class="btn btn-success editMaterialBtn" id="edit_'+data+'" href="#materialModalEdit" data-toggle="modal" title="Lihat Data"><span class="fa fa-search"></span></a></div>';

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

        $("#materialTable").on("click", ".editMaterialBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editMaterialId").val(id);
            $("#editMaterialType option[value='"+$('#materialType_'+id).val()+"']").attr("selected", true);

            var length = $('#materialLength_'+id).val();
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#editMaterialLength").val(length);
            $("#editMaterialLengthHidden").val($('#materialLength_'+id).val());

            $("#editMaterialColor option[value='"+$('#materialColor_'+id).val()+"']").attr("selected", true);
            $("#editMaterialDescription").val($('#materialDescription_'+id).val());

            var price = $('#materialPrice_'+id).val();
            price = 'Rp '+price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

            $("#editMaterialPrice").val(price);
            $("#editMaterialPriceHidden").val($('#materialPrice_'+id).val());
            $("#editMaterialDatePurchase").val($('#materialDatePurchase_'+id).val());
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
            orientation: "auto"
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

        $("#materialInputArea").on("click", "#addMore", function(){
            $(this).closest('.addMoreRegion').html('<button type="button" class="btn btn-danger pull-right deleteBtnAction" title="Hapus Bahan"><span class="fa fa-close deleteBtn"></span></button>');

            $('#materialInputArea').append($('#materialInputAreaHidden').html());

            $('#totalMaterial').val(parseInt($('#totalMaterial').val()) + 1);
        });

        $("#materialInputArea").on("click", ".deleteBtnAction", function(){
            $(this).closest('.inputAddedArea').remove();

            if($('.inputAddedArea').length <= 2){
                $('.border-space').remove();
            }

            $('#totalMaterial').val(parseInt($('#totalMaterial').val()) - 1);
        });

        $('#materialNote').change(function(){
            $('#materialNoteShow').val($(this).val());
        });

	});
</script>

@endsection
