@extends('admin.master')

@section('childHead')

<title>{{ __('workScheduleManagement') }}</title>

@endsection
@section('content')

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
	<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<button type="button" class="btn btn-primary back" onclick="backToPreviousPage();">
						<i class="fas fa-angle-double-left">&nbsp;</i>
					</button>
					<h3 class="kt-portlet__head-title">
						{{ __('workScheduleManagement') }} <i class="fas fa-angle-double-right"></i> {{ __('add') }}
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<h4 class="font-weight-bolder">{{ __('name').": "."$user->first_name "."$user->last_name" }}</h4>
				<h5>{{ "id user: ".$user->id }}</h5>
				{{-- PHAN CUA HONG NHAT --}}
				<table class="table">
					<thead>
					</thead>
				<form class="kt-form" method="POST" action="{{ route('admin') }}/work-schedule/{{ $user->id }}">
					@csrf
					<table style="text-align:center" class="table">
						<thead>
							<tr>
								<th scope="col" style="font-size:30px">Ngày Đăng Ký</th>
								<th scope="col" style="font-size:30px">Số Buổi</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="font-size:20px">Thứ Hai</td>
								<td>
									<select name="txtthuhai" style="width:300px" class="browser-default custom-select">
										<option value="off">Nghỉ</option>
										<option value="S">Sáng</option>
										<option value="C">Chiều</option>
										<option value="Full">Cả ngày</option>
									</select>
								</td>
							</tr>

							<tr>
								<td style="font-size:20px">Thứ Ba</td>
								<td>
									<select name="txtthuba" style="width:300px" class="browser-default custom-select">
										<option value="off">Nghỉ</option>
										<option value="S">Sáng</option>
										<option value="C">Chiều</option>
										<option value="Full">Cả ngày</option>
									</select>
								</td>
							</tr>

							<tr>
								<td style="font-size:20px">Thứ Tư</td>
								<td>
									<select name="txtthutu" style="width:300px" class="browser-default custom-select">
										<option value="off">Nghỉ</option>
										<option value="S">Sáng</option>
										<option value="C">Chiều</option>
										<option value="Full">Cả ngày</option>
									</select>
								</td>
							</tr>

							<tr>
								<td style="font-size:20px">Thứ Năm</td>
								<td>
									<select name="txtthunam" style="width:300px" class="browser-default custom-select">
										<option value="off">Nghỉ</option>
										<option value="S">Sáng</option>
										<option value="C">Chiều</option>
										<option value="Full">Cả ngày</option>
									</select>
								</td>
							</tr>

							<tr>
								<td style="font-size:20px">Thứ Sáu</td>
								<td>
									<select name="txtthusau" style="width:300px" class="browser-default custom-select">
										<option value="off">Nghỉ</option>
										<option value="S">Sáng</option>
										<option value="C">Chiều</option>
										<option value="Full">Cả ngày</option>
									</select>
								</td>
							</tr>

							<tr>
								<td style="font-size:20px">Thứ Bảy</td>
								<td>
									<select name="txtthubay" style="width:300px" class="browser-default custom-select">
										<option value="off">Nghỉ</option>
										<option value="S">Sáng</option>
										<option value="C">Chiều</option>
										<option value="Full">Cả ngày</option>
									</select>
								</td>
							</tr>
						</tbody>
						{{-- {{csrf_token()}} --}}
					</table>
					<center>
						<input type="submit" value="Đăng ký" class="btn btn-primary">
					</center>
				</form>

				{{-- HETPHANCUAHONGNHAT --}}
			</div>
		</div>
	</div>


	<script src="../js/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>
	<script src="../js/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="../js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>

@endsection
