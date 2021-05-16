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
		@if(session('notificationAdd'))
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
		@endif
		<h1 class="title-admin"><span>Danh sách</span> Sách</h1>
	</div>

	<div class="container-fluid mt-5">
		<button class="btn btn-success" data-toggle="modal" data-target="#add_book">Thêm sách</button>
		<form action="{{ route('books.index') }}" method="GET" class="row mt-3">
			<div class="col-3">
				<input type="text" name="key" placeholder="Tên sách" class="form-control w-100">
			</div>
			<div class="col-2">
				<button class="btn btn-success w-75">Tìm kiếm</button>
			</div>
		</form>
		<table class="table table-bordered table-striped mt-3 mb-5">
			<tr class="text-center">
				<th>STT</th>
				<th>Tên sách</th>
				<th>Ảnh</th>
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
					<button class="btn btn-warning text-white" data-toggle="modal" data-target="#edit_book{{ $book->id }}">Sửa</button>

					<!-- Modal Sửa -->
					<div class="modal fade text-left" id="edit_book{{ $book->id }}">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">

								<!-- Modal Header -->
								<div class="modal-header">
									<h4 class="modal-title">Sửa sách</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<!-- Modal body -->
								<form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
									@csrf
									@method('PUT')
									<div class="modal-body container">
										<div class="row">
											<div class="col-3 mb-3">Tên sách:</div>
											<div class="col-9 mb-3">
												<input type="text" name="nameupdate" placeholder="Tên sách" class="form-control w-100" value="{{ $book->name }}">
												@if($errors->has('nameupdate'))
													<span class="text-danger d-block mt-2">{{ $errors->first('nameupdate') }}</span>
												@endif
											</div>

											<div class="col-3 mb-3">Ảnh</div>
											<div class="col-9 mb-3">
												<input type="file" name="imgupdate" class="form-control" value="{{ asset('storage/'.$book->img) }}">
												@if($errors->has('imgupdate'))
													<span class="text-danger d-block mt-2">{{ $errors->first('imgupdate') }}</span>
												@endif
											</div>

											<div class="col-3 mb-3">Tác giả:</div>
											<div class="col-9 mb-3">
												<select name="authorupdate[]" id="" class="form-control select2 w-100" multiple="multiple">
													@foreach ($authors as $author)
													<option value="{{ $author->id }}"
														@foreach ($book->authors as $value)
															{{ $value->id == $author->id ? 'selected' : ''}}
														@endforeach
														>{{ $author->name }}</option>
													@endforeach
												</select>
											</div>

											<div class="col-3 mb-3">Thể loại:</div>
											<div class="col-9 mb-3">
												<select name="typeupdate[]" id="" class="form-control select2 w-100" multiple="multiple">
													@foreach ($types as $type)
													<option value="{{ $type->id }}"
														@foreach ($book->types as $value)
															{{ $value->id == $type->id ? 'selected' : ''}}
														@endforeach
														>{{ $type->name }}</option>
													@endforeach
												</select>
											</div>

											<div class="col-3 mb-3">Danh mục:</div>
											<div class="col-9 mb-3">
												<select name="categoryupdate[]" id="" class="form-control select2 w-100" multiple="multiple">
													@foreach ($categories as $category)
														<option value="{{ $category->id }}"
															@foreach ($book->categories as $value)
																{{ $value->id == $category->id ? 'selected' : ''}}
															@endforeach
														>{{ $category->name }}</option>
													@endforeach
												</select>
											</div>

											<div class="col-3 mb-3">Đơn giá:</div>
											<div class="col-7 mb-3 ">
												<input name="priceupdate" type="number" min="1" class="form-control" value="{{ $book->price }}">
												@if($errors->has('priceupdate'))
													<span class="text-danger d-block mt-2">{{ $errors->first('priceupdate') }}</span>
												@endif
											</div>
											<div class="col-2 mb-3 ">
												<input type="text" class="form-control text-center" value="VNĐ" disabled>
											</div>

											<div class="col-3 mb-3">Giảm giá:</div>
											<div class="col-7 mb-3 ">
												<input name="saleupdate" type="number" min="0" class="form-control" value="{{ $book->sale }}">
												@if($errors->has('saleupdate'))
													<span class="text-danger d-block mt-2">{{ $errors->first('saleupdate') }}</span>
												@endif
											</div>
											<div class="col-2 mb-3 ">
												<input type="text" class="form-control text-center" value="%" disabled>
											</div>
											<div class="col-3 mb-3">Tóm tắt nội dung:</div>
											<div class="col-9 mb-3">
												<textarea name="contentupdate" id="" class="w-100 ckeditor form-control" rows="3">{{ $book->content }}</textarea>
												@if($errors->has('contentupdate'))
													<span class="text-danger d-block mt-2">{{ $errors->first('contentupdate') }}</span>
												@endif
											</div>
										</div>
									</div>

									<!-- Modal footer -->
									<div class="modal-footer justify-content-center">
										<button type="submit" class="btn btn-warning text-white w-25">Lưu lại</button>
										<button type="button" class="btn btn-danger w-25" data-dismiss="modal">Đóng</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
					</form>
				</td>
			</tr>
			@endforeach
		</table>
		<div class="text-center">
			{{ $books->appends(['key' => $request->key])->links()}}
		</div>
	</div>

	<!-- Modal Add -->
	<div class="modal fade" id="add_book">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Thêm sách</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="modal-body container">
						<div class="row">
							<div class="col-3 mb-3">Tên sách:</div>
							<div class="col-9 mb-3">
								<input type="text" name="name" placeholder="Tên sách" class="form-control w-100">
								@if($errors->has('name'))
									<span class="text-danger d-block mt-2">{{ $errors->first('name') }}</span>
								@endif
							</div>

							<div class="col-3 mb-3">Ảnh</div>
							<div class="col-9 mb-3">
								<input type="file" name="img" class="form-control">
								@if($errors->has('img'))
									<span class="text-danger d-block mt-2">{{ $errors->first('img') }}</span>
								@endif
							</div>

							<div class="col-3 mb-3">Tác giả:</div>
							<div class="col-9 mb-3">
								<select name="author_id[]" id="" class="form-control select2 w-100" multiple="multiple">
									@foreach ($authors as $author)
										<option value="{{ $author->id }}">{{ $author->name }}</option>
									@endforeach
								</select>
							</div>

							<div class="col-3 mb-3">Thể loại:</div>
							<div class="col-9 mb-3">
								<select name="type[]" id="" class="form-control select2 w-100" multiple="multiple">
									@foreach ($types as $type)
									<option value="{{ $type->id }}">{{ $type->name }}</option>
									@endforeach
								</select>
							</div>

							<div class="col-3 mb-3">Danh mục:</div>
							<div class="col-9 mb-3">
								<select name="category[]" id="" class="form-control select2 w-100" multiple="multiple">
									@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
							</div>

							{{-- <div class="col-3 mb-3">Số lượng:</div>
							<div class="col-7 mb-3 ">
								<input name="amount" type="number" class="form-control">
								@if($errors->has('amount'))
									<span class="text-danger d-block mt-2">{{ $errors->first('amount') }}</span>
								@endif
							</div>
							<div class="col-2 mb-3 ">
								<input type="text" class="form-control text-center" value="Quyển" disabled>
							</div>

							<div class="col-3 mb-3">Giá bìa:</div>
							<div class="col-7 mb-3 ">
								<input name="cover_price" type="number" min="1" class="form-control">
								@if($errors->has('cover_price'))
									<span class="text-danger d-block mt-2">{{ $errors->first('cover_price') }}</span>
								@endif
							</div> --}}
							{{-- <div class="col-2 mb-3 ">
								<input type="text" class="form-control text-center" value="VNĐ" disabled>
							</div> --}}

							<div class="col-3 mb-3">Đơn giá:</div>
							<div class="col-7 mb-3 ">
								<input name="price" type="number" min="1" class="form-control">
								@if($errors->has('price'))
									<span class="text-danger d-block mt-2">{{ $errors->first('price') }}</span>
								@endif
							</div>
							<div class="col-2 mb-3 ">
								<input type="text" class="form-control text-center" value="VNĐ" disabled>
							</div>

							<div class="col-3 mb-3">Giảm giá:</div>
							<div class="col-7 mb-3 ">
								<input name="sale" type="number" min="0" class="form-control">
								@if($errors->has('sale'))
									<span class="text-danger d-block mt-2">{{ $errors->first('sale') }}</span>
								@endif
							</div>
							<div class="col-2 mb-3 ">
								<input type="text" class="form-control text-center" value="%" disabled>
							</div>
							<div class="col-3 mb-3">Tóm tắt nội dung:</div>
							<div class="col-9 mb-3">
								<textarea name="content" id="ckeditor" class="w-100 ckeditor form-control" rows="3"></textarea>
								@if($errors->has('content'))
									<span class="text-danger d-block mt-2">{{ $errors->first('content') }}</span>
								@endif
							</div>
						</div>
					</div>

					<!-- Modal footer -->
					<div class="modal-footer justify-content-center">
						<button type="submit" class="btn btn-success w-25">Thêm</button>
						<button type="button" class="btn btn-danger w-25" data-dismiss="modal">Đóng</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@include('layout.script')
</body>
</html>