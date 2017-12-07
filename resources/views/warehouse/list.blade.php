@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Gudang - Stok Produk</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#convectionModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <span style="font-weight: bold; margin-right: 10px">Filter Gudang</span>

            <select id="searchMaterialBy" name="searchMaterialBy">
                @foreach($warehouseList as $warehouseList2)
                    <option value="{{$warehouseList2->id}}" @if($warehouse == $warehouseList2->id) selected="" @endif>{{$warehouseList2->name}}</option>
                @endforeach
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
        				<th class="actions-column">Jumlah Kirim</th>
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
                        <th>Deskripsi</th>
                        <th>Total</th>
                        <th class="actions-column">Kurangi Jumlah</th>
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

            <div id="totalListedHidden"></div>
        </div>
    </div>
</div>

<div id="productModalSend" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kirim Produk ke Toko</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('warehouse.transferStock') }}" role="form" id="editForm" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="sendProductWarehouse" class="col-md-4 control-label">Toko</label>

                        <div class="col-md-6">
                            <select class="form-control" name="storeId" >
                                <option value="">Pilih Toko</option>
                                @foreach($storeList as $storeList2)
                                    <option value="{{$storeList2->id}}">{{$storeList2->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="warehouseId" value="{{$warehouse}}" />
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
                            <textarea id="sendProductDescription" name="description" class="form-control" style="resize: none;"></textarea>

                            <div id="sendItemHidden"></div>
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
                        if($('#totalListedHidden_'+full.id).length > 0){
                            data = parseInt(data) - parseInt($('#totalListedHidden_'+full.id).val());
                        }

                        data = data+' pcs';
                        return data;
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"> <input type="text" id="totalSendProduct_'+data+'" class="totalSendProduct" placeholder="0" /><button type="button" class="btn-sm btn-success btnSend" id="btnSend_'+data+'" style="margin-left:5px;margin-top:2px"><span class="fa fa-send"></span></button></div><input type="hidden" id="productMaterialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="productColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="productTotal_'+data+'" value="'+full.total+'" /><input type="hidden" id="productDescription_'+data+'" value="'+full.description+'" /><input type="hidden" id="productName_'+data+'" value="'+full.name+'" />';
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

        $('#productTable').on("click", ".btnSend", function(){
            var id = this.id;
            id = id.substring(8);
            totalSend = $('#totalSendProduct_'+id).val();
            if(totalSend == ""){
                totalSend = 0;
            }

            var total = 0;

            if(totalSend > 0){
                if($('#totalListedHidden_'+id).length > 0){
                    total = parseInt(totalSend) + parseInt($("#totalListedHidden_"+id).val());
                    $("#totalListedHidden_"+id).val(total);
                } else{
                    $("#totalListedHidden").append('<input type="hidden" value="'+totalSend+'" id="totalListedHidden_'+id+'"/>');
                    total = parseInt(totalSend);
                    $("#totalListedHidden_"+id).val(total);
                }

                totalLast = parseInt($("#productTotal_"+id).val()) - parseInt(totalSend);
                $("#productTotal_"+id).val(totalLast);
                

                $("#lineListed_"+id).remove();

                $("#checkedItems").append('<tr id="lineListed_'+id+'"><td>'+$('#productName_'+id).val()+'</td><td>'+$('#productMaterialType_'+id).val()+'</td><td>'+$('#productColor_'+id).val()+'</td><td>'+$('#productDescription_'+id).val()+'</td><td id="productListedTotal_'+id+'">'+total+' pcs</td><td class="productItemsHidden"><div class="text-center"><input type="text" id="totalSendProductListed_'+id+'" class="totalSendProduct" placeholder="0" /><button type="button" class="btn-sm btn-danger btnSendListed" id="btnSendListed_'+id+'" style="margin-left:5px;margin-top:2px"><span class="fa fa-minus"></span></button></div><input type="hidden" id="productSendId_'+id+'" name="" value="'+id+'" /><input type="hidden" id="productMaterialType_'+id+'" value="'+$('#productMaterialType_'+id).val()+'" /><input type="hidden" id="productColor_'+id+'" value="'+$('#productColor_'+id).val()+'" /><input type="hidden" id="productTotal_'+id+'" value="'+$('#productTotal_'+id).val()+'" /><input type="hidden" id="productUnit_'+id+'" value="'+$('#productUnit_'+id).val()+'" /><input type="hidden" id="productDescription_'+id+'" value="'+$('#productDescription_'+id).val()+'" /><input type="hidden" id="productName_'+id+'" value="'+$('#productName_'+id).val()+'" /></td></tr>');

                $("#productIdAppend").append('<input type="hidden" id="idAppended_'+id+'" name="productId[]" value="'+id+'" />');

                $('.emptyItems').hide();

                $('#productTable').DataTable().ajax.reload();
            }
            
        });

        $('#productTableChecked').on("click", ".btnSendListed", function(){
            var id = this.id;
            id = id.substring(14);
            
            var totalListedRevert = parseInt($("#totalSendProductListed_"+id).val());
            var totalListed = parseInt($("#totalListedHidden_"+id).val());

            var totalListedLast = totalListed - totalListedRevert;
            $("#totalListedHidden_"+id).val(totalListedLast);
            $("#productListedTotal_"+id).html(totalListedLast+' pcs');
            
            $('#productTable').DataTable().ajax.reload();

            if(totalListedLast == 0){
                $(this).closest('tr').remove();
                $('#idAppended_'+id).remove();
            }

            $('#totalSendProductListed_'+id).val(0);

            var rowCount = $('#productTableChecked tr').length;

            if(rowCount == 0){
                $('.emptyItems').show();
            }
        });

        $(".content").on("click", ".productModalSend", function(){
            var id = this.id;
            id = id.substring(5);
            $('#sendItemHidden').html('');

            $('#totalListedHidden').children('input').each(function (e) {
                var id = this.id;
                id = id.substring(18);

                $('#sendItemHidden').append('<input type="hidden" name="productId[]" value="'+$('#productSendId_'+id).val()+'" /><input type="hidden" name="productTotal[]" value="'+$('#totalListedHidden_'+id).val()+'"/>');
            });
            
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

        $("#productTable").on("keypress", ".totalSendProduct", function(e){
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $("#productTableChecked").on("keypress", ".totalSendProduct", function(e){
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        
	});
</script>

@endsection
