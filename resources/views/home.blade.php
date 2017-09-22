@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>

        <div class="row">
	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Omset</span>
		              	<span class="info-box-number">Rp 150.000.000</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Hutang</span>
		              	<span class="info-box-number">Rp 50.000.000</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-dollar"></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Piutang</span>
		              	<span class="info-box-number">Rp 30.000.000</span>
		            </div>
	    		</div>
	    	</div>

	    	<div class="col-md-3 col-sm-6 col-xs-12">
	    		<div class="info-box">
	    			<span class="info-box-icon bg-yellow">
	    				<span class="fa fa-th-list "></span>
	    			</span>

	    			<div class="info-box-content">
		              	<span class="info-box-text">Stok</span>
		              	<span class="info-box-number">1500</span>
		            </div>
	    		</div>
	    	</div>
	    </div>
    </div>
</div>

@endsection
