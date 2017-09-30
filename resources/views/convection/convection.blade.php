@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Pembelian Bahan</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#materialModalAdd" class="btn btn-success btnAddMaterial" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Pembelian</a>
            </div>
        </div>

        <div class="table-responsive">
        	<table id="materialTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Tipe Bahan</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
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
                            <input id="materialLength" type="text" class="form-control" name="materialLengthShow" required placeholder="Dalam Meter">
                            <input id="materialLengthHidden" type="hidden" name="materialLength" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="materialWidth" class="col-md-4 control-label">Lebar</label>

                        <div class="col-md-6">
                            <input id="materialWidth" type="number" class="form-control" name="materialWidth" required placeholder="Dalam Centi Meter">
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
                <h4 class="modal-title">Ubah Tipe Bahan</h4>
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
                            <input id="editMaterialLength" type="text" class="form-control" name="materialLengthShow" required placeholder="Dalam Meter">
                            <input id="editMaterialLengthHidden" type="hidden" name="materialLength" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editMaterialWidth" class="col-md-4 control-label">Lebar</label>

                        <div class="col-md-6">
                            <input id="editMaterialWidth" type="number" class="form-control" name="materialWidth" required placeholder="Dalam Centi Meter">
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
            ajax: '{{ route('material.getMaterial') }}',
            columns: [
                { data: 'material_type', name: 'material_type' },
                { data: 'length', name: 'length', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data+' m';
                    }
                },
                { data: 'width', name: 'width', render: function(data, type, full) {
                        return data+' cm';
                    }
                },
                { data: 'description', name: 'description' },
                { data: 'price', name: 'price', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    } 
                },
                { data: 'date_purchase', name: 'date_purchase' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-success editMaterialBtn" id="edit_'+data+'" href="#materialModalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteMaterialBtn" id="delete_'+data+'" href="#materialModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="materialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="materialLength_'+data+'" value="'+full.length+'" /><input type="hidden" id="materialWidth_'+data+'" value="'+full.width+'" /><input type="hidden" id="materialDescription_'+data+'" value="'+full.description+'" /><input type="hidden" id="materialPrice_'+data+'" value="'+full.price+'" /><input type="hidden" id="materialDatePurchase_'+data+'" value="'+full.date_purchase+'" />';
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

            $("#editMaterialWidth").val($('#materialWidth_'+id).val());
            $("#editMaterialDescription").val($('#materialDescription_'+id).val());

            var price = $('#materialPrice_'+id).val();
            price = 'Rp '+price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

            $("#editMaterialPrice").val(price);
            $("#editMaterialPriceHidden").val($('#materialPrice_'+id).val());
            $("#editMaterialDatePurchase").val($('#materialDatePurchase_'+id).val());
        });

        $('#materialDatePurchase').datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $('#editMaterialDatePurchase').datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $('#materialDatePurchase').keypress(function(event){
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

	});
</script>

@endsection
