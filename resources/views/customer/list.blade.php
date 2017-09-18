@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Pelanggan</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#userModalAdd" class="btn btn-success" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Pelanggan</a>
            </div>
        </div>

        <div class="table-responsive">
        	<table id="customerTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Pelanggan</th>
        				<th>No HP/Telp</th>
                        <th>Toko</th>
        				<th>Daerah</th>
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

<div id="userModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Pelanggan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('customer.addCustomer') }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="customerName" class="col-md-4 control-label">Nama Pelanggan</label>

                        <div class="col-md-6">
                            <input id="customerName" type="text" class="form-control" name="customerName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone" class="col-md-4 control-label">No HP/Telp</label>

                        <div class="col-md-6">
                            <input id="customerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone" class="col-md-4 control-label">Toko</label>

                        <div class="col-md-6">
                            <input id="customerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone" class="col-md-4 control-label">No HP/Telp</label>

                        <div class="col-md-6">
                            <input id="customerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone" class="col-md-4 control-label">No HP/Telp</label>

                        <div class="col-md-6">
                            <input id="customerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone" class="col-md-4 control-label">No HP/Telp</label>

                        <div class="col-md-6">
                            <input id="customerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('customer.getCustomer') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'store', name: 'store' },
                { data: 'city', name: 'city' },
                { data: 'description', name: 'description' },
                { data: 'id', name: 'id', render: function(data, type, full) {
                        return '<a class="btn btn-info" id="edit_'+data+'" href="#userModalEdit"><span class="fa fa-pencil"></span> Ubah</a> <a class="btn btn-info" id="edit_'+data+'" href="#userModalDelete"><span class="fa fa-trash"></span> Hapus</a>';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses..."
            },
        });
	});
</script>

@endsection
