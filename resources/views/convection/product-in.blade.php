@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Konveksi - Produk Masuk</h3>

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

        <div class="table-responsive">
        	<table id="productInTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Produk</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Panjang Bahan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Deskripsi</th>
                        <th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="materialModalSend" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Aksesoris</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('convection.product.sendProductConvection') }}" role="form" id="sendForm">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="convertMaterialProductName" class="col-md-4 control-label">Nama Produk</label>

                        <div class="col-md-6">
                            <input id="sendProductName" type="text" class="form-control" readonly="">
                            <input type="hidden" id="sendProductId" name="productId" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductMaterialType" class="col-md-4 control-label">Tipe Bahan</label>

                        <div class="col-md-6">
                            <input id="sendProductMaterialType" type="text" class="form-control" readonly="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductMaterialColor" class="col-md-4 control-label">Warna Bahan</label>

                        <div class="col-md-6">
                            <input id="sendProductMaterialColor" type="text" class="form-control" readonly="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductTotal" class="col-md-4 control-label">Total Produk</label>

                        <div class="col-md-3">
                            <input id="sendProductTotal" type="text" class="form-control" readonly="">
                        </div>
                        <div class="col-md-3">
                            <input id="sendProductUnit" type="text" class="form-control" readonly="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="sendProductDescription" class="form-control" style="resize: none;" readonly=""></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductAccessoriesDescription" class="col-md-4 control-label">Deskripsi Aksesoris</label>

                        <div class="col-md-6">
                            <textarea id="sendProductAccessoriesDescription" class="form-control" name="productAccessories" required style="resize: none;" placeholder="Masukkan Keterangan"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductPrice" class="col-md-4 control-label">Harga</label>

                        <div class="col-md-6">
                            <input id="sendProductPrice" type="text" class="form-control number" required placeholder="Masukkan Harga">
                            <input id="sendProductPriceHidden" type="hidden" name="productPrice">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="sendForm"><span class="fa fa-save"></span> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var indexCounter = 1;

        var t = $('#productInTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('convection.getProductIn') }}'+'?convection={{$convection}}'+'&status='+{{$status}},
            columns: [
                { data: 'name', name: 'name' },
                { data: 'material_type', name: 'material_type' },
                { data: 'color', name: 'color' },
                { data: 'length', name: 'length', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data+' yard';
                    }
                },
                { data: 'price', name: 'price', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    }
                },
                { data: 'total', name: 'total', render: function(data, type, full) {
                        data = data+' '+full.unit;
                        return data;
                    }
                },
                { data: 'description', name: 'description' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"> <a class="btn btn-primary sendBtn" id="sendData_'+data+'" href="#materialModalSend" data-toggle="modal" title="Tandai Selesai"><span class="fa fa-sign-out"></span></a></div><input type="hidden" id="productMaterialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="productColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="productLength_'+data+'" value="'+full.length+'" /><input type="hidden" id="productPrice_'+data+'" value="'+full.price+'" /><input type="hidden" id="productTotal_'+data+'" value="'+full.total+'" /><input type="hidden" id="productUnit_'+data+'" value="'+full.unit+'" /><input type="hidden" id="productDescription_'+data+'" value="'+full.description+'" /><input type="hidden" id="productName_'+data+'" value="'+full.name+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#productInTable").on("click", ".sendBtn", function(){
            var id = this.id;
            id = id.substring(9);

            $("#sendProductId").val(id);
            $("#sendProductName").val($('#productName_'+id).val());
            $("#sendProductMaterialColor").val($('#productColor_'+id).val());
            $("#sendProductMaterialType").val($('#productMaterialType_'+id).val());
            $("#sendProductDescription").val($('#productDescription_'+id).val());
            $("#sendProductAccessoriesDescription").val('');

            var total = $('#productTotal_'+id).val();
            total = total.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#sendProductTotal").val(total);
            $("#sendProductUnit").val('pcs');
        });

        $('#sendProductPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#sendProductPriceHidden').val(number);
        });

        $('#sendProductPrice').priceFormat({
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

	});
</script>

@endsection
