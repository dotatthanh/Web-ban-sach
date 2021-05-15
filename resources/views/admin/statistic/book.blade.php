<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Thống kê sách</title>
	@include('layout.link')
</head>
<body>
	@include('admin.menu_admin')
	
	<div class="container mt-5">
		<h1 class="title-admin"><span>Thống kê</span> Sách</h1>
	</div>

	<div class="container-fluid mt-5">
		{{-- <a class="btn btn-success text-white" href="{{ route('warehouses.create') }}">Nhập hàng</a> --}}
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
				<th>Tên sách</th>
				<th>Ảnh</th>
				<th>Số lượng</th>
				{{-- <th>Giá</th> --}}
			</tr>
			<?php $stt = 1; ?>
			@foreach ($books as $book)
			<tr>
				<td class="text-center">{{ $stt++ }}</td>
				<td>{{ $book->name }}</td>
				<td class="text-center"><img class="maxw-90" src="{{ asset('storage/'.$book->img) }}" alt=""></td>
				<td class="text-center">{{ $book->amount }}</td>
				{{-- <td class="text-center">{{ number_format($book->price, 0, ',', '.') }}₫</td> --}}
			</tr>
			@endforeach
		</table>
		<div class="text-center">
			{{-- {{ $books->appends(['key' => $request->key])->links()}} --}}
			{{ $books->links()}}
		</div>
	</div>

	@include('layout.script')
</body>
</html>