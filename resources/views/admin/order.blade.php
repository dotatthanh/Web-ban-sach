<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ $title }}</title>
	@include('layout.link')
</head>
<body>
	@include('admin.menu_admin')
	
	<div class="container mt-5">
		@if(session('notificationAdd'))
			<span class="alert alert-success mt-2 d-block text-center" role="alert">{{ session('notificationAdd') }}</span>
		@endif
		@if($errors->has('title') || $errors->has('summary') || $errors->has('img') || $errors->has('content'))
			<span class="alert alert-danger mt-2 d-block text-center" role="alert">Thêm sách thất bại!</span>
		@endif
		@if($errors->has('titleupdate') || $errors->has('summaryupdate') || $errors->has('imgupdate') || $errors->has('contentupdate'))
			<span class="alert alert-danger mt-2 d-block text-center" role="alert">Sửa sách thất bại!</span>
		@endif
		
		<h1 class="title-admin"><span>Danh sách</span> Đơn hàng</h1>
	</div>

	<div class="container-fluid mt-5">
		<form action="{{ route('orders.index') }}" method="GET" class="row mt-3">
			<div class="col-3">
				<input type="text" name="key" placeholder="Email, Số điện thoại, Địa chỉ" class="form-control w-100">
			</div>
			<div class="col-2">
				<button class="btn btn-success w-75">Tìm kiếm</button>
			</div>
		</form>
		<table class="table table-bordered table-striped mt-3 mb-5">
			<tr class="text-center">
				<th>STT</th>
				<th>Ngày</th>
				<th>Họ và tên</th>
				<th>Email</th>
				<th>Số điện thoại</th>
				<th>Địa chỉ</th>
				<th>Đơn hàng</th>
				<th>Giá</th>
				<th>Số lượng</th>
			</tr>
			<?php $stt = 1; ?>
			@foreach ($customers as $customer)
			<tr>
				<td class="text-center">{{ $stt++ }}</td>
				<td>{{ date_format($customer->created_at, "d/m/Y") }}</td>
				<td>{{ $customer->name }}</td>
				<td>{{ $customer->email }}</td>
				<td>{{ $customer->phone }}</td>
				<td>{{ $customer->address }}</td>
				<td class="p-0">
					<table class="w-100 table-borderless">
						@foreach ($customer->orders as $order)
							<tr class="bg-none"><td class="border-0 white-space">{{$order->book->name}}
							
							</td></tr>
						@endforeach
					</table>
				</td>
				<td class="p-0">
					<table class="w-100 table-borderless">
						@foreach ($customer->orders as $order)
							<tr class="bg-none"><td class="border-0 text-center white-space">{{ number_format($order->price, 0, ",", ".") }} ₫<br></td></tr>
						@endforeach
					</table>
				</td>
				<td class="p-0">
					<table class="w-100 table-borderless">
						@foreach ($customer->orders as $order)
							<tr class="bg-none"><td class="border-0 text-center">{{ $order->amount }}<br></td></tr>
						@endforeach
					</table>
				</td>
			</tr>
			@endforeach
		</table>
		<div class="text-center">
			{{ $customers->appends(['key' => $request->key])->links() }}
		</div>
	</div>

	


	@include('layout.script')
</body>
</html>