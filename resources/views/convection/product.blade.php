@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Konveksi - Produk</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#convectionModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <span style="font-weight: bold; margin-right: 10px">Filter Berdasar Konveksi</span>

            <select id="searchMaterialBy" name="searchMaterialBy">
                @foreach($convectionList as $convectionList)
                    <option value="{{$convectionList->id}}" @if($convection == $convectionList->id) selected="" @endif>{{$convectionList->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="row"></div>

        <div class="table-responsive">
        	<table id="materialInTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Tipe Bahan</th>
                        <th>Warna Bahan</th>
                        <th>Panjang Bahan</th>
        				<th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialInModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Pembelian Bahan</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.editMaterial') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="editMaterialType" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <select id="editMaterialType" class="form-control" name="materialName" required>
                                
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
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="editForm"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="materialModalSend" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kirim Bahan ke Konveksi</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.sendMaterial') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="sendMaterialType" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="sendMaterialType" type="text" class="form-control" disabled="">
                            <input type="hidden" id="sendMaterialId" name="materialId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendMaterialLength" class="col-md-4 control-label">Panjang</label>

                        <div class="col-md-6">
                            <input id="sendMaterialLength" type="text" class="form-control" disabled="">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="editForm"><span class="fa fa-save"></span> Kirim</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var indexCounter = 1;

        var t = $('#materialInTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('convection.getMaterialIn') }}'+'?convection={{$convection}}',
            columns: [
                { data: 'material_type', name: 'material_type' },
                { data: 'color', name: 'color' },
                { data: 'length', name: 'length', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data+' m';
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"> <a class="btn btn-primary deleteMaterialBtn" id="delete_'+data+'" href="#materialModalSend" data-toggle="modal" title="Kirim ke Konveksi"><span class="fa fa-sign-out"></span></a></div><input type="hidden" id="materialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="materialColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="materialLength_'+data+'" value="'+full.length+'" />';
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

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('convection.index')}}" + '?convection='+ $(this).val();
        });

	});
</script>

@endsection
