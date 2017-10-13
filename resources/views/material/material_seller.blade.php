@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Tipe Bahan</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#materialSellerModalAdd" class="btn btn-success btnAddMaterialSeller" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Penjual Bahan</a>
            </div>
        </div>`

        <div class="table-responsive">
        	<table id="materialSellerTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Penjual</th>
                        <th>Keterang`an</th>
        				<th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialSellerModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Tipe Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.addMaterialSeller') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="customerName" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="materialSellerName" type="text" class="form-control" name="materialSellerName" required>
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

<div id="materialSellerModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Tipe Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.editMaterialSeller') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editMaterialSellerName" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="editMaterialSellerName" type="text" class="form-control" name="materialSellerName" required>
                            <input type="hidden" id="editMaterialSellerId" name="materialSellerId" />
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

<div id="materialSellerModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Tipe Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.deleteMaterialSeller') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus tipe bahan "<b id="materialSellerDeleteName"></b>" ?</label>
                    <input id="materialSellerId" type="hidden" class="form-control" name="materialSellerId">
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

        var t = $('#materialSellerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('material.getMaterialSeller') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-success editMaterialSellerBtn" id="edit_'+data+'" href="#materialSellerModalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteMaterialSellerBtn" id="delete_'+data+'" href="#materialSellerModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="materialSellerName_'+data+'" value="'+full.name+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#materialSellerTable").on("click", ".deleteMaterialSellerBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#materialSellerId").val(id);
            $("#materialSellerDeleteName").html($('#materialSellerName_'+id).val());
        });

        $("#materialSellerTable").on("click", ".editMaterialSellerBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editMaterialSellerId").val(id);
            $("#editMaterialSellerName").val($('#materialSellerName_'+id).val());
        });
	});
</script>

@endsection
