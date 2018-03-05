@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Toko - History Transfer Barang</h3>
        </div>

        <div class="table-responsive">
        	<table id="historyTable" class="table-bordered">
        		<thead>
        			<tr>
        				<th>Transfer Dari Toko</th>
                        <th>Transfer Ke Toko</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
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
        var indexCounter = 1;

        var t = $('#historyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('store.transferStockHistory.get') }}',
            columns: [
                { data: 'stock_from', name: 'stock_from' },
                { data: 'stock_to', name: 'stock_to' },
                { data: 'description', name: 'description' },
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
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });
	});
</script>

@endsection
