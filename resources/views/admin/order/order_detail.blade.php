<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sách</title>
	@include('layout.link')
</head>
<body>
	@include('admin.menu_admin')
	
	<div class="container mt-5">
		<h1 class="title-admin">Chi tiết đơn đặt hàng</h1>
	</div>

	<div class="container-fluid mt-5">
		<a class="btn btn-success text-white" href="{{ route('orders.index') }}">Danh sách đặt hàng</a>


		<table class="table table-bordered table-striped mt-3 mb-5">
			<tr class="text-center">
				<th>STT</th>
				<th>Mã đơn đặt hàng</th>
				<th>Tên sách</th>
				<th>Số lượng (Quyển)</th>
				<th>Giá (VNĐ)</th>
				<th>Thành tiền (VNĐ)</th>
			</tr>
			@php ($stt = 1)
			@foreach ($order_details as $order_detail)
			<tr>
				<td class="text-center">{{ $stt++ }}</td>
				<td class="text-center">{{ $order_detail->order->code }}</td>
				<td>{{ $order_detail->book->name }}</td>
				<td class="text-center">{{ $order_detail->amount }}</td>
				<td class="text-center">{{ number_format($order_detail->price) }}</td>
				<td class="text-center">{{ number_format($order_detail->amount * $order_detail->price) }}</td>
			</tr>
			@endforeach
			<tr class="font-weight-bold">
				<td colspan="5" class="text-right">Tổng tiền</td>
				<td class="text-center">{{ number_format($order_detail->order->total_money) }}</td>
			</tr>
		</table>
		<div class="text-center">
			{{ $order_details->links()}}
		</div>
	</div>

	@include('layout.script')
</body>
</html>