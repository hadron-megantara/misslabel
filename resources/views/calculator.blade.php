@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Kalkulator Estimasi Keuntungan</h3>
        </div>

        <div class="col-md-12" style="margin-bottom: 20px;">
            <div class="" style="background-color:#ffffff">
                <div class="row" style="padding:20px 0">
                    <div class="col-md-6">
                        <label class="col-md-6">Pembelian Bahan</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="materialPrice" value="0" />
                            <input type="hidden" class="form-control" id="materialPriceHidden" value="0"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-md-6">Upah Jahit</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="upahJahit" value="0" />
                            <input type="hidden" class="form-control" id="upahJahitHidden" value="0" />
                        </div>
                    </div>
                </div>

                <div class="row" style="padding:10px 0">
                    <div class="col-md-6">
                        <label class="col-md-6">Aksesoris</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="aksesoris" value="0" />
                            <input type="hidden" class="form-control" id="aksesorisHidden" value="0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-md-6">Ongkos Kirim/Transport Barang</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="transport" value="0" />
                            <input type="hidden" class="form-control" id="transportHidden" value="0" />
                        </div>
                    </div>
                </div>

                <div class="row" style="padding:10px 0">
                    <div class="col-md-6">
                        <label class="col-md-6">Total Barang Jadi</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="productTotal" value="0" />
                            <input type="hidden" class="form-control" id="productTotalHidden" value="0" />
                        </div>
                    </div>
                </div>

                <div class="row" style="padding:10px 0">
                    <div class="col-md-6">
                        <label class="col-md-6">Modal Barang Satuan</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" disabled id="productModalPcs" value="0" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="col-md-6">Modal Barang Kodian</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" disabled id="productModalKodi" value="0" />
                        </div>
                    </div>
                </div>

                <div class="row" style="padding:10px 0">
                    <div class="col-md-6">
                        <label class="col-md-6">Harga Jual Barang Satuan</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="productPricePcs" value="0" />
                            <input type="hidden" class="form-control" id="productPricePcsHidden" value="0" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="col-md-6">Harga Jual Barang Kodian</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-disabled" id="productPriceKodi" value="0" />
                            <input type="hidden" class="form-control" id="productPriceKodiHidden" value="0" />
                        </div>
                    </div>
                </div>

                <div class="row" style="padding:10px 0">
                    <div class="col-md-6">
                        <label class="col-md-6">Estimasi Keuntungan</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="profit" disabled value="0" />
                        </div>
                    </div>

                    {{-- <div class="col-md-6 text-center">
                        <button class="btn btn-primary form-control" style="width:80%">Hitung</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        var productTotal = 0;
        var isPcs = 1;

        $('#materialPrice').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#materialPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#materialPriceHidden').val(number);

            countFund();
        });

        $('#upahJahit').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#upahJahit').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#upahJahitHidden').val(number);

            countFund();
        });

        $('#aksesoris').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#aksesoris').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#aksesorisHidden').val(number);

            countFund();
        });

        $('#transport').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#transport').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#transportHidden').val(number);

            countFund();
        });

        $('#productModalPcs').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productModalKodi').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productPricePcs').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productPricePcs').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#productPricePcsHidden').val(number);

            countFund();
        });

        $('#productPriceKodi').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productPriceKodi').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#productPriceKodiHidden').val(number);

            countFund();
        });

        $('#productTotal').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productTotal').keyup(function(){
            var number = $(this).val().split('.').join("");
            $('#productPriceKodiHidden').val(number);

            productTotal = number;

            countFund();
        });

        $('#profit').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productPricePcs').click(function(){
            $(this).removeClass("input-disabled");
            $("#productPriceKodi").addClass("input-disabled");
            isPcs = 1;
        });

        $('#productPriceKodi').click(function(){
            $(this).removeClass("input-disabled");
            $("#productPricePcs").addClass("input-disabled");
            isPcs = 0;
        });

        function countFund(){
            var fund = parseInt($('#materialPriceHidden').val()) + parseInt($('#upahJahitHidden').val()) + parseInt($('#aksesorisHidden').val()) + parseInt($('#transportHidden').val());

            var fund2 = parseInt(fund);
            var value = parseInt(productTotal);

            var fundPerPcs = fund/value;
            var fundPerKodi = fund/(value/20);

            $('#productModalPcs').val(fundPerPcs);
            $('#productModalKodi').val(fundPerKodi);

            $('#productModalPcs').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });

            $('#productModalKodi').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });

            if(isPcs == 1){
                var productPricePcs = $('#productPricePcsHidden').val();
                var profit = (parseInt(productPricePcs) - fundPerPcs) * value ;
            } else{
                var productPriceKodi = $('#productPriceKodiHidden').val();
                var profit = (parseInt(productPriceKodi) - fundPerKodi) * value ;
            }

            $('#profit').val(profit);

            $('#profit').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });
        }
	});
</script>

@endsection
