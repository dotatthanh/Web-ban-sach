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
		<h1 class="title-admin"><span>Danh sách</span> Nhập hàng</h1>
	</div>

	<div class="container-fluid mt-5">
		<a class="btn btn-success text-white" href="{{ route('warehouses.create') }}">Nhập hàng</a>
		{{-- <form action="{{ route('warehouses.index') }}" method="GET" class="row mt-3">
			<div class="col-3">
				<input type="text" name="key" placeholder="Tên sách" class="form-control w-100">
			</div>
			<div class="col-2">
				<button class="btn btn-success w-75">Tìm kiếm</button>
			</div>
		</form> --}}
		<table class="table table-bordered table-striped mt-3 mb-5">
			<tr class="text-center">
				<th>STT</th>
				<th>Người nhập</th>
				<th>Tên sách</th>
				<th>Nhà cung cấp</th>
				<th>Số lượng</th>
				<th>Giá</th>
				<th>Ngày nhập</th>
				{{-- <th class="minw-140">Thao tác</th> --}}
			</tr>
			<?php $stt = 1; ?>
			@foreach ($warehouses as $warehouse)
			<tr>
				<td class="text-center">{{ $stt++ }}</td>
				<td>{{ $warehouse->user->name }}</td>
				<td>{{ $warehouse->book->name }}</td>
				<td>{{ $warehouse->supplier->name }}</td>
				<td class="text-center">{{ $warehouse->amount }}</td>
				<td class="text-center">{{ number_format($warehouse->price, 0, ',', '.') }}₫</td>
				<td class="text-center">{{ date_format($warehouse->created_at, 'd/m/Y') }}</td>
				{{-- <td class="text-center">
					<button class="btn btn-warning text-white" data-toggle="modal" data-target="#edit_book{{ $warehouse->id }}">Sửa</button>
					<form action="{{ route('books.destroy', $warehouse->id) }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
					</form>
				</td> --}}
			</tr>
			@endforeach
		</table>
		<div class="text-center">
			{{-- {{ $warehouses->appends(['key' => $request->key])->links()}} --}}
			{{ $warehouses->links()}}
		</div>
	</div>

	@include('layout.script')
</body>
</html>