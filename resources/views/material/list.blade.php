@extends('layouts.app')

@section('content')

<?php
    use Carbon\Carbon;
?>

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Pembelian Bahan</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#materialModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>

                <a href="#materialModalAdd" class="btn btn-success btnAddMaterial" data-toggle="modal">
                    <span class="fa fa-plus"></span> Tambah Pembelian
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
        				<th style="padding: 10px 18px">Tipe Bahan</th>
                        <th>Panjang</th>
                        <th>Warna</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Tanggal Pembelian</th>
        				<th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Pembelian Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.addMaterial') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="materialName" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <select id="materialName" class="form-control" name="materialName" required>
                                @foreach($materialType as $materialType2)
                                    <option value="{{$materialType2->name}}">{{$materialType2->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="materialLength" class="col-md-4 control-label">Panjang</label>

                        <div class="col-md-6">
                            <input id="materialLength" type="text" class="form-control" name="materialLengthShow" required placeholder="Dalam Yard">
                            <input id="materialLengthHidden" type="hidden" name="materialLength" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="materialColor" class="col-md-4 control-label">Warna</label>

                        <div class="col-md-6">
                            <select id="materialColor" class="form-control" name="materialColor" required>
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
                        <label for="materialDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="materialDescription" class="form-control" name="materialDescription" required style="resize: none"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="materialPrice" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="materialPrice" type="text" class="form-control number" name="materialPriceShow" required>
                            <input id="materialPriceHidden" type="hidden" name="materialPrice" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="materialDatePurchase" class="col-md-4 control-label">Tanggal Pembelian</label>

                        <div class="col-md-6">
                            <input id="materialDatePurchase" type="text" class="form-control" name="materialDatePurchase" required>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="addForm"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="materialModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Pembelian Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.editMaterial') }}" role="form" id="editForm">
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
                            <input id="editMaterialLength" type="text" class="form-control" name="materialLengthShow" required placeholder="Dalam Yard">
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
                            <input id="editMaterialPrice" type="text" class="form-control number" name="materialPriceShow" required>
                            <input id="editMaterialPriceHidden" type="hidden" name="materialPrice" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialDatePurchase" class="col-md-4 control-label">Tanggal Pembelian</label>

                        <div class="col-md-6">
                            <input id="editMaterialDatePurchase" type="text" class="form-control" name="materialDatePurchase" required>
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

<div id="materialModalSend" class="modal fade" role="dialog">
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
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialLength" class="col-md-4 control-label">Panjang</label>

                        <div class="col-md-6">
                            <input id="sendMaterialLength" type="text" class="form-control" disabled="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialColor" class="col-md-4 control-label">Warna</label>

                        <div class="col-md-6">
                            <input id="sendMaterialColor" type="text" class="form-control" disabled="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="sendMaterialDescription" type="text" class="form-control" disabled="" style="resize: none"></textarea>
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

<div id="materialModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Pembelian Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.deleteMaterial') }}" role="form" id="deleteForm">
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

        var t = $('#materialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('material.getMaterial') }}'+"?status={{$status}}&dateFrom={{$dateFrom}}&dateTo={{$dateTo}}",
            columns: [
                { data: 'material_type', name: 'material_type' },
                { data: 'length', name: 'length', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data+' m';
                    }
                },
                { data: 'color', name: 'color'},
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
                        var dataReturn = '<div class="text-center"><a class="btn btn-success editMaterialBtn" id="edit_'+data+'" href="#materialModalEdit" data-toggle="modal" title="Ubah Data"><span class="fa fa-pencil"></span></a><input type="hidden" id="materialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="materialLength_'+data+'" value="'+full.length+'" /><input type="hidden" id="materialColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="materialDescription_'+data+'" value="'+full.description+'" /><input type="hidden" id="materialPrice_'+data+'" value="'+full.price+'" /><input type="hidden" id="materialDatePurchase_'+data+'" value="'+full.date_purchase+'" />';

                        if(full.status == 0){
                            dataReturn = dataReturn + ' <a class="btn btn-primary sendMaterialBtn" id="send_'+data+'" href="#materialModalSend" data-toggle="modal" title="Kirim ke Konveksi"><span class="fa fa-sign-out"></span></a>';
                        }

                        dataReturn = dataReturn + ' <a class="btn btn-danger deleteMaterialBtn" id="delete_'+data+'" href="#materialModalDelete" data-toggle="modal" title="Hapus Data"><span class="fa fa-trash"></span></a></div>';


                        return dataReturn;
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
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

            var length = $('#materialLength_'+id).val();
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#sendMaterialLength").val(length);

            $("#sendMaterialColor").val($('#materialColor_'+id).val());
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
            window.location = "{{ route('material.index')}}" + '?status='+ $(this).val();
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

	});
</script>

@endsection
