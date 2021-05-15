<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ $title }}</title>
	@include('layout.link')
</head>
<body>
	
	<header class="header">
		<div class="container">
			<div class="brand">
				<a href="#" title=""><i class="icon fa fa-facebook" aria-hidden="true"></i></a>
				<a href="#" title=""><i class="icon fa fa-twitter" aria-hidden="true"></i></a>
				<a href="#" title=""><i class="icon fa fa-google-plus" aria-hidden="true"></i></a>
				<a href="#" title=""><i class="icon fa fa-youtube" aria-hidden="true"></i></a>
			</div>
			<div class="search">
				<form action="{{ route('page.search') }}" method="GET">
					<input type="text" name="keyall" placeholder="Bạn muốn tìm gì?">
					<button type="submit">
						<img title="" src="{{ asset('images/timkiem.png') }}" alt="">
					</button>
				</form>

				<a href="#" title="" class="cart" data-toggle="modal" data-target="#cart">
					<img title="" src="{{ asset('images/cart.png') }}" alt="">
				</a>
			</div>


			<div class="row header-menu">
				<div class="col-6 col-md-4 col-sm-4 col-lg-4">
					<div class="logo">
						<a href="{{ route('pages.index') }}" title="">
							<img title="" src="{{ asset('images/logo.png') }}" alt="">
						</a>
					</div>
				</div>
				<div class="col-6 col-md-8 col-sm-8 col-lg-8">
					<div class="menu">
						<button class="btn-menu">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</button>
						<ul>
							<li><a href="{{ route('pages.index') }}" title="">Trang chủ</a></li>
							<li><a href="#" title="">Danh mục sách</a>
								<ul>
									@foreach ($categories as $category)
									<li><a href="{{ route('page.category', $category->id) }}" title="">{{ $category->name }}</a></li>
									@endforeach
								</ul>
							</li>
							<li><a href="{{ route('page.tophighlight') }}" title="">Top nổi bật</a></li>
							<li><a href="{{ route('page.forum') }}" title="">Diễn đàn</a></li>
							<li><a href="{{ route('page.contact') }}" title="">Liên hệ</a></li>
							@if (auth()->guard('customer')->user())
								<li><a href="{{ route('user.profile') }}">Xin chào: {{ auth()->guard('customer')->user()->name }}</a></li>
							@else
								<li><a href="{{ route('user.login') }}">Tài khoản</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Modal Cart -->
	<div class="modal modal-cart fade" id="cart">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close close-cart d-block" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="shop-cart">
						<div class="container">
							<div class="cart">
								<h2>1. Giỏ hàng của bạn</h2>
								<table class="w-100">
									<thead>
										<tr>
											<th class="title-col-product">Sản phẩm</th>
											<th class="title-col-price">Giá</th>
											<th class="title-col-sl">Số lượng</th>
											<th class="title-col-sale">Thao tác</th>
											<th class="title-col-pay">Thanh toán</th>
										</tr>
									</thead>

									<tbody>
										<!-- <form action="" method="POST"></form>
											@csrf -->
											@if(session('notificationUpdate'))
						                        <div class="alert alert-danger text-center mt-3">
						                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						                            {{ session('notificationUpdate') }}
						                        </div>
						                    @endif
											@foreach ($content as $cart)
											<tr>
												<td  class="content-product" data-content="Sản phẩm">
													<a href="" class="c-img w-50 p-80">
													<img src="{{ asset('storage/'.$cart->options['img']) }}" alt="">
													</a>
													<div class="info-book">
														<span>{{ $cart->name }}</span>
														<!-- <p>Rosie Nguyễn</p> -->
													</div>
												</td>
												<td  class="content-price align-middle" data-content="Giá">
													<p>{{ number_format($cart->price, 0, ",", ".") }} đ</p>
												</td>
												<td  class="content-sl align-middle" data-content="Số lượng">
													<!-- <form action="#"> -->
													<form action="{{ route('page.update-product-cart', ['rowid' => $cart->rowId, 'qty' => $cart->qty]) }}" method="GET">
														<input type="number" name="qty" class="qty" min="1" value="{{ $cart->qty }}">
														<input type="number" name="id" value="{{ $cart->id }}" hidden="">
													<!-- </form> -->
												</td>
												<td  class="content-sale align-middle" data-content="Thao tác" id="{{ $cart->id }}">
													<!-- <a href="#" title="" class="updatecart" id="{{ $cart->rowId }}" data-id="{{ $cart->id }}">
														<i class="fa fa-circle-o-notch" aria-hidden="true"></i>
													</a> -->
														<button class="updatecart" id="{{ $cart->rowId }}" data-id="{{ $cart->id }}">
															<i class="fa fa-circle-o-notch" aria-hidden="true"></i>
														</button>
													</form>
													<a href="{{ route('page.del-product-cart', ['id' => $cart->rowId]) }}" class="delete-cart" id="{{ $cart->rowId }}">
														<i class="fa fa-trash" aria-hidden="true"></i>
													</a>
												</td>
												<td  class="content-pay align-middle" data-content="Thanh toán">
													<!-- <div class="tamtinh">
														<p>Tạm tính:</p> <span>{{ $total }} VND</span>
													</div> -->
													<div class="thanhtien">
														<p>Thành tiền:</p> <span>{{ number_format($cart->price * $cart->qty, 0, ",", ".") }} VNĐ</span>
													</div>
												</td>							
											</tr>
										@endforeach
									</tbody>
								</table>
										@if(session('notification'))
					                        <div class="alert alert-danger text-center mt-3">
					                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					                            {{ session('notification') }}
					                        </div>
					                    @endif
								<div class="action">
									<a href="{{ route('page.del-cart') }}" title="" class="del-cart">Xóa</a>
									<!-- <a href="">Để mua sau</a> -->
									<!-- <button class="buying">Tiếp tục mua hàng</button> -->
									<a href="#order" title="" class="to-pay">Tiến hành thanh toán</a>
								</div>
							</div>
							<div class="pay d-none">
								<h2 id="order">2. Tiến hành đặt hàng</h2>
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#info_customer"><span>1</span>Thông tin khách hàng</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#infor_order"><span>2</span>Thông tin giao hàng</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#pay"><span>3</span>Thanh toán và hoàn tất</a>
									</li>
								</ul>

								<div class="tab-content">
								    <div id="info_customer" class="container tab-pane active s-content"><br>
								    	<form action="{{ route('page.order') }}" method="POST" class="row">
								    		@csrf
							      			<div class="col-lg-6 col-md-6 col-sm-12 col-12 form-info">
							      				<p>Địa chỉ khách hàng</p>
						      					<div class="w-100">
							      					<label>Họ và tên</label>
							  						<input required type="text" name="name" value="{{ old('name') }}">
							  						@if($errors->has('name'))
														<span class="text-danger d-block mt-2">{{ $errors->first('name') }}</span>
													@endif
						      					</div>
						      					<div class="email">
							      					<label>Email</label>
							  						<input required type="email" name="email" value="{{ old('email') }}">
							  						@if($errors->has('email'))
														<span class="text-danger d-block mt-2">{{ $errors->first('email') }}</span>
													@endif
						      					</div>
						      					<div class="sdt">
							      					<label>Số điện thoại</label>
							  						<input required type="number" name="phone" value="{{ old('phone') }}">
							  						@if($errors->has('phone'))
														<span class="text-danger d-block mt-2">{{ $errors->first('phone') }}</span>
													@endif
						      					</div>
						      					<div class="diachi">
							      					<label>Địa chỉ (Tỉnh/thành phố)</label>
							  						<input required type="text" name="address" value="{{ old('address') }}">
							  						@if($errors->has('address'))
														<span class="text-danger d-block mt-2">{{ $errors->first('address') }}</span>
													@endif
						      					</div>
							      			</div>
							      			<div class="col-lg-6 col-md-6 col-sm-12 col-12 order">
							      				<div class="info-order">
							      					<h5>ĐƠN HÀNG</h5>
							      					@foreach ($content as $product)
								      				<p>{{ $product->name }}</p>
								      				<span>GIÁ: {{ $product->price }} ₫</span> <span class="d-block">Số lượng: {{ $product->qty }}</span>
								      				@endforeach
							      				</div>

							      				<!-- <div class="cost">
							      					<div>
							      						<p>Tạm tính</p><span>60.000đ</span>
							      					</div>
							      					<div>
														<p>Phí vận chuyển</p><span>10,000đ</span>
							      					</div>
							      				</div> -->

												<div class="pay-methods">
													<p>Tổng cộng:</p><span>{!! $total !!} ₫</span>
													<div>
														<input type="radio" name="checkbox" id="transfer" value="value">
														<label for="transfer" class="lblpay">Chuyển khoản ngân hàng</label>
														<p>Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng Mã đơn hàng của bạn trong phần Nội dung thanh toán. Đơn hàng sẽ đươc giao sau khi tiền đã chuyển.</p>
													</div>
													<div>
														<input type="radio" name="checkbox" id="pay-down" value="" checked>
														<label for="pay-down" class="lblpay">Trả tiền mặt khi nhận hàng</label>
													</div>
												</div>

												<button type="submit" class="btn-order w-100 dat-hang">ĐẶT HÀNG</a>
							      			</div>
										</form>
								    </div>
								    <div id="infor_order" class="container tab-pane fade s-content"><br>
										<p>
											- Đơn hàng sẽ được giao trực tiếp đến khách hàng.
										</p>
										<p>
											- Giao hàng trên toàn toàn quốc.
										</p>
										<p>
											- Đổi trả trực tiếp nếu có lỗi sản phẩm.
										</p>
								    </div>
								    <div id="pay" class="container tab-pane fade s-content"><br>
								      	<p>- Khách hàng ký nhận hàng trực tiếp xác nhận đã nhận đơn hàng.</p>
								      	<p>- Khách hàng thanh toán trực tiếp sau khi nhận được đơn hàng.</p>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Menu Mobile -->
	<div class="menu-mb">
		<button class="btn-close"><i class="fa fa-close" aria-hidden="true"></i></button>
		<div class="search">
			<form action="#">
				<input type="text" placeholder="Bạn muốn tìm gì?">
				<a href="#" title="">
					<img title="" src="{{ asset('images/timkiem.png') }}" alt="">
				</a>
			</form>
		</div>
		<ul>
			<li><a href="#" title="">Trang chủ</a></li>
			<li><a href="#" title="">Danh mục sách</a>
				<ul>
					<li><a href="#" title="">Sách hay</a></li>
					<li><a href="#" title="">Sách nổi bật</a></li>
					<li><a href="#" title="">Sách bán chạy</a></li>
					<li><a href="#" title="">Sách tiếng anh</a></li>
					<li><a href="#" title="">Sách tiếng việt</a></li>
				</ul>
			</li>
			<li><a href="#" title="">Top nổi bật</a></li>
			<li><a href="#" title="">Diễn đàn</a></li>
			<li><a href="#" title="">Liên hệ</a></li>
			<li><a href="{{ route('user.login') }}">Tài khoản</a></li>
		</ul>
	</div>

	<!-- Slider -->
	<div class="slider">
		<a class="c-img">
			<img title="" class="img-responsive" src="{{ asset('images/slider.jpg') }}" alt="">
		</a>
		<a class="c-img">
			<img title="" class="img-responsive" src="{{ asset('images/slider1.jpg') }}" alt="">
		</a>
		<a class="c-img">
			<img title="" class="img-responsive" src="{{ asset('images/slider.jpg') }}" alt="">
		</a>
		<a class="c-img">
			<img title="" class="img-responsive" src="{{ asset('images/slider1.jpg') }}" alt="">
		</a>
	</div>

	<!-- Phone -->
	<a href="tel:0123456789" title="" class="btn-call">
		<span><i class="fa fa-phone"></i></span>
	</a>

	<!-- Back-to-top -->
	<button class="back-to-top"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
	
	

	@yield('content')

	

	<!-- Vận chuyển - giao hàng -->
	<div class="transport">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-lg-12">
					<h2 class="title-transport">Vận chuyển - giao hàng</h2>
				</div>
				<div class="col-md-6 col-sm-12 col-lg-3 item-transport">
					<img title="" src="{{ asset('images/lock.png') }}" alt="">
					<div class="text-transport">
						<h4>Bảo mật</h4>
						<p>Cam kết bảo mật 100% thông tin cá nhân và thanh toán của khách hàng</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-lg-3 item-transport">
					<img title="" src="{{ asset('images/doitra.png') }}" alt="">
					<div class="text-transport">
						<h4>Đổi trả</h4>
						<p>Đổi trả miễn phí khi sản phẩm bị lỗi trong khâu sản xuất và quá trình vận chuyển</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-lg-3 item-transport">
					<img title="" src="{{ asset('images/giaohang.png') }}" alt="">
					<div class="text-transport">
						<h4>Giao hàng</h4>
						<p>giao hàng miễn phí đối với đơn hàng từ 150.000đ trở lên khi ở Hà Nội, và 250.000đ trên cả nước</p>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-lg-3 item-transport">
					<img title="" src="{{ asset('images/sach.png') }}" alt="">
					<div class="text-transport">
						<h4>Hơn 60.000 tự sách</h4>
						<p>Hơn 60.000 tự sách Tiếng Việt và Tiếng Anh tất cả các thể loại, cập nhật sách mới mỗi ngày.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="menu-transport">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-12 col-sm-12 col-lg-12">
						<ul>
							<li><a href="#" title="">Giới thiệu</a></li>
							<li><a href="#" title="">Chính sách bảo mật</a></li>
							<li><a href="#" title="">Điều khoản sử dụng</a></li>
							<li><a href="#" title="">Điều khoản mua bán hàng hóa</a></li>
							<li><a href="#" title="">Quy chế sàn giao dịch</a></li>
						</ul>
						<div class="brand-transport">
							<a href="#" title=""><i class="icon-transport fa fa-facebook" aria-hidden="true"></i></a>
							<a href="#" title=""><i class="icon-transport fa fa-twitter" aria-hidden="true"></i></a>
							<a href="#" title=""><i class="icon-transport fa fa-google-plus" aria-hidden="true"></i></a>
							<a href="#" title=""><i class="icon-transport fa fa-youtube" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<div class="foot">
			<div class="container">
				<div class="row">
					<div class="col-6 col-md-6 col-sm-6 col-lg-3 foot-index bold">
						<h3>HỖ TRỢ KHÁCH HÀNg</h3>
						<ul>
							<li><a href="#" title="">Liên hệ với chúng tôi</a></li>
							<li><a href="#" title="">Tư vấn chọn mẫu</a></li>
							<li><a href="#" title="">Trung tâm hỗ trợ</a></li>
							<li><a href="#" title="">Chính sách bảo mật</a></li>
							<li><a href="#" title="">Hình thức thanh toán</a></li>
							<li><a href="#" title="">Hỗ trợ</a></li>
						</ul>
					</div>
					<div class="col-6 col-md-6 col-sm-6 col-lg-3 foot-index">
						<h3>TẤT CẢ NGHÀNH  NGHỀ</h3>
						<ul>
							<li><a href="#" title="">Thiết bị công nghiệp</a></li>
							<li><a href="#" title="">Thời trang</a></li>
							<li><a href="#" title="">Trang sức</a></li>
							<li><a href="#" title="">Thể thao - dịch vụ</a></li>
							<li><a href="#" title="">Bất động sản</a></li>
							<li><a href="#" title="">Thủ công mỹ nghệ</a></li>
							<li><a href="#" title="">Khác - Tổng hợp</a></li>
						</ul>
					</div>
					<div class="col-6 col-md-6 col-sm-6 col-lg-3 foot-index">
						<h3>KIỂU GIAO DIỆN</h3>
						<ul>
							<li><a href="#" title="">Giới thiệu dịch vụ</a></li>
							<li><a href="#" title="">Giới thiệu sản phẩm</a></li>
							<li><a href="#" title="">Bán hàng - Tin tức</a></li>
							<li><a href="#" title="">Langding page</a></li>
						</ul>
					</div>
					<div class="col-6 col-md-6 col-sm-6 col-lg-3 foot-index bold">
						<h3>Mẫu thiết kế</h3>
						<ul>
							<li><a href="#" title="">Web doanh nghiệp</a></li>
							<li><a href="#" title="">Web bán hàng</a></li>
							<li><a href="#" title="">Landing Page</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
			<p>© Copyright 2017. Designed by Tech5s - Bản quyền thiết kế web thuộc về Tech5s</p>
		</div>
	</footer>


	<!-- Modal Thông báo add-to-cart -->
	<div class="modal fade" id="notice-add-to-cart">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-uppercase h4 font-weight-bold">Thông báo</h4>
					<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
				</div>

				<!-- Modal body -->
				<div class="modal-body text-uppercase">
					Bạn vừa thêm 1 sản phầm vào giỏ hàng
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-modal-notification" data-dismiss="modal" data-toggle="modal" data-target="#cart">Đặt hàng ngay</button>
					<button type="button" class="btn btn-danger btn-modal-notification" data-dismiss="modal">Tiếp tục mua hàng</button>
				</div>

			</div>
		</div>
	</div>

	<!-- Modal Thông báo đặt hàng -->
	<div class="modal fade" id="notice-order">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-uppercase h4 font-weight-bold">Thông báo</h4>
					<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
				</div>

				<!-- Modal body -->
				<div class="modal-body text-uppercase">
					@if(session('notificationOrder'))
		                {{ session('notificationOrder') }}
					@endif
					@if(session('notificationOrderFail'))
		                {{ session('notificationOrderFail') }}
					@endif
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					@if(session('notificationOrder'))
						<button type="button" class="btn btn-danger btn-modal-notification1" data-dismiss="modal">Tiếp tục mua hàng</button>
					@endif
					@if(session('notificationOrderFail'))
						<button type="button" class="btn btn-danger btn-modal-notification1" data-dismiss="modal">Mua hàng</button>
					@endif
				</div>
			</div>
		</div>
	</div>

	@include('layout.script')

	<script>
		$(document).ready(function() {
			$('.close-cart').click(function(event) {
				$('#cart').removeClass('show d-block p-r-17');
				$('body').removeClass('modal-open');
			});
			$('.btn-modal-notification').click(function(event) {
				$('#notice-add-to-cart').removeClass('show d-block p-r-17');
				$('body').removeClass('modal-open');
				$("html, body").animate({ scrollTop: $('.slider').height() }, 500);
			});
			$('.btn-modal-notification1').click(function(event) {
				$('#notice-order').removeClass('show d-block p-r-17');
				$('body').removeClass('modal-open');
				$("html, body").animate({ scrollTop: $('.slider').height() }, 500);
			});
			$('.to-pay').click(function(event) {
				$('.pay').removeClass('d-none').addClass('d-block');
			});
		});

		jQuery('.delete-cart').click(function() {
            sessionStorage.setItem('.delete-cart',true);
        });

        jQuery('.del-cart').click(function() {
            sessionStorage.setItem('.del-cart',true);
        });

        jQuery('.updatecart').click(function() {
            sessionStorage.setItem('.updatecart',true);
        });

        jQuery('.add-to-cart').click(function() {
            sessionStorage.setItem('.add-to-cart',true);
        });

        jQuery('.dat-hang').click(function() {
            sessionStorage.setItem('.dat-hang',true);
        });


        jQuery( function () {
            if ( sessionStorage.getItem('.delete-cart') ) {
                $('#cart').addClass('show d-block p-r-17');
                $('body').addClass('modal-open');
                sessionStorage.removeItem('.delete-cart');
            }
            if ( sessionStorage.getItem('.updatecart') ) {
                $('#cart').addClass('show d-block p-r-17');
                $('body').addClass('modal-open');
                sessionStorage.removeItem('.updatecart');
            }
            if ( sessionStorage.getItem('.del-cart') ) {
                $('#cart').addClass('show d-block p-r-17');
                $('body').addClass('modal-open');
                sessionStorage.removeItem('.del-cart');
            }
            if ( sessionStorage.getItem('.add-to-cart') ) {
                $('#notice-add-to-cart').toggleClass('show d-block p-r-17');
                $('body').addClass('modal-open');
                sessionStorage.removeItem('.add-to-cart');
            }
            if ( sessionStorage.getItem('.dat-hang') ) {
                $('#notice-order').toggleClass('show d-block p-r-17');
                $('body').addClass('modal-open');
                sessionStorage.removeItem('.dat-hang');
            }
        });

        // Update cart
  //       $('.updatecart').click(function(event) {
		// 	let rowid = $(this).attr('id');
		// 	let qty = $(this).parent().parent().find('.qty').val();
		// 	let id = $(this).attr('data-id');
		// 	let token = $("input[name='_token']").val();
		// 	$.ajax({
		// 		url: '{{ route("page.update-product-cart", ["id" =>'+rowid+', "qty" => '+qty+']) }}',
		// 		type: 'GET',
		// 		cache: false,
		// 		data: {
		// 			"_token": token,
		// 			"id": rowid,
		// 			"qty": qty,
		// 			"idsp": id
		// 		},
		// 		success:function (data){
		// 			if (data == "oke") {
		// 				window.location = ""
		// 			}
		// 		}
		// 	});
		// });
	</script>

	@yield('script')

</body>
</html>