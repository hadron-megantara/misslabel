@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Konveksi - Bahan Masuk</h3>

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

            <select id="searchMaterialUsed" name="searchMaterialUsed">
                <option value="0" @if($converted == 0) selected="" @endif>Stok</option>
                <option value="1" @if($converted == 1) selected="" @endif>Terpakai</option>
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

<div id="materialModalConvert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Konversi ke Produk</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('convection.materialIn.convertToProduct') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="convertMaterialType" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="convertMaterialType" type="text" class="form-control" disabled="">
                            <input type="hidden" id="convertMaterialId" name="materialId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convertMaterialColor" class="col-md-4 control-label">Warna Bahan</label>

                        <div class="col-md-6">
                            <input id="convertMaterialColor" type="text" class="form-control" disabled="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convertMaterialLength" class="col-md-4 control-label">Panjang (stok)</label>

                        <div class="col-md-6">
                            <input id="convertMaterialLength" type="text" class="form-control" disabled="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convertMaterialLengthUsed" class="col-md-4 control-label">Panjang (digunakan)</label>

                        <div class="col-md-6">
                            <input id="convertMaterialLengthUsed" type="text" class="form-control" placeholder="Dalam yard" />
                            <input id="convertMaterialLengthUsedHidden" name="materialLength" type="hidden" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convertMaterialPrice" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="convertMaterialPrice" type="text" class="form-control number" name="materialPriceShow" required>
                            <input id="convertMaterialPriceHidden" type="hidden" name="materialPrice">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convertMaterialProductName" class="col-md-4 control-label">Nama Produk</label>

                        <div class="col-md-6">
                            <input id="convertMaterialProductName" type="text" class="form-control" name="materialProductName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="convertMaterialProductDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="convertMaterialProductDescription" class="form-control" name="materialProductDescription" required style="resize: none;"></textarea>
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
            ajax: '{{ route('convection.getMaterialIn') }}'+'?convection={{$convection}}'+'&converted='+{{$converted}},
            columns: [
                { data: 'material_type', name: 'material_type' },
                { data: 'color', name: 'color' },
                { data: 'length', name: 'length', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data+' m';
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"> <a class="btn btn-primary convertConvectionBtn" id="convert_'+data+'" href="#materialModalConvert" data-toggle="modal" title="Konversi ke Produk"><span class="fa fa-sign-out"></span></a></div><input type="hidden" id="materialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="materialColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="materialLength_'+data+'" value="'+full.length+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#materialInTable").on("click", ".convertConvectionBtn", function(){
            var id = this.id;
            id = id.substring(8);

            $("#convertMaterialId").val(id);
            $("#convertMaterialType").val($('#materialType_'+id).val());
            $("#convertMaterialColor").val($('#materialColor_'+id).val());

            var length = $('#materialLength_'+id).val();
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#convertMaterialLength").val(length);
        });

        $('#convertMaterialLengthUsed').keyup(function(){
            var number = $(this).val().split('.').join("");
            $('#convertMaterialLengthUsedHidden').val(number);

            number = number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $(this).val(number);
        });

        $('#convertMaterialPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#convertMaterialPriceHidden').val(number);
        });

        $('#convertMaterialPrice').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('convection.index')}}" + '?convection='+ $(this).val()+'&converted='+$("#searchMaterialUsed").val();
        });

        $("#searchMaterialUsed").change(function() {
            window.location = "{{ route('convection.index')}}" + '?convection='+ $('#searchMaterialBy').val()+'&converted='+$(this).val();
        });

	});
</script>

@endsection
