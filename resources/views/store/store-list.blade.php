@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Toko - List Toko</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right" style="margin-top: 5px">
                <a href="#convectionListModalAdd" class="btn btn-success btnAddConvectionList" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Toko</a>
            </div>
        </div>

        <div class="row"></div>

        @if(session('success'))
            <div class="row"></div>

            <div class="panel panel-success">
                <div class="panel-heading notification text-center">
                    {{session('success')}}
                </div>
            </div>

            <div class="row"></div>
        @endif

        <div class="table-responsive">
        	<table id="convectionListTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Toko</th>
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

<div id="convectionListModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Toko</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('store.addStoreList') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="convectionListName" class="col-md-4 control-label">Nama Toko</label>

                        <div class="col-md-6">
                            <input id="convectionListName" type="text" class="form-control" name="storeListName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convectionListDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="convectionListDescription" class="form-control" name="storeListDescription" required style="resize: none;"></textarea>
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

<div id="convectionListModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Toko</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('store.editStoreList') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editConvectionListName" class="col-md-4 control-label">Nama Toko</label>

                        <div class="col-md-6">
                            <input id="editConvectionListName" type="text" class="form-control" name="storeListName" required>
                            <input type="hidden" id="editConvectionListId" name="storeListId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editConvectionListDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="editConvectionListDescription" class="form-control" name="storeListDescription" required style="resize: none;"></textarea>
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

<div id="convectionListModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Toko</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('store.deleteStoreList') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus Toko "<b id="convectionListDeleteName"></b>" ?</label>
                    <input id="convectionListId" type="hidden" class="form-control" name="storeListId">
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

        var t = $('#convectionListTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('store.getStoreList') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-success editConvectionListBtn" id="edit_'+data+'" href="#convectionListModalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteConvectionListBtn" id="delete_'+data+'" href="#convectionListModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="convectionListName_'+data+'" value="'+full.name+'" /><input type="hidden" id="convectionListDescription_'+data+'" value="'+full.description+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#convectionListTable").on("click", ".deleteConvectionListBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#convectionListId").val(id);
            $("#convectionListDeleteName").html($('#convectionListName_'+id).val());
        });

        $("#convectionListTable").on("click", ".editConvectionListBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editConvectionListId").val(id);
            $("#editConvectionListName").val($('#convectionListName_'+id).val());
            $("#editConvectionListDescription").val($('#convectionListDescription_'+id).val());
        });
	});
</script>

@endsection
