@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Tipe Bahan</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right">
                <a href="#materialTypeModalAdd" class="btn btn-success btnAddMaterialType" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Tipe Bahan</a>
            </div>
        </div>

        <div class="row"></div>

        <div class="table-responsive">
        	<table id="materialTypeTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Tipe Bahan</th>
        				<th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialTypeModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Tipe Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.addMaterialType') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="customerName" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="materialTypeName" type="text" class="form-control" name="materialTypeName" required>
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

<div id="materialTypeModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Tipe Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.editMaterialType') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editMaterialTypeName" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="editMaterialTypeName" type="text" class="form-control" name="materialTypeName" required>
                            <input type="hidden" id="editMaterialTypeId" name="materialTypeId" />
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

<div id="materialTypeModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Tipe Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.deleteMaterialType') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus tipe bahan "<b id="materialTypeDeleteName"></b>" ?</label>
                    <input id="materialTypeId" type="hidden" class="form-control" name="materialTypeId">
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

        var t = $('#materialTypeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('material.getMaterialType') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-success editMaterialTypeBtn" id="edit_'+data+'" href="#materialTypeModalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteMaterialTypeBtn" id="delete_'+data+'" href="#materialTypeModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="materialTypeName_'+data+'" value="'+full.name+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#materialTypeTable").on("click", ".deleteMaterialTypeBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#materialTypeId").val(id);
            $("#materialTypeDeleteName").html($('#materialTypeName_'+id).val());
        });

        $("#materialTypeTable").on("click", ".editMaterialTypeBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editMaterialTypeId").val(id);
            $("#editMaterialTypeName").val($('#materialTypeName_'+id).val());
        });
	});
</script>

@endsection
