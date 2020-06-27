@extends('master')

@section('head')

<title>{{ __('resetPassword') }}</title>

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
							{{ __('resetPassword') }}
						</div>
						<div class="col-xl-3"></div>
					</div>
				</div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif

					<form method="POST" action="{{ route('password.email') }}">
						@csrf

						<div class="form-group row">
							<label for="email" class="col-xl-4 col-form-label text-xl-right">{{ __('email') }}</label>

							<div class="col-xl-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
							</div>
						</div>

						@include('errors')

						<div class="form-group row mb-0">
							<div class="col-xl-6 offset-xl-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Send Password Reset Link') }}
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