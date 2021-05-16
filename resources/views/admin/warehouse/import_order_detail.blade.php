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
		{{-- @if(session('notificationAdd'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationAdd') }}
            </div>
		@endif
		@if(session('notificationUpdate'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationUpdate') }}
            </div>
		@endif
		@if($errors->has('name') || $errors->has('img') || $errors->has('price') || $errors->has('sale') || $errors->has('content'))
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                Thêm thất bại!
            </div>
		@endif
		@if($errors->has('nameupdate') || $errors->has('imgupdate') || $errors->has('priceupdate') || $errors->has('saleupdate') || $errors->has('contentupdate'))
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                Sửa thất bại!
            </div>
		@endif
		@if(session('notificationDelete'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationDelete') }}
            </div>
		@endif --}}
		<h1 class="title-admin">Chi tiết đơn nhập hàng</h1>
	</div>

	<div class="container-fluid mt-5">
		<a class="btn btn-success text-white" href="{{ route('warehouses.create') }}">Nhập hàng</a>


		<table class="table table-bordered table-striped mt-3 mb-5">
			<tr class="text-center">
				<th>STT</th>
				<th>Tên sách</th>
				<th>Số lượng</th>
				<th>Giá</th>
				<th>Thành tiền</th>
				{{-- <th class="minw-140">Thao tác</th> --}}
			</tr>
			@php ($stt = 1)
			@foreach ($import_order_details as $import_order_detail)
			<tr>
				<td>{{ $stt++ }}</td>
				<td>{{ $import_order_detail->book->name }}</td>
				<td class="text-center">{{ $import_order_detail->amount }}</td>
				<td class="text-center">{{ $import_order_detail->price }}</td>
				<td class="text-center">{{ $import_order_detail->importOrder->total_money }}</td>
			</tr>
			@endforeach
			<tr class="font-weight-bold">
				<td colspan="4" class="text-right">Tổng tiền</td>
				<td class="text-center">{{ $import_order_detail->importOrder->total_money }}</td>
			</tr>
		</table>
		<div class="text-center">
			{{-- {{ $warehouses->appends(['key' => $request->key])->links()}} --}}
			{{ $import_order_details->links()}}
		</div>
	</div>

	@include('layout.script')
</body>
</html>