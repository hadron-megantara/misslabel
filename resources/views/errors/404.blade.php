@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="error-wrapper">
		    <div class="row">
			    <div class="col-md-12 col-sm-12 col-xs-12">
			        <div class="error-container text-center" >
				        <div style="height: 20vh">
							&nbsp;
						</div>
						
				        <div>
				            <div class="error-number"> 404 </div>
				            <div class="error-description" > Maaf halaman yang anda cari tidak ada </div>
				            <br>
				            <a href="{{ url('/') }}" class="btn btn-primary btn-cons">Kembali</a>
				        </div>
			        </div>
			    </div>
		    </div>
		</div>
    </div>
</div>

@endsection
