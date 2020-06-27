@extends('admin.master')

@section('childHead')

<title>{{ __('ListEmployeeManagement') }}</title>

@endsection

section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
		<div class="kt-portlet__head">
			<div class="kt-portlet__head-label">
				<button type="button" class="btn btn-primary back" onclick="backToPreviousPage();">
					<i class="fas fa-angle-double-left">&nbsp;</i>
				</button>
				<h3 class="kt-portlet__head-title">
					{{ __('usersManagement') }} <i class="fas fa-angle-double-right"></i> {{ (isset($user) ? __('edit') : __('add')) }}
				</h3>
			</div>
		</div>

		<form method="POST" action="{{ (substr(explode('?', $_SERVER['REQUEST_URI'])[0], 0, mb_strlen(route('admin') . '/account')) !== route('admin') . '/account') ? (route('admin') . '/users' . (isset($user) ? '/' . $user->id : '')) : route('admin') . '/account/update' }}" enctype="multipart/form-data">

		@if (isset($user))

		@method('PATCH')

		@endif
		@csrf

		//div
		<div class="kt-portlet__body">
				<div class="row">
					<div class="col-xl-3">
						<label class="col-form-label">{{ __('username') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" required max="32" value="{{ $errors->any() ? old('username') : (isset($user) ? $user->username : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('email') }}</label>
					</div>
					<div class="col-xl-9">
						<input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required max="32" value="{{ $errors->any() ? old('email') : (isset($user) ? $user->email : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('avatar') }}</label>
					</div>
					<div class="col-xl-9">
						<img class="img-fluid img-size" src="{{ isset($user) ? $user->image : '' }}" alt="" onclick="$('#inputFile').click();" />
						<input type="file" id="inputFile" name="image" class="form-control" accept="image/*" onchange="previewImage(event);" style="display: none;" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('password') }}</label>
					</div>
					<div class="col-xl-9">
						<button type="button" class="btn btn-primary" onclick="changePassword();">{{ __('changePassword') }}</button>
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('firstName') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" required name="first_name" max="32" value="{{ $errors->any() ? old('first_name') : (isset($user) ? $user->first_name : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('lastName') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" required name="last_name" max="32" value="{{ $errors->any() ? old('last_name') : (isset($user) ? $user->last_name : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('phoneNumber') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" required max="32" value="{{ $errors->any() ? old('phone_number') : (isset($user) ? $user->phone_number : '') }}" />
					</div>

					
					<div class="col-xl-3">
						<label class="col-form-label">{{ __('role') }}</label>
					</div>
					<div class="col-xl-9">
						<div class="form-control-radio">
							<input id='roles' class="form-control" name="roles" style="display: none;" value="{{ isset($user) && isset($user->roles) ? json_encode($user->roles) : '[]' }}" />

							@foreach ($roles as $roleKey => $role)
							<div class="form-check form-check-inline">
								<input class="form-check-input roles" type="radio" id="inlineRadio{{ $role }}" name="inlineRadio" value="{{ $roleKey }}" onchange="modifyRoles();" {{ isset($user) ? (in_array($roleKey, $user->roles) ? 'checked' : '') : '' }} />
								<label class="form-check-label" for="inlineRadio{{ $role }}">{{ $role }}</label>
							</div>
							@endforeach
						</div>
					</div>
					@endif
					@endif
				</div>
				<div class="kt-portlet__foot">
					<div class="kt-form__actions">
						<button type="submit" class="btn btn-primary">{{ __('saveChanges') }}</button>
					</div>
				</div>
		</div>

