@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Toko - Produk Masuk</h3>

            <div class="pull-right" style="margin-top: 5px">
                <a href="#convectionModalExport" class="btn btn-danger" data-toggle="modal">
                    <span class="fa fa-cloud-download"> </span>Download
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;padding: 10px; background-color: #fff">
            <span style="font-weight: bold; margin-right: 10px">Filter Gudang</span>

            <select id="searchByWarehouse" name="searchByWarehouse">
                @foreach($warehouseList as $warehouseList2)
                    <option value="{{$warehouseList2->id}}" @if($warehouse == $warehouseList2->id) selected="" @endif>{{$warehouseList2->name}}</option>
                @endforeach
                <option value="" @if($store == 0) selected="" @endif >Semua Gudang</option>
            </select>

            <span style="font-weight: bold; margin-right: 10px; margin-left: 20px">Filter Toko</span>

            <select id="searchByStore" name="searchByStore">
                @foreach($storeList as $storeList2)
                    <option value="{{$storeList2->id}}" @if($store == $storeList2->id) selected="" @endif>{{$storeList2->name}}</option>
                @endforeach
                <option value="" @if($store == 0) selected="" @endif >Semua Toko</option>
            </select>

            {{-- <div class="row"></div>

            <div class="row" style="margin-top:20px">
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
            </div> --}}
        </div>

        <div class="row"></div>

        <div class="table-responsive">
        	<table id="productTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th class="text-center">Nama Produk</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Verifikasi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<div id="verificateModal" class="modal fade" role="dialog" style="margin-top:1%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Verifikasi Barang Masuk</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('store.incomingProduct.verificate') }}" role="form" id="verificateForm">
                    {!! csrf_field() !!}

                    <label>Anda yakin ingin memverifikasi model "<b id="productNameVerificate"></b>" ?</label>
                    <br />
                    <label style="margin-top:-20px">Total barang : <b><span id="productTotalVerificate"></span></b></label>
                    <br/>
                    <label style="margin-top:-20px">Keterangan : <b><span id="productDescriptionVerificate"></span></b></label>
                    <input type="hidden" name="id" value="" id="verificationId" />
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                <button type="submit" class="btn btn-success" form="verificateForm"><span class="fa fa-check"></span> Verifikasi</button>
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
                "url": '{{ route('store.incomingProduct.get') }}'+'?store='+'{{$store}}&warehouse={{$warehouse}}',
                "type": "GET",
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'date_delivery', name: 'date_delivery' },
                { data: 'total', name: 'total', render: function(data, type, full) {
                        data = full.total_product+' pcs';
                        return data;
                    }
                },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        var dataReturn = '<div class="text-center"><a class="btn btn-primary checkBtn" id="check_'+data+'" href="#verificateModal" data-toggle="modal" title="Verifikasi Data"><span class="fa fa-check"></span></a></div><input type="hidden" id="name_'+data+'" value="'+full.name+'"><input type="hidden" id="description_'+data+'" value="'+full.description+'"><input type="hidden" id="total_'+data+'" value="'+full.total_product+'">';

                        return dataReturn;
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $('#productTable').on("click", ".checkBtn", function(){
            var id = this.id;
            id = id.substring(6);
            
            $('#verificationId').val(id);
            $('#productNameVerificate').html($('#name_'+id).val());
            $('#productTotalVerificate').html($('#total_'+id).val());
            $('#productDescriptionVerificate').html($('#description_'+id).val());
        });

        $("#searchByStore").change(function() {
            window.location = "{{ route('store.incomingProduct')}}" + '?store='+ $(this).val()+'&warehouse='+$("#searchByWarehouse").val();
        });

        $("#searchByWarehouse").change(function() {
            window.location = "{{ route('store.incomingProduct')}}" + '?store='+ $("#searchByStore").val()+'&warehouse='+$(this).val();
        });
	});
</script>

@endsection
