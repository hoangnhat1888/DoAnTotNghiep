@extends('user.master')

@section('childHead')

<title>{{ __('shoppingCart') }}</title>

@endsection

@section('content')

@if (request()->has('success'))

<script>
	$(document).ready(function() {
		setTimeout(() => {
			@if(request()['success'])
			clearCart(false);
			alert('Đặt hàng thành công!');
			@else
			alert('Có lỗi xảy ra trong quá trình đặt hàng, vui lòng đặt lại!');
			@endif
		}, 500);
	});
</script>

@endif

<div class="row">
	<div class="col-xl-1"></div>
	<div class="col-xl-10">
		<h1 style="text-align: center;">{{ __('shoppingCart') }}</h1>

		<div class="table-responsive">
			<table class="table table-light table-striped table-bordered table-hover">
				<thead>
					<tr class="table-warning">
						<th style="width: 5%;">Xóa</th>
						<th style="width: 20%;">Hình ảnh</th>
						<th style="width: 30%;">Sản phẩm</th>
						<th style="width: 15%;">Số lượng</th>
						<th style="width: 15%;">Đơn giá</th>
						<th style="width: 15%;">Thành tiền</th>
					</tr>
				</thead>
				<tbody>
					<?php $total = 0; ?>
					@foreach ($products as $product)
					<tr>
						<td class="table-danger" style="text-align: center;">
							<button class="btn btn-danger btn-icon" onclick="removeFromCart({{ $product->id }});"><i class="fas fa-trash"></i></button>
						</td>
						<td style="text-align: center;">
							<img class="img-fluid" src="/{{ $product->image }}" alt="{{ $product->title }}" />
						</td>
						<td>{{ $product->title }}</td>
						<td>
							<input type="number" class="form-control" min=1 value="{{ $product->want_quantity }}" oninput="updateWantQuantity({{ $product->id }}, $(event.target).val());" />
						</td>
						<td>{{ number_format($product->price) }} VNĐ</td>
						<td>{{ number_format($product->want_quantity * $product->price) }} VNĐ</td>
					</tr>
					<?php $total += $product->want_quantity * $product->price; ?>
					@endforeach
				</tbody>
				<tfoot>
					<tr class="table-primary">
						<td colspan="6" style="text-align: center;">
							<h4 style="color: red;">Tổng tiền: <span>{{ number_format($total) }}</span> VNĐ</h4>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div style="text-align: right;{{ !count($products) ? ' display: none;' : '' }}">
			<button class="btn btn-danger" onclick="clearCart();"><i class="fas fa-minus-circle"></i>Xóa giỏ hàng</button>
			<button class="btn btn-warning" onclick="updateCart();"><i class="fas fa-sync"></i>Cập nhật giỏ hàng</button>
			<a href="/checkout/payment"><button class="btn btn-success"><i class="fas fa-money-bill-wave"></i>Tiến hành thanh toán</button></a>
		</div>
	</div>
	<div class="col-xl-1"></div>
</div>

@endsection