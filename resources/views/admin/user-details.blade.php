@extends('admin.master')

@section('childHead')

<title>{{ __('usersManagement') }}</title>

@endsection

<?php

use App\Role\RoleChecker;
use App\Role\UserRole;

?>

@section('content')
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
						<input type="file" id="inputFile" name="image" class="form-control" accept="image/*" onchange="previewImage(event);" style="display: none;" />.
							
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
						<label class="col-form-label">{{ __('address') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" required name="address" max="128" value="{{ $errors->any() ? old('address') : (isset($user) ? $user->address : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('gender') }}</label>
					</div>
					<div class="col-xl-9">
						<select class="form-control" name="gender_id" value="{{ isset($user) ? $user->gender_id : '' }}">
							@foreach ($genders as $gender)
							<option value="{{ $gender->id }}" {{ isset($user) && $user->gender_id === $gender->id ? 'selected="selected"' : ''}}>{{ __($gender->name) }}</option>
							@endforeach
						</select>
					</div>
					
					@if (RoleChecker::check(auth()->user(), UserRole::ADMIN))
					@if (substr(explode('?', $_SERVER['REQUEST_URI'])[0], 0, mb_strlen(route('admin') . '/account')) !== route('admin') . '/account')
					<div class="col-xl-3">
						<label class="col-form-label">{{ __('position') }}</label>
					</div>
					<div class="col-xl-9">
						<select class="form-control" name="position_id" value="{{ isset($user) ? $user->position_id : '' }}">
							@foreach ($positions as $position)
							<option value="{{ $position->id }}" {{ isset($user) && $user->position_id === $position->id ? 'selected="selected"' : ''}}>{{ $position->name }}</option>
							@endforeach
						</select>
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

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('startDate') }}</label>
					</div>
					<div class="col-xl-9">
						<input type="date" class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" name="start_date" required value="{{ date('Y-m-d', strtotime($errors->any() ? old('start_date') : (isset($user) ? $user->start_date : date('Y-m-d')))) }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('signingDate') }}</label>
					</div>
					<div class="col-xl-9">
						<input type="date" class="form-control{{ $errors->has('signing_date') ? ' is-invalid' : '' }}" name="signing_date" required value="{{ date('Y-m-d', strtotime($errors->any() ? old('signing_date') : (isset($user) ? $user->signing_date : date('Y-m-d')))) }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('signingTerm') }}</label>
					</div>
					<div class="col-xl-9">
						<input type="number" class="form-control{{ $errors->has('signing_term') ? ' is-invalid' : '' }}" name="signing_term" min=0 value="{{ $errors->any() ? old('signing_term') : (isset($user) ? $user->signing_term : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('endDate') }}</label>
					</div>
					<div class="col-xl-9">
						<input type="date" class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" name="end_date" value="{{ $errors->any() ? (old('end_date') ? date('Y-m-d', strtotime(old('end_date'))) : '') : (isset($user) ? $user->end_date : '') }}" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('salary') }}</label>
					</div>
					<div class="col-xl-9">
						<input type="number" class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}" name="salary" min=0 value="{{ $errors->any() ? old('salary') : (isset($user) ? $user->salary : '') }}" />
					</div>
					@endif
				</div>
				<div class="kt-portlet__foot">
					<div class="kt-form__actions">
						<button type="submit" class="btn btn-primary">{{ __('saveChanges') }}</button>
					</div>
				</div>
			</div>

			<div id="passwordModal" class="modal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">{{ __('changePassword') }}</h5>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xl-12">
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-lock"></i>
												</div>
											</div>
											<input type="password" name="password" class="form-control" placeholder="{{ __('newPassword') }}" autocomplete="new-password" />
										</div>
									</div>
									<div class="col-xl-12">
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-lock"></i>
												</div>
											</div>
											<input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('confirmPassword') }}" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xl-2"></div>
									<div class="col-xl-4">
										<button class="btn btn-primary btn-full-width" data-dismiss="modal">{{ __('change') }}</button>
									</div>
									<div class="col-xl-4">
										<button class="btn btn-primary btn-full-width" data-dismiss="modal">{{ __('cancel') }}</button>
									</div>
									<div class="col-xl-2"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	function modifyRoles() {
		var roles = [];

		$('.roles').each(function() {
			if ($(this).prop('checked')) {
				roles.push($(this).val());
			}
		});

		$('#roles').val(JSON.stringify(roles));
	}

	function changePassword() {
		$('#passwordModal').modal();
	}
</script>

@endsection