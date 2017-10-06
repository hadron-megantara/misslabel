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
                          <li @if(\Request::is('material') || \Request::is('material/*')) class="active" @endif><a href="/material">Pembelian</a></li>
                          <li @if(\Request::is('material/type') || \Request::is('material/type/*')) class="active" @endif><a href="/material/type">Tipe Bahan</a></li>
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
                          <li @if(\Request::is('convection/product') || \Request::is('material/product/*')) class="active" @endif><a href="/convection/product">Produk</a></li>
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
                          <li @if(\Request::is('warehouse/incoming-stock') || \Request::is('warehouse/incoming-stock/*')) class="active" @endif><a href="/warehouse/incoming-stock">Barang Masuk</a></li>
                          <li @if(\Request::is('warehouse/stock') || \Request::is('warehouse/stock/*')) class="active" @endif><a href="/warehouse/stock">Stok</a></li>
                          <li @if(\Request::is('warehouse/sold-out') || \Request::is('warehouse/sold-out/*')) class="active" @endif><a href="/warehouse/sold-out">Barang Terjual</a></li>
                          <li @if(\Request::is('warehouse/transfer-stock') || \Request::is('warehouse/transfer-stock/*')) class="active" @endif><a href="/warehouse/transfer-stock">Transfer Gudang</a></li>
                          <li @if(\Request::is('warehouse/warehouse-list') || \Request::is('warehouse/warehouse-list/*')) class="active" @endif><a href="/warehouse/warehouse-list">Daftar Gudang</a></li>
                      </ul>
                  </li>

                	<li class="">
                      <a href="#">
                          <i class="fa fa-institution"></i>
                          <span class="title">Toko</span>
                      </a>
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
        		</ul>

        		<p class="menu-title" style="margin-top: -10px">Report<span class="pull-right"><i class="fa fa-flag"></i></span></p>

              <ul>
              	<li class="">
                    	<a href="#">
                        	<i class="fa fa-line-chart"></i>
                        	<span class="title">Penjualan</span>
                    	</a>
                	</li>

                	<li class="">
                    	<a href="#">
                        	<i class="fa fa-line-chart"></i>
                        	<span class="title">Omset</span>
                    	</a>
                	</li>

                	<li class="">
                    	<a href="#">
                        	<i class="fa fa-line-chart"></i>
                        	<span class="title">Langganan</span>
                    	</a>
                	</li>

                	<li class="">
                    	<a href="#">
                        	<i class="fa fa-line-chart"></i>
                        	<span class="title">Nota Penjualan</span>
                    	</a>
                	</li>

                	<li class="">
                    	<a href="#">
                        	<i class="fa fa-line-chart"></i>
                        	<span class="title">Surat Jalan</span>
                    	</a>
                	</li>

                  <li class="">
                      <a href="#">
                          <i class="fa fa-users"></i>
                          <span class="title">Absensi</span>
                      </a>
                  </li>
        		</ul>
    		</div>
  	</div>
@else
    
@endif