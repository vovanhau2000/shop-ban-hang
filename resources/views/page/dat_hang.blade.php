@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h1 class="inner-title">@if(Session::has('thongbao')){{Session::get('thongbao')}}@endif </h1>

			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang-chu')}}">Trang chủ</a> / <span>Đặt hàng</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="container">
		<div id="content">

			<form action="{{route('dathang')}}" method="post" class="beta-form-checkout" id="checkout-orders-form">
				<input type="hidden" name="_token" value="{{csrf_token()}}">

				<div class="row">
					<div class="col-sm-6">
						<h4>Điền thông của bạn</h4>
						<div class="space20">&nbsp;</div>
						<div class="form-block">
							<label for="name">Họ tên*</label>
							<input type="text"  name="name" placeholder="Họ tên" required>
						</div>
						<div class="form-block">
							<label>Giới tính </label>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%"><span style="margin-right: 10%">Nam</span>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nữ" style="width: 10%"><span>Nữ</span>

						</div>

						<div class="form-block">
							<label for="email">Email*</label>
							<input type="email" id="email" name="email" required placeholder="expample@gmail.com">
						</div>

						<div class="form-block">
							<label for="adress">Địa chỉ*</label>
							<input type="text" id="address" name="address" placeholder="Street Address" required>
						</div>


						<div class="form-block">
							<label for="phone">Điện thoại*</label>
							<input type="text" id="phone" name="phone" required>
						</div>

						<div class="form-block">
							<label for="notes">Ghi chú</label>
							<textarea id="notes" name="notes"></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="your-order">

							<div class="your-order-head"><h5>Đơn hàng của bạn</h5></div>


							<div class="your-order-body" style="padding: 0px 10px">
								<div class="your-order-item">
									<div>
									@if(Session::has('cart'))
									@foreach($product_cart as $cart  )
									<!--  one item	 -->
										<div class="media">
											<img width="25%" src="source/image/product/{{$cart['item']['image']}}" alt="" class="pull-left">
											<div class="media-body">
												<p class="font-large">{{$cart['item']['name']}}</p>
												<span class="color-gray your-order-info">Đơn giá:  {{ number_format($cart['item']['final_price'])   }}</span></span>
												<span class="color-gray your-order-info">Số lượng: {{ $cart['qty']   }}   </span>

											</div>
										</div>
									<!-- end one item -->
									@endforeach
									@endif

									</div>
									<div class="clearfix"></div>
								</div>


								<div class="your-order-item">
									<div class="pull-left"><p class="your-order-f18">Tạm tính:</p></div>
									<div class="pull-right">
										<h5 class="color-black" id="payment-temp" data-payment-temp-price="@if(Session::has('cart')){{($totalPrice)}} @else 0 @endif"> @if(Session::has('cart')){{number_format($totalPrice )}}  @else 0   @endif      đồng</h5>
									</div>
									<div class="clearfix"></div>
								</div>


							</div>

							<div class="your-order-head"><h5> Chọn hình thức giao hàng</h5></div>

							<div class="your-order-body">
								<ul	class="payment_methods methods">
									<li class="payment_method_bacs">
										<input class="payment-method" data-payment-method-price="20000" type="radio" class="input-radio" name="delivery_method"  value="VTP20000" checked="checked" data-order_button_text="">
										<label for="payment_method_bacs">Giao hàng Viettel Post 20.000 VND </label>

									</li>
									<li class="payment_method_bacs">
										<input class="payment-method" data-payment-method-price="23000" type="radio" class="input-radio" name="delivery_method"  value="J&T23000"  data-order_button_text="">
										<label for="payment_method_bacs">Giao hàng J&T 23.000 VND </label>

									</li>
									<li class="payment_method_bacs">
										<input class="payment-method" data-payment-method-price="18000" type="radio" class="input-radio" name="delivery_method"  value="GHTK18000"  data-order_button_text="">
										<label for="payment_method_bacs">Giao hàng Tiết Kiệm 18.000 VND</label>

									</li>



								</ul>
							</div>

							<div class="your-order-item">
									<div class="pull-left"><p class="your-order-f18">Tổng tiền:</p></div>
									<div class="pull-right">
										<h5 class="color-black" id="orders-total-price"></h5>
									</div>
									<div class="clearfix"></div>
								</div>
</br>
							<div class="your-order-head"><h5>Hình thức thanh toán</h5></div>

							<div class="your-order-body">
								<ul class="payment_methods methods">
									<li class="payment_method_bacs">
										<input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="COD" checked="checked" data-order_button_text="">
										<label for="payment_method_bacs">Thanh toán khi nhận hàng </label>
										<div class="payment_box payment_method_bacs" style="display: block;">
											Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho nhân viên giao hàng
										</div>
									</li>



								</ul>
							</div>

							<div class="text-center"><button type="submit" class="beta-btn primary" href="#">Đặt hàng <i class="fa fa-chevron-right"></i></button></div>
						</div> <!-- .your-order -->
					</div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        function createHiddenField() {
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "orders_payment_method_price");
            input.setAttribute("id", "orders_payment_method_price");
            let deliveryPrice = parseInt($("input[name=delivery_method]:checked").attr("data-payment-method-price") ?? 0);
            input.setAttribute("value", deliveryPrice);
            document.getElementById("checkout-orders-form").appendChild(input);


            let paymentTemp = $('#payment-temp').attr("data-payment-temp-price");
            paymentTemp = parseInt(paymentTemp.trim());
            var input2 = document.createElement("input");
            input2.setAttribute("type", "hidden");
            input2.setAttribute("name", "orders_total_price");
            input2.setAttribute("id", "orders_total_price");
            input2.setAttribute("value", paymentTemp + deliveryPrice);
            document.getElementById("checkout-orders-form").appendChild(input2);

        }
        $(document).ready(function () {
            let totalPrice = 0;
            let paymentTemp = $('#payment-temp').attr("data-payment-temp-price");
            paymentTemp = paymentTemp.trim();

            let deliveryPrice = $("input[name=delivery_method]:checked").attr("data-payment-method-price") ?? 0;
            let html = parseInt(paymentTemp) + parseInt(deliveryPrice) + 'đ';

            $('#orders-total-price').html(html);

            createHiddenField();


            $(".payment-method").click(function () {
                let deliveryPrice = parseInt($(this).attr("data-payment-method-price"));
                let paymentTemp = $('#payment-temp').attr("data-payment-temp-price");
                paymentTemp = parseInt(paymentTemp.trim());
                let html = paymentTemp + deliveryPrice + 'đ';

                $('#orders-total-price').html(html);
                $('#orders_payment_method_price').val(deliveryPrice);
                $('#orders_total_price').val(paymentTemp + deliveryPrice);


            });
        });
    </script>
	@endsection

