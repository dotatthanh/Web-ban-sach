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
		<h1 class="title-admin">Nhập hàng</h1>
	</div>

	<div class="container-fluid mt-5">
		<a class="btn btn-success text-white" href="{{ route('warehouses.index') }}">Danh sách nhập hàng</a>
		
		<form method="POST" action="{{ route('warehouses.store') }}">
			@csrf
			<table class="table table-bordered table-striped mt-3">
				<tr class="text-center">
					<th>STT</th>
					<th width="350px">Tên sách</th>
					<th width="450px">Nhà cung cấp</th>
					<th>Số lượng</th>
					<th>Giá</th>
					<th class="minw-140">Thao tác</th>
				</tr>
				<?php $stt = 1; ?>
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>
						<select name="book_id[]" class="form-control">
							<option value=""></option>
							@foreach($books as $book)
							<option value="{{ $book->id }}">{{ $book->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<select name="supplier_id[]" class="form-control">
							<option value=""></option>
							@foreach($suppliers as $supplier)
							<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
							@endforeach
						</select>
					</td>
					<td class="text-center">
						<input type="number" name="amount[]" class="form-control" min="0">
					</td>
					<td class="text-center">
						<input type="number" name="price[]" class="form-control" min="0">
					</td>
					<td></td>
				</tr>
				<tfoot>
					<tr>
						<td class="text-center">
							<button type="button" class="btn btn-success" onclick="addRow()">+</button>
						</td>
					</tr>
				</tfoot>
			</table>
			<div class="text-center">
				<button type="submit" class="btn btn-success mt-2">Nhập hàng</button>
			</div>
		</form>
	</div>

	@include('layout.script')

	<script type="text/javascript">
		let stt = 1;
		function addRow() {
			stt++;
			let row = `
				<tr>
					<td class="text-center">${stt}</td>
					<td>
						<select name="book_id[]" class="form-control">
							<option value=""></option>
							@foreach($books as $book)
							<option value="{{ $book->id }}">{{ $book->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<select name="supplier_id[]" class="form-control">
							<option value=""></option>
							@foreach($suppliers as $supplier)
							<option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
							@endforeach
						</select>
					</td>
					<td class="text-center">
						<input type="number" name="amount[]" class="form-control" min="0">
					</td>
					<td class="text-center">
						<input type="number" name="price[]" class="form-control" min="0">
					</td>
					<td class="text-center">
						<button type="button" class="btn btn-danger" onclick="removeRow($(this))">X</button>
					</td>
				</tr>
			`;

			jQuery('tbody').append(row);
		}

		function removeRow(obj) {
			stt--;
			let a = obj.closest('tr').remove();
		}
	</script>
</body>
</html>