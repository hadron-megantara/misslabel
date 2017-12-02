@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Produk</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#modalAdd" class="btn btn-success btnAdd" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Produk</a>
            </div>
        </div>

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
        	<table id="productTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Satuan</th>
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
                <h4 class="modal-title">Tambah Produk</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('config.product.store') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Nama Produk</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-4 control-label">Deskripsi Produk</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control" name="description" required style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="price" type="text" class="form-control" required>
                            <input id="priceHidden" type="hidden" name="price">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unit" class="col-md-4 control-label">Unit</label>

                        <div class="col-md-6">
                            <select id="unit" class="form-control" name="unit" required>
                                <option value="">--- Pilih Satuan ---</option>
                                <option value="pcs">pcs</option>
                                <option value="kodi">kodi</option>
                            </select>
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
                <h4 class="modal-title">Ubah Produk</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('config.product.update') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editName" class="col-md-4 control-label">Nama Produk</label>

                        <div class="col-md-6">
                            <input id="editName" type="text" class="form-control" name="name" required>
                            <input id="editId" type="hidden" name="id" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editDescription" class="col-md-4 control-label">Deskripsi Produk</label>

                        <div class="col-md-6">
                            <textarea id="editDescription" class="form-control" name="description" required style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editPrice" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="editPrice" type="text" class="form-control" required>
                            <input id="editPriceHidden" type="hidden" name="price">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editUnit" class="col-md-4 control-label">Unit</label>

                        <div class="col-md-6">
                            <select id="editUnit" class="form-control" name="unit" required>
                                <option value="">--- Pilih Satuan ---</option>
                                <option value="pcs">pcs</option>
                                <option value="kodi">kodi</option>
                            </select>
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
                <h4 class="modal-title">Hapus Produk</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('config.product.destroy') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus Produk "<b id="deleteName"></b>" ?</label>
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
        $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('config.product.get') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'price', name: 'price', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    } 
                },
                { data: 'unit', name: 'unit' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<a class="btn btn-success editBtn" id="edit_'+data+'" href="#modalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteBtn" id="delete_'+data+'" href="#modalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="name_'+data+'" value="'+full.name+'" /><input type="hidden" id="price_'+data+'" value="'+full.price+'" /><input type="hidden" id="unit_'+data+'" value="'+full.unit+'" /><input type="hidden" id="description_'+data+'" value="'+full.description+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#productTable").on("click", ".deleteBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#deleteId").val(id);
            $("#deleteName").html($('#name_'+id).val());
        });

        $("#productTable").on("click", ".editBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editId").val(id);
            $("#editName").val($('#name_'+id).val());
            $("#editDescription").val($('#description_'+id).val());
            $("#editPrice").val($('#price_'+id).val());
            $("#editPriceHidden").val($('#price_'+id).val());
            $("#editUnit").val($('#unit_'+id).val());

            $('#editPrice').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });
        });

        $("#productTable").on("keypress", ".price", function(e){
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $("#productTable").on("keypress", ".editPrice", function(e){
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $('#price').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#editPrice').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#price').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#priceHidden').val(number);
        });

        $('#editPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#editPriceHidden').val(number);
        });
	});
</script>

@endsection
