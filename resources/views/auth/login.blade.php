@extends('master')

@section('head')

<title>{{ __('login') }}</title>

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
							{{ __('login') }}
						</div>
						<div class="col-xl-3"></div>
					</div>
				</div>

				<div class="card-body">
					<form method="POST" action="{{ route('login') }}">
						@csrf

						<div class="form-group row">
							<label for="username" class="col-xl-4 col-form-label text-xl-right">{{ __('username') }}</label>

							<div class="col-xl-6">
								<input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-xl-4 col-form-label text-xl-right">{{ __('password') }}</label>

							<div class="col-xl-6">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-xl-6 offset-xl-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

									<label class="form-check-label" for="remember">
										{{ __('remember') }}
									</label>
								</div>
							</div>
						</div>

						@include('errors')

						<div class="form-group row mb-0">
							<div class="col-xl-8 offset-xl-4">
								<button type="submit" class="btn btn-primary">
									{{ __('login') }}
								</button>

								@if (Route::has('password.request'))
								<a class="btn btn-link" href="{{ route('password.request') }}">
									{{ __('forgotYourPassword') }}
								</a>
								@endif
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection