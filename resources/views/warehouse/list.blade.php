@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Stok Produk</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#convectionModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <span style="font-weight: bold; margin-right: 10px">Filter Gudang</span>

            <select id="searchMaterialBy" name="searchMaterialBy">
                @foreach($warehouseList as $warehouseList)
                    <option value="{{$warehouseList->id}}" @if($warehouse == $warehouseList->id) selected="" @endif>{{$warehouseList->name}}</option>
                @endforeach
                <option value="" @if($warehouse == 0) selected="" @endif >Semua Gudang</option>
            </select>
        </div>

        <div class="row"></div>

        <div class="table-responsive">
        	<table id="productTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Produk</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Deskripsi</th>
                        <th>Total</th>
        				<th class="actions-column">Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>

        <hr style="border-top: 2px solid #000000;">

        <div class="page-title">
            <h3>Produk terpilih</h3>
            <div class="pull-right" style="margin-top: 5px">
                <a href="#productModalSend" class="btn btn-success productModalSend" data-toggle="modal">
                    <span class="fa fa-send"></span> Kirim ke Toko
                </a>
            </div>
        </div>

        <div class="table-responsive bottomTable">
            <table id="productTableChecked" class="table-bordered selectedItems" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Panjang Bahan</th>
                        <th>Total</th>
                        <th>Deskripsi</th>
                        <th class="actions-column">Aksi</th>
                    </tr>
                </thead>
                <tbody id="checkedItems">
                    <tr class="emptyItems">
                        <td colspan="8" class="text-center">
                            Tidak ada data untuk ditampilkan...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="productModalSend" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kirim Produk ke Gudang</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('convection.product.sendProduct') }}" role="form" id="editForm" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="sendProductWarehouse" class="col-md-4 control-label">Gudang</label>

                        <div class="col-md-6">
                            <select class="form-control" name="warehouseId" >
                                <option value="">Pilih Gudang</option>
                                @foreach($warehouseList as $warehouseList2)
                                    <option value="{{$warehouseList2->id}}">{{$warehouseList2->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductDeliveryNote" class="col-md-4 control-label">Nota Surat Jalan</label>

                        <div class="col-md-6">
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        <span class="fa fa-file"></span><input id="sendProductDeliveryNote" type="file" style="display: none;" name="deliveryNote">
                                    </span>
                                </label>
                                <input type="text" id="sendProductDeliveryNoteHidden" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductDeliveryDate" class="col-md-4 control-label">Tanggal Kirim</label>

                        <div class="col-md-6">
                            <input id="sendProductDeliveryDate" type="text" class="form-control" name="deliveryDate" required placeholder="Tanggal Kirim">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sendProductDescription" class="col-md-4 control-label">Keterangan</label>

                        <div class="col-md-6">
                            <textarea id="sendProductDescription" name="description" class="form-control"></textarea>
                            <input type="hidden" id="sendProductId" name="productId" style="resize: none;" />
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
        var t = $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:
            {
                "url": '{{ route('warehouse.getStock') }}'+'?warehouse='+'{{$warehouse}}',
                "type": "GET",
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'material_type', name: 'material_type' },
                { data: 'color', name: 'color' },
                { data: 'description', name: 'description' },
                { data: 'total', name: 'total', render: function(data, type, full) {
                        data = data+' '+full.unit;
                        return data;
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"> <input type="checkbox" id="check_'+data+'" class="checkProduct" /></div><input type="hidden" id="productMaterialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="productColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="productPrice_'+data+'" value="'+full.price+'" /><input type="hidden" id="productTotal_'+data+'" value="'+full.total+'" /><input type="hidden" id="productUnit_'+data+'" value="'+full.unit+'" /><input type="hidden" id="productDescription_'+data+'" value="'+full.description+'" /><input type="hidden" id="productName_'+data+'" value="'+full.name+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('warehouse.stock')}}" + '?warehouse='+ $(this).val();
        });


        $('#productTable').on("click", ".checkProduct", function(){
            var id = this.id;
            id = id.substring(6);

            var length = $('#productLength_'+id).val();
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

            $("#checkedItems").append('<tr><td>'+$('#productName_'+id).val()+'</td><td>'+$('#productMaterialType_'+id).val()+'</td><td>'+$('#productColor_'+id).val()+'</td><td>'+length+' yard</td><td>'+$('#productTotal_'+id).val()+' '+$('#productUnit_'+id).val()+'</td><td>'+$('#productDescription_'+id).val()+'</td><td class="productItemsHidden"><div class="text-center"><input type="checkbox" id="check_'+id+'" checked="" class="checkProduct" /></div><input type="hidden" id="productSendId_'+id+'" name="" value="'+id+'" /><input type="hidden" id="productMaterialType_'+id+'" value="'+$('#productMaterialType_'+id).val()+'" /><input type="hidden" id="productColor_'+id+'" value="'+$('#productColor_'+id).val()+'" /><input type="hidden" id="productLength_'+id+'" value="'+$('#productLength_'+id).val()+'" /><input type="hidden" id="productTotal_'+id+'" value="'+$('#productTotal_'+id).val()+'" /><input type="hidden" id="productUnit_'+id+'" value="'+$('#productUnit_'+id).val()+'" /><input type="hidden" id="productDescription_'+id+'" value="'+$('#productDescription_'+id).val()+'" /><input type="hidden" id="productName_'+id+'" value="'+$('#productName_'+id).val()+'" /></td></tr>');

            $("#productIdAppend").append('<input type="hidden" id="idAppended_'+id+'" name="productId[]" value="'+id+'" />');

            productId.push(id);
            $('.emptyItems').hide();

            $('#productTable').DataTable().ajax.reload();
            
        });

        $('#productTableChecked').on("click", ".checkProduct", function(){
            var id = this.id;
            id = id.substring(6);
            var rowCount = $('#productTableChecked tr').length;

            if(rowCount == 0){
                $('.emptyItems').show();
            }

            var removeItem = id;
            productId = jQuery.grep(productId, function(value) {
              return value != removeItem;
            });
            
            $(this).closest('tr').remove();
            $('#productTable').DataTable().ajax.reload();

            $('#idAppended_'+id).remove();
        });

        $("#productTable").on("click", ".productModalSend", function(){
            var id = this.id;
            id = id.substring(5);

            $("#sendProductId").val(id);
            $("#sendProductName").val($('#productName_'+id).val());

            var length = $('#productLength_'+id).val();
            length = length.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            $("#sendProductLength").val(length+' yard');

            $("#sendProductMaterialType").val($('#productMaterialType_'+id).val());
            $("#sendProductDescription").val($('#productDescription_'+id).val());
            $("#sendProductColor").val($('#productColor_'+id).val());
            $("#sendProductTotal").val($('#productTotal_'+id).val()+' '+$('#productUnit_'+id).val());

            // var price = $('#productPrice_'+id).val();
            // price = 'Rp '+price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            // $("#sendProductPrice").val(price);
        });

        $('#sendProductDeliveryNote').change(function(){
            $('#sendProductDeliveryNoteHidden').val($(this).val());
        });

        $('#sendProductDeliveryDate').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });

        $('#sendProductDeliveryDate').keypress(function(event){
            event.preventDefault();
        });
	});
</script>

@endsection
