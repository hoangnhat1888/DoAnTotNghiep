@extends('user.master')

@section('childHead')

<title>{{ __('makePayment') }}</title>

@endsection

@section('content')

<div class="row">
	<div class="col-xl-1"></div>
	<div class="col-xl-10">
		<h1 style="text-align: center;">{{ __('makePayment') }}</h1>

		<div class="table-responsive">
			<table class="table table-light table-striped table-bordered table-hover">
				<thead>
					<tr class="table-warning">
						<th style="width: 20%;">Hình ảnh</th>
						<th style="width: 30%;">Sản phẩm</th>
						<th style="width: 15%;">Số lượng</th>
						<th style="width: 15%;">Đơn giá</th>
						<th style="width: 20%;">Thành tiền</th>
					</tr>
				</thead>
				<tbody>
					<?php $total = 0; ?>
					@foreach ($products as $product)
					<tr>
						<td style="text-align: center;">
							<img class="img-fluid" src="/{{ $product->image }}" alt="{{ $product->title }}" />
						</td>
						<td>{{ $product->title }}</td>
						<td>{{ number_format($product->want_quantity) }}</td>
						<td>{{ number_format($product->price) }} VNĐ</td>
						<td>{{ number_format($product->want_quantity * $product->price) }} VNĐ</td>
					</tr>
					<?php $total += $product->want_quantity * $product->price; ?>
					@endforeach
				</tbody>
				<tfoot>
					<tr class="table-primary">
						<td colspan=5 style="text-align: center;">
							<h4 style="color: red;">Tổng tiền: <span>{{ number_format($total) }}</span> VNĐ</h4>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="col-xl-1"></div>
</div>

<div class="row">
	<div class="col-xl-1"></div>
	<div class="col-xl-10">
		<h3 style="text-align: center;">Thông tin nhận hàng</h3>

		@include('errors')

		<form method="POST" action="/checkout/make-payment">
			@csrf

			<div class="row">
				<div class="col-xl-2">
					<label>Tên người nhận</label>
				</div>
				<div class="col-xl-4">
					<input name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required max="32" value="{{ $errors->any() ? old('name') : '' }}" />
				</div>
				<div class="col-xl-2">
					<label>{{ __('email') }}</label>
				</div>
				<div class="col-xl-4">
					<input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required max="32" value="{{ $errors->any() ? old('email') : '' }}" />
				</div>
			</div>

			<div class="row">
				<div class="col-xl-2">
					<label>{{ __('phoneNumber') }}</label>
				</div>
				<div class="col-xl-4">
					<input name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" required max="16" value="{{ $errors->any() ? old('phone') : '' }}" />
				</div>
				<div class="col-xl-2">
					<label>Địa chỉ giao hàng</label>
				</div>
				<div class="col-xl-4">
					<input name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" required max="256" value="{{ $errors->any() ? old('address') : '' }}" />
				</div>
			</div>

			<div class="row">
				<div class="col-xl-2">
					<label>{{ __('note') }}</label>
				</div>
				<div class="col-xl-4">
					<textarea name="note" rows="{{ count($payments)}}" max="256" class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}">{{ $errors->any() ? old('note') : '' }}</textarea>
				</div>
				<div class="col-xl-2">
					<label>{{ __('usePayment') }}</label>
				</div>
				<div class="col-xl-4">
					<select name="payment_id" required max="256" class="form-control">
						@foreach ($payments as $payment)
						<option value="{{ $payment->id }}">{{ $payment->name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-12">
					<div style="text-align: right;">
						<button type="submit" class="btn btn-success"><i class="fas fa-money-bill-wave"></i>Thanh toán</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-xl-1"></div>
</div>

@endsection