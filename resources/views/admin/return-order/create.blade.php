<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Tạo đơn hàng trả lại</title>
	@include('layout.link')
</head>
<body>
	@include('admin.menu_admin')
	
	<div class="container mt-5">
		<h1 class="title-admin">Tạo đơn hàng trả lại</h1>
	</div>

	<div class="container-fluid mt-5">
		<a class="btn btn-success text-white" href="{{ route('return-order.index') }}">Danh sách đơn hàng trả lại</a>
		
		<form method="POST" action="{{ route('return-order.store') }}">
			@csrf
			<div class="form-group row mt-3">
				<label class="col-2 col-form-label">Đơn hàng</label>
				<div class="col-3">
					<select name="order_id" class="form-control" required onchange="getBookInOrder($(this).val())">
						<option value=""></option>
						@foreach($orders as $order)
						<option value="{{ $order->id }}">{{ $order->code }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<table class="table table-bordered table-striped mt-3">
				<tr class="text-center">
					<th>STT</th>
					<th width="350px">Tên sách</th>
					<th>Số lượng (Quyển)</th>
					<th>Giá (VNĐ)</th>
					<th>Khuyến mãi (%)</th>
					<th>Thành tiền (VNĐ)</th>
					<th class="minw-140">Thao tác</th>
				</tr>
				<?php $stt = 1; ?>
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>
						<select name="book_id[0]" class="form-control select2" required onchange="setSalePrice($(this).val(), 0)">
						</select>
					</td>
					<td class="text-center">
						<input type="number" name="amount[0]" class="form-control" min="1" onkeyup="totalMoney(0)" required>
					</td>
					<td class="text-center" id="price0">0</td>
					<td class="text-center" id="sale0">0</td>
					<td class="text-center" id="totalMoney0">0</td>
					<td></td>
				</tr>
				<tfoot>
					<tr>
						<td class="text-center">
							<button type="button" class="btn btn-success" onclick="addRow()">+</button>
						</td>
						<td colspan="4" class="font-weight-bold text-right">Tổng cộng</td>
						<td class="font-weight-bold text-center" id="total">0</td>
						<td></td>
					</tr>
				</tfoot>
			</table>
			<div class="text-center">
				<button type="submit" class="btn btn-success mt-2">Tạo đơn bán hàng</button>
			</div>
		</form>
	</div>

	@include('layout.script')

	<script type="text/javascript">
		let stt = 0;
        let text = '';

		function addRow() {
			stt++;
			let row = `
				<tr>
					<td class="text-center">${stt +1}</td>
					<td>
						<select name="book_id[${stt}]" class="form-control select2" required onchange="setSalePrice($(this).val(), ${stt})">
							${text}
						</select>
					</td>
					<td class="text-center">
						<input type="number" name="amount[${stt}]" class="form-control" min="1" onkeyup="totalMoney(${stt})" required>
					</td>
					<td class="text-center" id="price${stt}">0</td>
					<td class="text-center" id="sale${stt}">0</td>
					<td class="text-center" id="totalMoney${stt}">0</td>
					<td class="text-center">
						<button type="button" class="btn btn-danger" onclick="removeRow($(this))">X</button>
					</td>
				</tr>
			`;
			jQuery('tbody').append(row);
			
			$(".select2").select2({ 
			});
		}

		function removeRow(obj) {
			obj.closest('tr').remove();
			setTotal();
		}

		function setSalePrice(id, stt) {
            $.ajax({
                url: "/admin/books/" + id,
                method: 'GET',
                data: {
                    id: id,
                },
                success: function (respon) {
                    $(`#sale${stt}`).text(respon.sale);
                    $(`#price${stt}`).text(respon.price);
                    totalMoney(stt);
                }
            })
        }

		function totalMoney(stt) {
			let amount = $(`input[name="amount[${stt}]"]`).val();
			let price = $(`#price${stt}`).text();
			let sale = $(`#sale${stt}`).text();
			let total_money = (amount * price) - (amount * price * sale / 100);

			$(`#totalMoney${stt}`).text(total_money);

			setTotal();
		}

        function setTotal() {
	        let total = 0;
	        for (i=0; i<=stt; i++) {
	        	if ($(`#totalMoney${i}`).text()) {
	        		total += parseInt($(`#totalMoney${i}`).text());
	        	}
	        }
	        $(`#total`).text(total);
        }

        function getBookInOrder(id) {
        	text = '<option value=""></option>';
        	$.ajax({
                url: "/return-order/get-book-in-order/" + id,
                method: 'GET',
                data: {
                    id: id,
                },
                success: function (respon) {
                    $.each( respon, function( key, value ) {
                        text += `<option value="${value.book.id}">${value.book.name}</option>`;
                    });
                    
                    for (i=0; i<=stt; i++) {
                    	if ($(`select[name="book_id[${i}]"]`)) {
                    		$(`select[name="book_id[${i}]"]`).html(text);
                    	}
                    }
                }
            })
        }
	</script>
</body>
</html>