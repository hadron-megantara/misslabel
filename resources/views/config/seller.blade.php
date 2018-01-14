@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Penjual</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right">
                <a href="#modalAdd" class="btn btn-success btnAdd" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Penjual</a>
            </div>
        </div>

        <div class="row"></div>

        @if(session('success'))
            <div class="panel panel-success">
                <div class="panel-heading notification text-center">
                    {{session('success')}}
                </div>
            </div>
        @elseif(session('error'))
            <div class="panel panel-danger">
                <div class="panel-heading notification text-center">
                    {{session('error')}}
                </div>
            </div>
        @endif

        <div class="table-responsive">
        	<table id="sellerTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Penjual</th>
                        <th>Telepon</th>
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

<div id="modalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Penjual</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('config.seller.store') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="seller" class="col-md-4 control-label">Penjual</label>

                        <div class="col-md-6">
                            <input id="sellerName" type="text" class="form-control" name="name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sellerPhone" class="col-md-4 control-label">Telepon</label>

                        <div class="col-md-6">
                            <input id="sellerPhone" type="text" class="form-control" name="phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sellerDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="description" id="sellerDescription" style="resize: none;"></textarea>
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

<div id="modalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Penjual</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('config.seller.update') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editName" class="col-md-4 control-label">Penjual</label>

                        <div class="col-md-6">
                            <input id="editName" type="text" class="form-control" name="name" required>
                            <input id="editId" type="hidden" class="form-control" name="id" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editPhone" class="col-md-4 control-label">Telepon</label>

                        <div class="col-md-6">
                            <input id="editPhone" type="text" class="form-control" name="phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="description" id="editDescription" style="resize: none;"></textarea>
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

<div id="modalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Penjual</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('config.seller.destroy') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus penjual "<b id="deleteName"></b>" ?</label>
                    <input id="deleteId" type="hidden" class="form-control" name="id">
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
        $('#sellerTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('config.seller.get') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'description', name: 'description' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<a class="btn btn-success editBtn" id="edit_'+data+'" href="#modalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteBtn" id="delete_'+data+'" href="#modalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="sellerName_'+data+'" value="'+full.name+'" /><input type="hidden" id="sellerPhone_'+data+'" value="'+full.phone+'" /><input type="hidden" id="sellerDescription_'+data+'" value="'+full.description+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#sellerTable").on("click", ".deleteBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#deleteId").val(id);
            $("#deleteName").html($('#sellerName_'+id).val());
        });

        $("#sellerTable").on("click", ".editBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editId").val(id);
            $("#editName").val($('#sellerName_'+id).val());
            $("#editPhone").val($('#sellerPhone_'+id).val());
            $("#editDescription").val($('#sellerDescription_'+id).val());
        });
	});
</script>

@endsection
