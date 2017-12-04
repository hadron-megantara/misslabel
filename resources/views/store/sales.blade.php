@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Toko - Penjualan</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#transactionAddModal" class="btn btn-success btnAddTransaction" data-toggle="modal">
                    <span class="fa fa-plus"></span> Tambah Transaksi
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

            <div class="row" style="margin-top: 20px">
                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Dari</span>
                </div>

                <div class="col-md-3">
                    <span style="font-weight: bold; margin-right: 10px">Sampai</span>
                </div>

                <div class="row" style="margin-bottom: 5px"></div>

                <div class="col-md-3">
                    <input id="filterDateFrom" type="text" class="form-control" name="filterDateFrom" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" @if(isset($_GET['dateFrom']) && $_GET['dateFrom'] != '') value="{{$_GET['dateFrom']}}" @endif />
                </div>

                <div class="col-md-3">
                    <input type="text" id ="filterDateTo" class="form-control filterDateTo" name="filterDateTo" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" @if(isset($_GET['dateTo']) && $_GET['dateTo'] != '') value="{{$_GET['dateTo']}}" @endif />
                </div>

                <div class="col-md-3">
                    <button type="button" id="filterProcess" class="btn btn-primary" style="width: 100%"><span class="fa fa-search"> </span>Cari</button>
                </div>
            </div>
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
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="transactionAddModal" class="modal fade" role="dialog" style="margin-bottom: 20px">
    <div class="modal-dialog full-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Transaksi</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('material.transaction.addTransaction') }}" role="form" id="addForm" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3" style="border-right: solid 2px #BDBDBD">
                                <div style="margin-bottom: 10px">
                                    <label for="transactionDate" class="col-md-12 control-label">Tanggal Transaksi</label>

                                    <div class="col-md-12">
                                        <input id="transactionDate" type="text" class="form-control" name="date" required placeholder="Tanggal Pembelian">
                                    </div>

                                    <label for="transactionDescription" class="col-md-12 control-label">Keterangan</label>

                                    <div class="col-md-12">
                                        <textarea id="transactionDescription" class="form-control" name="description" style="resize: none" rows="4" placeholder="Keterangan"></textarea>
                                    </div>

                                    <label for="materialNote" class="col-md-12 control-label">Nota Penjualan</label>
                                    <div class="row"></div>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    <span class="fa fa-file"></span><input id="transactionNote" type="file" style="display: none;" name="note" required="">
                                                </span>
                                            </label>
                                            <input type="text" id="transactionNoteShow" class="form-control" readonly placeholder="Lampirkan nota" required="">
                                        </div>
                                    </div>

                                    <label for="transactionPrice" class="col-md-12 control-label">Jumlah</label>

                                    <div class="col-md-12">
                                        <input id="transactionPrice" type="text" class="form-control number" placeholder="Rp 0">
                                        <input id="transactionPriceHidden" type="hidden" name="price" required>
                                    </div>

                                    <label for="transactionDiscount" class="col-md-12 control-label">Diskon</label>

                                    <div class="col-md-12">
                                        <input id="transactionDiscount" type="text" class="form-control number" placeholder="Masukkan Diskon" name="discount">
                                    </div>

                                    <label for="transactionFinalPrice" class="col-md-12 control-label">Total Harga</label>

                                    <div class="col-md-12">
                                        <input id="transactionFinalPrice" type="text" class="form-control number" placeholder="Rp 0">
                                        <input id="transactionFinalPriceHidden" type="hidden" name="final_price" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div id="transactionDetailArea" class="inputArea">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-success" form="addForm"><span class="fa fa-save"></span> Simpan</button>
                </div>
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
                        return data+' pcs';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('store.stock')}}" + '?store='+ $(this).val();
        });

        $('#filterDateFrom, #filterDateTo, #transactionDate').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });

        $("body").on("click", ".btnAddTransaction", function(e){
            $('#addForm').attr('action', "{{ route('store.sales.add') }}");

            $('.newAdded').remove();
            $('.addMoreRegion').remove();

            $('#transactionDetailArea').append("<div class='form-group inputAddedArea newAdded'><div class='col-md-3'><select class='form-control materialName' name='materialName[]' required><option value=''>Pilih Produk</option>@foreach($productDetail as $productDetail2)<option value='{{$productDetail2->id}}'>{{$productDetail2->name}}</option>@endforeach</select></div><div class='col-md-2' style='padding-right: 0'><select class='form-control materialColor' name='materialColor[]' required><option value=''>Pilih Warna</option>@foreach($productDetail as $productDetail3)<option value='{{$productDetail3->id}}'>{{$productDetail3->name}}</option>@endforeach</select></div><div class='col-md-3' style='padding-right: 0'><input type='text' class='form-control number materialPrice' required placeholder='Masukkan Harga' readonly=''><input type='hidden' name='materialPrice[]' class='materialPriceHidden' required></div><div class='col-md-3' style='padding-right: 0'><input type='text' class='form-control number materialPrice' required placeholder='Masukkan Harga' readonly=''><input type='hidden' name='materialPrice[]' class='materialPriceHidden' required></div><div class='col-md-1 addMoreRegion' style='padding-right: 0'><button type='button' class='btn btn-danger pull-right deleteBtnAction'><span class='fa fa-close deleteBtn'></span></button></div></div><div class='col-md-12 pull-right'><div class='addMoreRegion' style='padding-right: 0;margin-top:10px;margin-right: -30px;'><button type='button' class='btn btn-success pull-right addMore addBtn'><span class='fa fa-plus addBtn' title='Tambah Bahan'></span> Tambah Bahan</button></div></div>");
        });

        $("#transactionDetailArea").on("click", ".addMore", function(){
            $(this).closest('.addMoreRegion').remove();

            $('#transactionDetailArea').append("<div class='form-group inputAddedArea newAdded'><div class='col-md-12 border-space' style='margin-top:-20px'><hr></div><div class='col-md-3'><select class='form-control materialName' name='materialName[]' required><option value=''>Pilih Produk</option>@foreach($productDetail as $productDetail2)<option value='{{$productDetail2->id}}'>{{$productDetail2->name}}</option>@endforeach</select></div><div class='col-md-2' style='padding-right: 5px'><input type='text' class='form-control materialLength' required placeholder='Panjang bahan'><input type='hidden' class='materialLengthHidden' name='materialLength[]' required></div><div class='col-md-1' style='padding-left: 0'><select name='materialLengthUnit[]' class='form-control materialLengthUnit'><option value='yard'>yard</option><option value='meter'>meter</option></select></div><div class='col-md-2' style='padding-right: 0'><select class='form-control materialColor' name='materialColor[]' required><option value=''>Pilih Warna</option>@foreach($productDetail as $productDetail3)<option value='{{$productDetail3->id}}'>{{$productDetail3->name}}</option>@endforeach</select></div><div class='col-md-3' style='padding-right: 0'><input type='text' class='form-control number materialPrice' required placeholder='Masukkan Harga' readonly=''><input type='hidden' name='materialPrice[]' class='materialPriceHidden' required></div><div class='col-md-1 addMoreRegion' style='padding-right: 0'><button type='button' class='btn btn-danger pull-right deleteBtnAction'><span class='fa fa-close deleteBtn'></span></button></div></div><div class='col-md-12 pull-right'><div class='addMoreRegion' style='padding-right: 0;margin-top:10px;margin-right: -30px;'><button type='button' class='btn btn-success pull-right addMore addBtn'><span class='fa fa-plus addBtn' title='Tambah Bahan'></span> Tambah Bahan</button></div></div>");
        });

        $("#transactionDetailArea").on("click", ".deleteBtnAction", function(){
            $(this).closest('.inputAddedArea').remove();

            if($('.inputAddedArea').length <= 2){
                $('.border-space').remove();
            }
        });

	});
</script>

@endsection
