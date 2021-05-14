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
		<button class="btn btn-success" data-toggle="modal" data-target="#add_book">Nhập hàng</button>
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
				<th>Nhà cung cấp</th>
				<th>Tên tác giả</th>
				<th>Thể loại</th>
				<th>Danh mục</th>
				<th>Đơn giá</th>
				<th>Sale</th>
				<th class="minw-140">Thao tác</th>
			</tr>
			<?php $stt = 1; ?>
			@foreach ($books as $book)
			<tr>
				<td class="text-center">{{ $stt++ }}</td>
				<td>{{ $book->name }}</td>
				<td class="text-center"><img class="maxw-90" src="{{ asset('storage/'.$book->img) }}" alt=""></td>
				<td>{{ $book->supplier->name }}</td>
				<td>
					@foreach ($book->authors as $author)
						- {{ $author->name }}<br>
					@endforeach
				</td>
				<td>
					@foreach ($book->types as $type)
						- {{ $type->name }}<br>
					@endforeach
				</td>
				<td>
					@foreach ($book->categories as $category)
						- {{ $category->name }}<br>
					@endforeach
				</td>
				<td class="text-center">{{ number_format($book->price, 0, ',', '.') }}₫</td>
				<td class="text-center">{{ $book->sale }}%</td>
				<td class="text-center">
					{{-- <button class="btn btn-warning text-white" data-toggle="modal" data-target="#edit_book{{ $book->id }}">Sửa</button>
					<form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
					</form> --}}
				</td>
			</tr>
			@endforeach
		</table>
		{{-- <div class="text-center">
			{{ $books->appends(['key' => $request->key])->links()}}
		</div> --}}
	</div>

	@include('layout.script')
</body>
</html>