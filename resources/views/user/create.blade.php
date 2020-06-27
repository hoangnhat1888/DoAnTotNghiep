<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Document</title>
		{{-- <link rel="stylesheet" href="../css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		@if(session('thongbao'))
			<div class="alert alert-success">
				{{session('thongbao')}}
			</div>
		@endif
		<form method="POST" action="{{route('createPost')}}">
			@csrf
			<table class="table">
				<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Monday</th>
					<th scope="col">Tuesday</th>
					<th scope="col">Wednesday</th>
					<th scope="col">Thurday</th>
					<th scope="col">Friday</th>
					<th scope="col">Saturday</th>
				</tr>
				</thead>

				<tbody>

				<tr>
					<th>{{Auth::user()->username}}</th>
					<th scope="row">
							<div style="width:250px" class="input-group mb-3">
									<select required name="T2" class="custom-select" id="inputGroupSelect02">
											<option>Chọn thời gian làm</option>
											<option value="Full">Cả ngày</option>
											<option value="S">Buổi sáng</option>
											<option value="C">Buổi chiều</option>
											<option value="off">Off</option>

					</th>

					<th scope="row">
							<div style="width:250px" class="input-group mb-3">
									<select required name="T3" class="custom-select" id="inputGroupSelect02">
											<option>Chọn thời gian làm</option>
											<option value="Full">Cả ngày</option>
											<option value="S">Buổi sáng</option>
											<option value="C">Buổi chiều</option>
											<option value="off">Off</option>

								</div>
					</th>
					<th scope="row">
							<div style="width:250px" class="input-group mb-3">
									<select required name='T4' class="custom-select" id="inputGroupSelect02">
											<option >Chọn thời gian làm</option>
											<option value="Full">Cả ngày</option>
											<option value="S">Buổi sáng</option>
											<option value="C">Buổi chiều</option>
											<option value="off">Off</option>

								</div>
					</th>
					<th scope="row">
							<div style="width:250px" class="input-group mb-3">
									<select required name='T5' class="custom-select" id="inputGroupSelect02">
											<option >Chọn thời gian làm</option>
											<option value="Full">Cả ngày</option>
											<option value="S">Buổi sáng</option>
											<option value="C">Buổi chiều</option>
											<option value="off">Off</option>

								</div>
					</th>
					<th scope="row">
							<div style="width:250px" class="input-group mb-3">
									<select required name='T6' class="custom-select"  id="inputGroupSelect02">
											<option >Chọn thời gian làm</option>
											<option value="Full">Cả ngày</option>
											<option value="S">Buổi sáng</option>
											<option value="C">Buổi chiều</option>
											<option value="off">Off</option>

								</div>
					</th>
					<th scope="row">
							<div style="width:250px" class="input-group mb-3">
									<select required name='T7' class="custom-select"  id="inputGroupSelect02">
										{{-- <input class="form-control" type="date" required name="{{$i}}" value="{{ $errors->any() ? old($i) : ''}}"> --}}
										<option>Chọn thời gian làm</option>
										<option value="Full">Cả ngày</option>
										<option value="S">Buổi sáng</option>
										<option value="C">Buổi chiều</option>
										<option value="off">Off</option>

							</div>
					</th>
				</tr>


				</tbody>
			</table>
			<center>
				<input type="submit" class="btn btn-primary" value="Đăng ký">
			</center>
	</form>
		{{-- <script src="../js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="../js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>

</html>
