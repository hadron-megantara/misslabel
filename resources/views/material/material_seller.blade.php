@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Penjual Bahan</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right">
                <a href="#materialSellerModalAdd" class="btn btn-success btnAddMaterialSeller" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Penjual Bahan</a>
            </div>
        </div>

        <div class="row"></div>

        <div class="table-responsive">
        	<table id="materialSellerTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Penjual</th>
                        <th>Keterangan</th>
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
                <h4 class="modal-title">Tambah Penjual Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.seller.addSeller') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="sellerNameAdd" class="col-md-4 control-label">Penjual</label>

                        <div class="col-md-6">
                            <input id="sellerNameAdd" type="text" class="form-control" name="sellerName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sellerDescriptionAdd" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="sellerDescriptionAdd" class="form-control" name="sellerDescription" required style="resize: none;" rows="4"></textarea>
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
                <h4 class="modal-title">Ubah Penjual Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.seller.editSeller') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editSellerName" class="col-md-4 control-label">Penjual</label>

                        <div class="col-md-6">
                            <input id="editSellerName" type="text" class="form-control" name="sellerName" required>
                            <input type="hidden" id="editSellerId" name="sellerId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editSellerDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="editSellerDescription" class="form-control" name="sellerDescription" required style="resize: none;" rows="4"></textarea>
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
                <h4 class="modal-title">Hapus Penjual Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.seller.deleteSeller') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label class="text-center">Anda yakin ingin menghapus penjual "<b id="sellerDeleteName"></b>" ?</label>
                    <input id="sellerIdDelete" type="hidden" class="form-control" name="sellerId">
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
            ajax: '{{ route('material.seller.getSeller') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-success editMaterialSellerBtn" id="edit_'+data+'" href="#materialSellerModalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteMaterialSellerBtn" id="delete_'+data+'" href="#materialSellerModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="sellerName_'+data+'" value="'+full.name+'" /><input type="hidden" id="sellerDescription_'+data+'" value="'+full.description+'" />';
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

            $("#sellerIdDelete").val(id);
            $("#sellerDeleteName").html($('#sellerName_'+id).val());
        });

        $("#materialSellerTable").on("click", ".editMaterialSellerBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editSellerId").val(id);
            $("#editSellerName").val($('#sellerName_'+id).val());
            $("#editSellerDescription").val($('#sellerDescription_'+id).val());
        });
	});
</script>

@endsection
