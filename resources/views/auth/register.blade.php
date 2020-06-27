@extends('master')

@section('head')

<title>{{ __('register') }}</title>

@endsection

@section('body')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-8">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-xl-3" style="text-align: left;">
							<a href="/"><i class="fas fa-arrow-left"></i>{{ __('home') }}</a>
						</div>
						<div class=" col-xl-6">
							{{ __('register') }}
						</div>
						<div class="col-xl-3"></div>
					</div>
				</div>

				<div class="card-body">
					<form method="POST" action="{{ route('register') }}">
						@csrf

						<div class="form-group row">
							<label for="username" class="col-xl-4 col-form-label text-xl-right">{{ __('username') }}</label>

							<div class="col-xl-6">
								<input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-xl-4 col-form-label text-xl-right">{{ __('email') }}</label>

							<div class="col-xl-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-xl-4 col-form-label text-xl-right">{{ __('password') }}</label>

							<div class="col-xl-6">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
							</div>
						</div>

						<div class="form-group row">
							<label for="password-confirm" class="col-xl-4 col-form-label text-xl-right">{{ __('confirmPassword') }}</label>

							<div class="col-xl-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
							</div>
						</div>

						@include('errors')

						<div class="form-group row mb-0">
							<div class="col-xl-6 offset-xl-4">
								<button type="submit" class="btn btn-primary">
									{{ __('register') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection