@extends('master')

@section('head')

<title>{{ __('verify') }}</title>

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
							{{ __('Verify Your Email Address') }}
						</div>
						<div class="col-xl-3"></div>
					</div>
				</div>

				<div class="card-body">
					@if (session('resent'))
					<div class="alert alert-success" role="alert">
						{{ __('A fresh verification link has been sent to your email address.') }}
					</div>
					@endif

					{{ __('Before proceeding, please check your email for a verification link.') }}
					{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
				</div>
			</div>
		</div>
	</div>
</div>
@endsection