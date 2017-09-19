@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Pelanggan</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#userModalAdd" class="btn btn-success btnAddCustomer" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Pelanggan</a>
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
                <form class="form-horizontal" method="POST" action="{{ route('customer.addCustomer') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="customerName" class="col-md-4 control-label">Nama Pelanggan</label>

                        <div class="col-md-6">
                            <input id="customerName" type="text" class="form-control" name="customerName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerStore" class="col-md-4 control-label">Toko</label>

                        <div class="col-md-6">
                            <input id="customerStore" type="text" class="form-control" name="customerStore" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone" class="col-md-4 control-label">No HP/Telp</label>

                        <div class="col-md-6">
                            <input id="customerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerCity" class="col-md-4 control-label">Daerah</label>

                        <div class="col-md-6">
                            <input id="customerCity" type="text" class="form-control customerCity" name="customerCity" required>
                            <div class="containerAutocomplete"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customerDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="customerDescription" class="form-control" name="customerDescription" required></textarea>
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

<div id="userModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Pelanggan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('customer.editCustomer') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editCustomerName" class="col-md-4 control-label">Nama Pelanggan</label>

                        <div class="col-md-6">
                            <input id="editCustomerName" type="text" class="form-control" name="customerName" required>
                            <input type="text" id="editCustomerId" name="customerId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCustomerStore" class="col-md-4 control-label">Toko</label>

                        <div class="col-md-6">
                            <input id="editCustomerStore" type="text" class="form-control" name="customerStore" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCustomerPhone" class="col-md-4 control-label">No HP/Telp</label>

                        <div class="col-md-6">
                            <input id="editCustomerPhone" type="text" class="form-control" name="customerPhone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCustomerCity" class="col-md-4 control-label">Daerah</label>

                        <div class="col-md-6">
                            <input id="editCustomerCity" type="text" class="form-control customerCity" name="customerCity" required>
                            <div class="containerAutocomplete"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editCustomerDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="editCustomerDescription" class="form-control" name="customerDescription" required></textarea>
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

<div id="userModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Pelanggan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('customer.deleteCustomer') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus pelanggan "<b id="customerDeleteName"></b>" ?</label>
                    <input id="customerId" type="hidden" class="form-control" name="customerId">
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
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            bSort: false,
            ajax: '{{ route('customer.getCustomer') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'store', name: 'store' },
                { data: 'city', name: 'city' },
                { data: 'description', name: 'description' },
                { data: 'id', name: 'id', render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-primary" id="detail_'+data+'" href="#userModalDetail" data-toggle="modal"><span class="fa  fa-search"></span></a> <a class="btn btn-success editCustomerBtn" id="edit_'+data+'" href="#userModalAdd" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteCustomerBtn" id="delete_'+data+'" href="#userModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="customerName_'+data+'" value="'+full.name+'" /><input type="hidden" id="customerStore_'+data+'" value="'+full.store+'" /><input type="hidden" id="customerPhone_'+data+'" value="'+full.phone+'" /><input type="hidden" id="customerCity_'+data+'" value="'+full.city+'" /><input type="hidden" id="customerDescription_'+data+'" value="'+full.description+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        var citiesArray = new Array();

        <?php
            foreach($cities as $cities){
        ?>
                citiesArray.push("{{$cities->name}}");
        <?
            }
        ?>

        $( ".customerCity" ).autocomplete({
            source: citiesArray,
            appendTo: ".containerAutocomplete",
        });

        $("#customerTable").on("click", ".deleteCustomerBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#customerId").val(id);
            $("#customerDeleteName").html($('#customerName_'+id).val());
        });

        $("#customerTable").on("click", ".editCustomerBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editCustomerId").val(id);
            $("#editCustomerName").val($('#customerName_'+id).val());
            $("#editCustomerStore").val($('#customerStore_'+id).val());
            $("#editCustomerPhone").val($('#customerPhone_'+id).val());
            $("#editCustomerCity").val($('#customerCity_'+id).val());
            $("#editCustomerDescription").val($('#customerDescription_'+id).val());
        });
	});
</script>

@endsection
