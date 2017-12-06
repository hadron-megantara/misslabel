@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Pengeluaran</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#expenseModalAdd" class="btn btn-success btnAddMaterialType" data-toggle="modal"><span class="fa fa-plus"></span> Tambah Pengeluaran</a>
            </div>
        </div>

        <div class="table-responsive">
        	<table id="expenseTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Keterangan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
        				<th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="expenseModalAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Pengeluaran</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('expense.store') }}" role="form" id="addForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="description" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control" name="description" required style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="value" class="col-md-4 control-label">Jumlah Pengeluaran</label>

                        <div class="col-md-6">
                            <input type="text" id="value" class="form-control" required />
                            <input type="hidden" id="valueHidden" class="form-control" name="value" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date" class="col-md-4 control-label">Tanggal</label>

                        <div class="col-md-6">
                            <input type="text" id="date" class="form-control" name="date" required />
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

<div id="expenseModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Pengeluaran</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('expense.update') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="editDescription" class="form-control" name="description" required style="resize: none;" ></textarea>
                            <input id="editId" type="hidden" class="form-control" name="expenseId">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editValue" class="col-md-4 control-label">Jumlah Pengeluaran</label>

                        <div class="col-md-6">
                            <input type="text" id="editValue" class="form-control" required />
                            <input type="hidden" id="editValueHidden" class="form-control" name="value" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editDate" class="col-md-4 control-label">Tanggal</label>

                        <div class="col-md-6">
                            <input type="text" id="editDate" class="form-control" name="date" required />
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

<div id="expenseModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Pengeluaran</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('expense.destroy') }}" role="form" id="deleteForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin menghapus pengeluaran "<b id="deleteDescription"></b>" ?</label>
                    <input id="deleteId" type="hidden" class="form-control" name="expenseId">
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

        var t = $('#expenseTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('expense.get') }}',
            columns: [
                { data: 'description', name: 'description' },
                { data: 'value', name: 'value', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    } 
                },
                { data: 'date', name: 'date', render: function(data, type, full){
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
                        return '<div class="text-center"><a class="btn btn-success editBtn" id="edit_'+data+'" href="#expenseModalEdit" data-toggle="modal"><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteBtn" id="delete_'+data+'" href="#expenseModalDelete" data-toggle="modal"><span class="fa fa-trash"></span></a></div><input type="hidden" id="description_'+data+'" value="'+full.description+'" /><input type="hidden" id="value_'+data+'" value="'+full.value+'" /><input type="hidden" id="date_'+data+'" value="'+full.date+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#expenseTable").on("click", ".deleteBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $("#deleteId").val(id);
            $("#deleteDescription").html($('#description_'+id).val());
        });

        $("#expenseTable").on("click", ".editBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $("#editId").val(id);
            $("#editDescription").val($('#description_'+id).val());
            $("#editValue").val($('#value_'+id).val());
            $("#editDate").val($('#date_'+id).val());

            $('#editValue').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });
        });

        $('#value').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#editValue').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#value').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#valueHidden').val(number);
        });

        $('#editValue').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#editValueHidden').val(number);
        });

        $('#date, #editDate, #filterDateFrom, #filterDateTo').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });
	});
</script>

@endsection
