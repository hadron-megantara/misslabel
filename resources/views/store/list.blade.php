@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Toko - Stok Produk</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#convectionModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <span style="font-weight: bold; margin-right: 10px">Filter Toko</span>

            <select id="searchMaterialBy" name="searchMaterialBy">
                @foreach($storeList as $storeList2)
                    <option value="{{$storeList2->id}}" @if($store == $storeList2->id) selected="" @endif>{{$storeList2->name}}</option>
                @endforeach
                <option value="" @if($store == 0) selected="" @endif >Semua Toko</option>
            </select>
        </div>

        <div class="row"></div>

        <div class="table-responsive">
        	<table id="productTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Nama Produk</th>
                        <th>Keterangan</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Tambah Transaksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>

        <hr style="border-top: 2px solid #000000;">

        <div class="page-title">
            <h3>Transaksi - Produk terpilih</h3>
        </div>

        <div class="table-responsive bottomTable">
            <table id="productTableChecked" class="table-bordered selectedItems" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th style="width:80px">Keterangan</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Harga</th>
                        <th style="width:40px">Banyaknya</th>
                        <th>Jumlah Harga</th>
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
        </div>

        <div class="" style="margin-bottom: 100px;padding-bottom: 20px;padding-top:20px;margin-top: -70px;background-color: #ffffff">
            <div class="form-group row">
                <div class="col-md-12 row">
                    <form class="form-horizontal transaction-add-form" method="POST" action="{{ route('store.transaction.add') }}" role="form" id="addForm" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                        <div id="totalListedHidden"></div>

                        <div class="col-md-3">
                            <label for="transactionDate" class="col-md-12 control-label">Tanggal Transaksi</label>
                            <div class="col-md-12">
                                <input id="transactionDate" type="text" class="form-control" name="date" required placeholder="Tanggal Pembelian" style="position: relative; z-index: 100" />
                                <input type="hidden" name="storeId" value="{{$store}}" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="transactionNote" class="control-label">Nota Penjualan</label>
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        <span class="fa fa-file"></span><input id="transactionNote" type="file" style="display: none;" name="note" required="">
                                    </span>
                                </label>
                                <input type="text" id="transactionNoteShow" class="form-control" readonly placeholder="Lampirkan nota" required="">
                            </div>

                            <label for="paymentType" class="control-label" style="margin-top:10px">Tipe Pembayaran</label>
                            <select class="form-control" id="paymentType" name="paymentType" required="">
                                <option value="">--- Pilih Tipe Pembayaran ---</option>
                                @foreach($paymentType as $paymentType2)
                                    <option value="{{$paymentType2->id}}">{{$paymentType2->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="transactionDescription" class="col-md-12 control-label">Keterangan</label>
                            <div class="col-md-12">
                                <textarea id="transactionDescription" class="form-control" name="description" style="resize: none" rows="4" placeholder="Masukkan Keterangan..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="transactionPrice" class="control-label">Jumlah</label>
                            <input id="transactionPrice" type="text" class="form-control number" placeholder="Rp 0">
                            <input id="transactionPriceHidden" type="hidden" name="price" required>

                            <label for="transactionDiscount" class="control-label" style="margin-top:10px">Diskon</label>
                            <input id="transactionDiscount" type="text" class="form-control number" placeholder="Masukkan Diskon" name="discount">

                            <label for="transactionFinalPrice" class="control-label" style="margin-top:10px">Total Harga</label>
                            <input id="transactionFinalPrice" type="text" class="form-control number" placeholder="Rp 0">
                            <input id="transactionFinalPriceHidden" type="hidden" name="finalPrice" required>
                        </div>

                        <div class="row"></div>

                        <div class="col-md-12" style="margin-top: 20px">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-save"> </span>Simpan Transaksi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
	$(document).ready(function(){
        var totalAllPrice = 0;
        var totalFinalPrice = 0;

        var t = $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:
            {
                "url": '{{ route('store.getStock') }}'+'?store='+'{{$store}}',
                "type": "GET",
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'material_type', name: 'material_type' },
                { data: 'color', name: 'color' },
                { data: 'price', name: 'price', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data+' /'+full.unit;
                    } 
                },
                { data: 'total_product', name: 'total_product', render: function(data, type, full) {
                        if($('#totalListedHidden_'+full.id).length > 0){
                            data = parseInt(data) - parseInt($('#totalListedHidden_'+full.id).val());
                        }

                        data = data+' pcs';
                        return data;
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"> <input type="text" id="totalSendProduct_'+data+'" class="totalSendProduct" placeholder="0" style="width:100px" /><button type="button" class="btn-sm btn-success btnSend" id="btnSend_'+data+'" style="margin-left:5px;margin-top:2px"><span class="fa fa-send"></span></button></div><input type="hidden" id="productName_'+data+'" value="'+full.name+'" /><input type="hidden" id="productMaterialType_'+data+'" value="'+full.material_type+'" /><input type="hidden" id="productDescription_'+data+'" value="'+full.description+'" /><input type="hidden" id="productColor_'+data+'" value="'+full.color+'" /><input type="hidden" id="productTotal_'+data+'" value="'+full.total+'" /><input type="hidden" id="productPrice_'+data+'" value="'+full.price+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
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
                    $("#totalListedHidden").append('<input type="hidden" value="'+id+'" id="totalListedIdHidden_'+id+'" name="storeStockId[]" /><input type="hidden" value="'+totalSend+'" id="totalListedHidden_'+id+'" name="storeStockTotal[]" /><input type="hidden" value="'+$('#productPrice_'+id).val()+'" id="totalListedPriceHidden_'+id+'" name="storeStockPrice[]" />');
                    total = parseInt(totalSend);
                    $("#totalListedHidden_"+id).val(total);
                }

                totalLast = parseInt($("#productTotal_"+id).val()) - parseInt(totalSend);
                $("#productTotal_"+id).val(totalLast);
                

                $("#lineListed_"+id).remove();

                var totalPricePerProduct = parseInt($('#productPrice_'+id).val()) * total;
                totalAllPrice = parseInt(totalAllPrice) + totalPricePerProduct;
                totalAllPriceFormated = totalAllPrice.toString();
                totalAllPriceFormated = totalAllPriceFormated.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                totalAllPriceFormated =  'Rp '+totalAllPriceFormated;
                $("#transactionPrice").val(totalAllPriceFormated);
                $("#transactionPriceHidden").val(totalAllPrice);

                $("#transactionFinalPrice").val(totalAllPriceFormated);
                $("#transactionFinalPriceHidden").val(totalAllPrice);


                var productPriceFormated = $('#productPrice_'+id).val();
                productPriceFormated = productPriceFormated.toString();
                productPriceFormated = productPriceFormated.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                productPriceFormated = 'Rp '+productPriceFormated;

                totalPricePerProduct = totalPricePerProduct.toString();

                var totalPricePerProductFormated = totalPricePerProduct.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                totalPricePerProductFormated =  'Rp '+totalPricePerProductFormated;


                $("#checkedItems").append('<tr id="lineListed_'+id+'"><td>'+$('#productName_'+id).val()+'</td><td>'+$('#productDescription_'+id).val()+'</td><td>'+$('#productMaterialType_'+id).val()+'</td><td>'+$('#productColor_'+id).val()+'</td><td>'+productPriceFormated+'</td><td id="productListedTotal_'+id+'">'+total+' pcs</td><td id="productListedTotalPrice_'+id+'">'+totalPricePerProductFormated+'</td><td class="productItemsHidden"><div class="text-center"><input type="text" id="totalSendProductListed_'+id+'" class="totalSendProduct" placeholder="0" style="width:100px" /><button type="button" class="btn-sm btn-danger btnSendListed" id="btnSendListed_'+id+'" style="margin-left:5px;margin-top:2px"><span class="fa fa-minus"></span></button></div><input type="hidden" id="productSendId_'+id+'" name="" value="'+id+'" /><input type="hidden" id="productMaterialType_'+id+'" value="'+$('#productMaterialType_'+id).val()+'" /><input type="hidden" id="productColor_'+id+'" value="'+$('#productColor_'+id).val()+'" /><input type="hidden" id="productTotal_'+id+'" value="'+$('#productTotal_'+id).val()+'" /><input type="hidden" id="productUnit_'+id+'" value="'+$('#productUnit_'+id).val()+'" /><input type="hidden" id="productDescription_'+id+'" value="'+$('#productDescription_'+id).val()+'" /><input type="hidden" id="productName_'+id+'" value="'+$('#productName_'+id).val()+'" /></td></tr>');

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

            var totalPriceListed = parseInt(totalListedLast) * parseInt($('#productPrice_'+id).val());
            totalPriceListedFormated = totalPriceListed.toString();
            totalPriceListedFormated = totalPriceListedFormated.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            totalPriceListedFormated =  'Rp '+totalPriceListedFormated;
            $("#productListedTotalPrice_"+id).html(totalPriceListedFormated);


            var totalPriceMin = parseInt($('#productPrice_'+id).val()) * totalListedRevert;
            totalAllPrice = parseInt(totalAllPrice) - totalPriceMin;
            totalAllPriceFormated = totalAllPrice.toString();
            totalAllPriceFormated = totalAllPriceFormated.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            totalAllPriceFormated =  'Rp '+totalAllPriceFormated;
            $("#transactionPrice").val(totalAllPriceFormated);
            $("#transactionPriceHidden").val(totalAllPrice);

            $("#transactionFinalPrice").val(totalAllPriceFormated);
            $("#transactionFinalPriceHidden").val(totalAllPrice);
            
            $('#productTable').DataTable().ajax.reload();

            if(totalListedLast == 0){
                $(this).closest('tr').remove();
                $("#totalListedHidden_"+id).remove();
                $("#totalListedPriceHidden_"+id).remove();
                $("#totalListedIdHidden_"+id).remove();
                $('#idAppended_'+id).remove();
            }

            $('#totalSendProductListed_'+id).val(0);

            var rowCount = $('#productTableChecked tr').length;

            if(rowCount == 0){
                $('.emptyItems').show();
            }
        });


        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('store.stock')}}" + '?store='+ $(this).val();
        });

        $("body").on("keypress", "#transactionDate,#transactionPrice,#transactionFinalPrice", function(e){
            e.preventDefault();
        });

        $("#productTable").on("keypress", ".totalSendProduct", function(e){
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $("#productTableChecked").on("keypress", ".totalSendProduct", function(e){
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $('#transactionDate').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true,
        });

        $('#transactionNote').change(function(){
            $('#transactionNoteShow').val($(this).val());
        });
	});
</script>

@endsection
