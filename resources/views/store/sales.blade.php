@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Toko - Penjualan</h3>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <span style="font-weight: bold; margin-right: 10px">Filter Toko</span>

            <select id="searchMaterialBy" name="searchMaterialBy">
                @foreach($storeList as $storeList2)
                    <option value="{{$storeList2->id}}" @if($store == $storeList2->id) selected="" @endif>{{$storeList2->name}}</option>
                @endforeach
                <option value="" @if($store == 0) selected="" @endif >Semua Toko</option>
            </select>

            <span style="font-weight: bold; margin-right: 10px;margin-left: 20px">Filter Pembayaran</span>

            <select id="searchMaterialByPaymentType" name="searchMaterialByPaymentType">
                @foreach($paymentType as $paymentType2)
                    <option value="{{$paymentType2->id}}" @if($payment == $paymentType2->id) selected="" @endif>{{$paymentType2->name}}</option>
                @endforeach
                <option value="" @if($store == 0) selected="" @endif >Semua Tipe Pembayaran</option>
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
        				<th>Tanggal</th>
                        <th>Toko</th>
                        <th>Tipe Pembayaran</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Lihat Detail</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
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
                "url": '{{ route('store.sales.get') }}?store={{$store}}&payment={{$payment}}&dateFrom={{$dateFrom}}&dateTo={{$dateTo}}',
                "type": "GET",
            },
            columns: [
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
                { data: 'store_name', name: 'store_name' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'final_price', name: 'final_price', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    } 
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        var dataReturn = '<div class="text-center"><a class="btn btn-success detailTransactionBtn" id="detail_'+data+'" href="" data-toggle="modal" title="Ubah Data"><span class="fa fa-search"></span></a></div><input type="hidden" id="hidden_date_'+data+'" value="'+full.date+'"><input type="hidden" id="hidden_name_'+data+'" value="'+full.name+'"><input type="hidden" id="hidden_storeName_'+data+'" value="'+full.store_name+'"><input type="hidden" id="hidden_finalPrice_'+data+'" value="'+full.final_price+'"><input type="hidden" id="hidden_description_'+data+'" value="'+full.description+'">';

                        return dataReturn;
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#searchMaterialBy").change(function() {
            window.location = "{{ route('store.sales')}}" + '?store='+ $(this).val()+'&payment='+$("#searchMaterialByPaymentType").val();
        });

        $("#searchMaterialByPaymentType").change(function() {
            window.location = "{{ route('store.sales')}}" + '?store='+ $("#searchMaterialBy").val()+'&payment='+$(this).val();
        });

        $('#filterProcess').click(function(){
            window.location = "{{ route('store.sales')}}" + '?store='+$("#searchMaterialBy").val()+'&payment='+$("#searchMaterialByPaymentType").val()+'&dateFrom='+$("#filterDateFrom").val()+'&dateTo='+$("#filterDateTo").val();
        });

        $('#filterDateFrom, #filterDateTo, #transactionDate').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true
        });

	});
</script>

@endsection
