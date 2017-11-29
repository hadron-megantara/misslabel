@if(session('user') || session('admin'))
  <?php
      $user = array();
      if(Session::has('user')){
          $user = Session::get('user');
      }
  ?>

  <div class="header navbar navbar-inverse">
      <div class="navbar-inner">
          <div class="header-seperation">
              <ul class="nav pull-left notifcation-center visible-xs visible-sm">
                  <li class="dropdown">
                      <a href="#main-menu" data-webarch="toggle-left-side">
                          <div class="iconset top-menu-toggle-white"></div>
                      </a>
                </li>
              </ul>
        
              <div class="text-center"></div>
              <a href="#" class="text-center">
                  <img src="/img/icon/logo.png" class="logo text-center text-center" alt="" data-src="/img/icon/logo.png" />
              </a>
          </div>
      
          <div class="header-quick-nav">
              <div class="pull-left">
                  <ul class="nav quick-section">
                      <li class="quicklinks">
                          <a href="#" class="" id="layout-condensed-toggle">
                              <div class="iconset top-menu-toggle-dark"></div>
                          </a>
                      </li>
                  </ul>

                  <ul class="nav quick-section">
                      <li class="quicklinks">
                          <a href="#" class="">
                            <div class="iconset top-reload"></div>
                          </a>
                      </li>

                      <li class="quicklinks"><span class="h-seperate"></span></li>

                      <li class="quicklinks">
                          <a href="#" class="">
                              <div class="iconset top-tiles"></div>
                          </a>
                      </li>

                      <li class="m-r-10 input-prepend inside search-form no-boarder">
                          <span class="add-on"><span class="iconset top-search"></span></span>
                          <input name="" type="text" class="no-boarder" placeholder="Search Dashboard" style="width:250px;">
                      </li>
                  </ul>
              </div>
        
              <div class="pull-right" style="margin-top: 3px;margin-right: 20px">
                  <div class="chat-toggler dropdown" style="min-width: 110px">
                      <div class="profile-pic">
                          <img src="/img/avatar.jpg" alt="" data-src="/img/avatar.jpg" width="35" height="35" />
                      </div>

                      <a href="#" class="dropdown-toggle pull-right" data-toggle="dropdown" style="margin-left: 5px">
                          <div class="user-details">
                              <div class="username">
                                  {{$user['name']}}
                              </div>
                          </div>

                          <div class="iconset top-down-arrow"></div>
                      </a>

                      <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                          <li><a href="#"><i class="fa fa-user"></i>&nbsp;&nbsp;Profil</a></li>
                          <li><a href="#"><i class="fa fa-key"></i>&nbsp;&nbsp;Ubah Password</a></li>
                          <li class="divider"></li>

                          <li>
                              <a href="#" style="display: inline-block;">
                                  <form action="/logout" method="post">
                                      {!! csrf_field() !!}
                                      <button type="submit" class="btn-ref text-left" style="width: 150%"><i class="fa fa-power-off"></i>&nbsp;&nbsp; Keluar</button>
                                  </form>
                              </a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="page-container row-fluid">
    	<div class="page-sidebar" id="main-menu">
      	<div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
              <!-- BEGIN MINI-PROFILE -->
            	<div class="user-info-wrapper" style="margin-top: 5px">
                  <div class="profile-wrapper">
                    	<img src="/img/avatar.jpg" alt="" data-src="/img/avatar.jpg" width="69" height="69" />
                  </div>
                  <div class="user-info" style="margin-top: 10px">
  	                  <div class="greeting">Hai,</div>
  	                  <div class="username">{{$user['name']}}</div>
                  </div>
            	</div>

        		<ul style="margin-top: 10px">
                	<li @if(\Request::is('/')) class="active" @endif>
                    	<a href="/">
                          <i class="fa fa-home"></i>
                          <span class="title">Beranda</span>
                    	</a>
                	</li>

                	<li @if(\Request::is('customer') || \Request::is('customer/*')) class="active" @endif>
                    	<a href="/customer">
                        	<i class="fa fa-users"></i>
                        	<span class="title">Pelanggan</span>
                    	</a>
                	</li>

                  <li class="">
                      <a href="javascript:;">
                          <i class="icon-custom-ui"></i>
                          <span class="title">Bahan</span>
                          @if(\Request::is('material') || \Request::is('material/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('material') || \Request::is('material/*')) style="display: block;" @endif>
                          <li @if(\Request::is('material/transaction') || \Request::is('material/transaction/*')) class="active" @endif><a href="/material/transaction">Nota Pembelian</a></li>
                          <li @if(\Request::is('material/list') || \Request::is('material/list/*')) class="active" @endif><a href="/material/list">List Bahan</a></li>
                          <li @if(\Request::is('material/type') || \Request::is('material/type/*')) class="active" @endif><a href="/material/type">Tipe Bahan</a></li>
                          <li @if(\Request::is('material/seller') || \Request::is('material/seller/*')) class="active" @endif><a href="/material/seller">Penjual</a></li>
                      </ul>
                  </li>

                  <li class="">
                      <a href="javascript:;">
                          <i class="fa fa-bank"></i>
                          <span class="title">Konveksi</span>
                          @if(\Request::is('convection') || \Request::is('convection/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('convection') || \Request::is('convection/*')) style="display: block;" @endif>
                          <li @if(\Request::is('convection/material-in') || \Request::is('convection/material-in/*')) class="active" @endif><a href="/convection/material-in">Bahan Masuk</a></li>
                          <li @if(\Request::is('convection/product-in') || \Request::is('convection/product-in/*')) class="active" @endif><a href="/convection/product-in">Produk Masuk</a></li>
                          <li @if(\Request::is('convection/product') || \Request::is('material/product/*')) class="active" @endif><a href="/convection/product">Produk Selesai</a></li>
                          <li @if(\Request::is('convection/list') || \Request::is('convection/convection-list/*')) class="active" @endif><a href="/convection/list">Daftar Konveksi</a></li>
                      </ul>
                  </li>

                	<li class="">
                      <a href="javascript:;">
                          <i class="fa fa-bank"></i>
                          <span class="title">Gudang</span>
                          @if(\Request::is('warehouse') || \Request::is('warehouse/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('warehouse') || \Request::is('warehouse/*')) style="display: block;" @endif>
                          <li @if(\Request::is('warehouse/stock') || \Request::is('warehouse/stock/*')) class="active" @endif><a href="/warehouse/stock">Stok</a></li>
                          <li @if(\Request::is('warehouse/transfer-stock') || \Request::is('warehouse/transfer-stock/*')) class="active" @endif><a href="/warehouse/transfer-stock">Transfer Gudang</a></li>
                          <li @if(\Request::is('warehouse/warehouse-list') || \Request::is('warehouse/warehouse-list/*')) class="active" @endif><a href="/warehouse/warehouse-list">Daftar Gudang</a></li>
                      </ul>
                  </li>

                  <li class="">
                      <a href="javascript:;">
                          <i class="fa fa-bank"></i>
                          <span class="title">Toko</span>
                          @if(\Request::is('store') || \Request::is('store/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('store') || \Request::is('store/*')) style="display: block;" @endif>
                          <li @if(\Request::is('store/stock') || \Request::is('store/stock/*')) class="active" @endif><a href="/store/stock">Stok</a></li>
                          <li @if(\Request::is('store/sold-out') || \Request::is('store/sold-out/*')) class="active" @endif><a href="/store/sold-out">Produk Terjual</a></li>
                          <li @if(\Request::is('store/transfer-product') || \Request::is('store/transfer-product/*')) class="active" @endif><a href="/store/transfer-product">Transfer Gudang</a></li>
                          <li @if(\Request::is('store/store-list') || \Request::is('store/store-list/*')) class="active" @endif><a href="/store/store-list">Daftar Toko</a></li>
                      </ul>
                  </li>

                	<li class="">
                    	<a href="#">
                        	<i class="fa fa-dollar"></i>
                        	<span class="title">Penjualan</span>
                    	</a>
                	</li>

                  <li class="">
                      <a href="#">
                          <i class="fa fa-money"></i>
                          <span class="title">Pengeluaran</span>
                      </a>
                  </li>

                  <li class="">
                      <a href="javascript:;">
                          <i class="fa fa-users"></i>
                          <span class="title">Karyawan</span>
                          @if(\Request::is('employee') || \Request::is('employee/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('employee') || \Request::is('employee/*')) style="display: block;" @endif>
                          <li @if(\Request::is('employee/list') || \Request::is('employee/list/*')) class="active" @endif><a href="/employee/list">List Karyawan</a></li>
                          <li @if(\Request::is('employee/attendance') || \Request::is('employee/attendance/*')) class="active" @endif><a href="/employee/attendance">Absensi Karyawan</a></li>
                      </ul>
                  </li>

                  <li class="">
                      <a href="javascript:;">
                          <i class="fa fa-cogs"></i>
                          <span class="title">Pengaturan</span>
                          @if(\Request::is('config') || \Request::is('config/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('config') || \Request::is('config/*')) style="display: block;" @endif>
                          <li @if(\Request::is('config/color') || \Request::is('config/color/*')) class="active" @endif><a href="/config/color">Warna</a></li>
                          <li @if(\Request::is('config/seller') || \Request::is('config/seller/*')) class="active" @endif><a href="/config/seller">Penjual</a></li>
                          <li @if(\Request::is('config/user') || \Request::is('config/user/*')) class="active" @endif><a href="/config/user">Pengguna</a></li>
                      </ul>
                  </li>

                  <li class="">
                      <a href="javascript:;">
                          <i class="fa fa-line-chart"></i>
                          <span class="title">Report</span>
                          @if(\Request::is('report') || \Request::is('report/*'))
                            <span class="arrow open"></span>
                          @else
                            <span class="arrow"></span>
                          @endif
                      </a>
                      <ul class="sub-menu" @if(\Request::is('report') || \Request::is('report/*')) style="display: block;" @endif>
                          <li @if(\Request::is('report/sales') || \Request::is('report/sales/*')) class="active" @endif><a href="/report/sales">Penjualan</a></li>
                          <li @if(\Request::is('report/turn-over') || \Request::is('report/turn-over/*')) class="active" @endif><a href="/report/turn-over">Omset</a></li>
                          <li @if(\Request::is('report/customer') || \Request::is('report/customer/*')) class="active" @endif><a href="/report/customer">Langganan</a></li>
                          <li @if(\Request::is('report/transaction') || \Request::is('report/transaction/*')) class="active" @endif><a href="/report/transaction">Nota Penjualan</a></li>
                          <li @if(\Request::is('report/delivery-order') || \Request::is('report/delivery-order/*')) class="active" @endif><a href="/report/delivery-order">Surat Jalan</a></li>
                          <li @if(\Request::is('report/attendance') || \Request::is('report/attendance/*')) class="active" @endif><a href="/report/attendance">Absensi</a></li>
                      </ul>
                  </li>
        		</ul>
    		</div>
  	</div>
@else
    
@endif