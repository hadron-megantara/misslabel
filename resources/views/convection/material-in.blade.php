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
                <option value="" @if($convection == 0) selected="" @endif >Semua Konveksi</option>
            </select>

            <select id="searchMaterialUsed" name="searchMaterialUsed">
                <option value="0" @if($status == 0) selected="" @endif>Stok</option>
                <option value="1" @if($status == 1) selected="" @endif>Terpakai</option>
            </select>
        </div>

        <div class="row"></div>

        @if(session('success'))
            <div class="panel panel-success">
                <div class="panel-heading notification text-center">
                    {{session('success')}}
                </div>
            </div>

            <div class="row"></div>
        @endif

        <div class="table-responsive">
        	<table id="materialInTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Tipe Bahan</th>
                        <th>Warna Bahan</th>
                        <th>Panjang Bahan</th>
                        @if($status != 1)
        				    <th class="actions-column">Aksi</th>
                        @endif
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialModalConvert" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Konversi ke Produk</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('convection.materialIn.convertToProduct') }}" role="form" id="editForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="convertMaterialType" class="col-md-4 control-label">Tipe Bahan</label>
                            <div class="col-md-8">
                                <input id="convertMaterialType" type="text" class="form-control" disabled="">
                                <input type="hidden" id="convertMaterialId" name="materialId" />
                                <input type="hidden" id="convertMaterialConvectionIdHidden" name="materialConvectionId" />
                                <input id="convertMaterialTypeHidden" type="hidden" name="materialType">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="convertMaterialColor" class="col-md-4 control-label">Warna Bahan</label>
                            <div class="col-md-8">
                                <input id="convertMaterialColor" type="text" class="form-control" disabled="">
                                <input id="convertMaterialColorHidden" type="hidden" name="materialColor" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="convertMaterialLength" class="col-md-4 control-label">Panjang (stok)</label>
                            <div class="col-md-8">
                                <input id="convertMaterialLength" type="text" class="form-control" disabled="">
                                <input id="convertMaterialLengthHidden" type="hidden" name="materialLength" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="convertMaterialPrice" class="col-md-4 control-label">Harga</label>
                            <div class="col-md-8">
                                <input id="convertMaterialPrice" type="text" class="form-control number" name="materialPriceShow" required placeholder="Masukkan Harga">
                                <input id="convertMaterialPriceHidden" type="hidden" name="materialPrice">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="convertMaterialLengthUsed" class="col-md-4 control-label">Panjang (digunakan)</label>
                            <div class="col-md-8">
                                <input id="convertMaterialLengthUsed" type="text" class="form-control" placeholder="Dalam yard" />
                                <input id="convertMaterialLengthUsedHidden" name="materialLength" type="hidden" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="convertMaterialTotal" class="col-md-4 control-label">Total Produk</label>
                            <div class="col-md-4">
                                <input id="convertMaterialTotal" type="text" class="form-control number" name="materialTotalShow" required placeholder="Total">
                                <input id="convertMaterialTotalHidden" type="hidden" name="materialTotal">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="materialUnit">
                                    <option value="pcs">Satuan/Pcs</option>
                                    <option value="kodi">Kodi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="convertMaterialProductName" class="col-md-4 control-label">Nama Produk</label>
                            <div class="col-md-8">
                                <select id="convertMaterialProductName" type="text" class="form-control" name="materialProductName" required>
                                    <option value="">--- Pilih Nama/Model Produk ---</option>
                                    @foreach($productDetailList as $productDetailList2)
                                        <option value="{{$productDetailList2->id}}">{{$productDetailList2->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="convertMaterialProductName" class="col-md-4 control-label">Keterangan</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="description" id="convertMaterialProductDescription" required="" style="resize: none;" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="convertMaterialDate" class="col-md-4 control-label">Tanggal</label>

                            <div class="col-md-8">
                                <input id="convertMaterialDate" type="text" class="form-control number" name="materialDate" placeholder="Masukkan Tanggal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="convertMaterialNote" class="col-md-4 control-label">Nota</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            <span class="fa fa-file"></span><input id="convertMaterialNote" type="file" style="display: none;" name="materialNote" required="">
                                        </span>
                                    </label>
                                    <input type="text" id="convertMaterialNoteShow" class="form-control" readonly placeholder="Lampirkan nota" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row"></div>
                </form>
            </div>
            
            <div class="modal-footer" style="margin-top: -20px">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="editForm"><span class="fa fa-save"></span> Simpan</button>
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
            ajax: '{{ route('convection.getMaterialIn') }}'+'?convection={{$convection}}'+'&status='+{{$status}},
            columns: [
                { data: 'material_type', name: 'material_type' },
                { data: 'color', name: 'color' },

                @if($status != 1)
                    { data: 'length', name: 'length', render: function(data, type, full) {
                            data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                            return data+' yard';
                        }
                    },

                    { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                            var html = '';

                            html = html+'<div class="text-center"><a class="btn btn-primary convertConvectionBtn" id="convert_'+data+'" href="#materialModalConvert" data-toggle="modal" title="Konversi ke Produk"><span class="fa fa-sign-out"></span></a></div><input type="hidden" id="materialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="materialColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="materialLength_'+data+'" value="'+full.length+'" /><input type="hidden" id="materialConvectionId_'+data+'" value="'+full.convection_id+'" />';

                            return html;
                        }
                    }
                @else
                    { data: 'length', name: 'length', render: function(data, type, full) {
                            data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                            return data+' yard <input type="hidden" id="materialType_'+full.id+'" value="'+full.material_type+'" /><input type="hidden" id="materialColor_'+full.id+'" value="'+full.color+'" /><input type="hidden" id="materialLength_'+full.id+'" value="'+full.length+'" /><input type="hidden" id="materialConvectionId_'+full.id+'" value="'+full.convection_id+'" />';
                        }
                    },
                @endif
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
            $("#convertMaterialTypeHidden").val($('#materialType_'+id).val());
            $("#convertMaterialColorHidden").val($('#materialColor_'+id).val());
            $("#convertMaterialLengthHidden").val($('#materialLength_'+id).val());
            $("#convertMaterialConvectionIdHidden").val($('#materialConvectionId_'+id).val());
            $('#convertMaterialDate').val('');

            var length = $('#materialLength_'+id).val();
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#convertMaterialLength").val(length);
        });

        $('#convertMaterialLengthUsed').keyup(function(){
            var number = $(this).val().split('.').join("");
            $('#convertMaterialLengthUsedHidden').val(number);

            var rest = $('#convertMaterialLengthHidden').val() - number;
            rest = rest.toString();
            var numberUsed = rest.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $('#convertMaterialLength').val(numberUsed);

            number = number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $(this).val(number);
        });

        $('#convertMaterialTotal').keyup(function(){
            var number = $(this).val().split('.').join("");
            $('#convertMaterialTotalHidden').val(number);

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
            window.location = "{{ route('convection.index')}}" + '?convection='+ $(this).val()+'&status='+$("#searchMaterialUsed").val();
        });

        $("#searchMaterialUsed").change(function() {
            window.location = "{{ route('convection.index')}}" + '?convection='+ $('#searchMaterialBy').val()+'&status='+$(this).val();
        });

        $('#convertMaterialDate').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });

        $('#convertMaterialNote').change(function(){
            $('#convertMaterialNoteShow').val($(this).val());
        });

	});
</script>

@endsection
