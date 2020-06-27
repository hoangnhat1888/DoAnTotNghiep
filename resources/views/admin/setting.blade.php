@extends('admin.master')

@section('childHead')

<title>{{ __('settingsManagement') }}</title>

@endsection

@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
		<div class="kt-portlet__head">
			<div class="kt-portlet__head-label">
				<h3 class="kt-portlet__head-title">{{ __('settingsManagement') }}</h3>
			</div>
		</div>
		<form class="kt-form" method="POST" action="{{ route('admin') }}/settings{{ isset($setting) ?  __('/' . $setting->id) : __('') }}" enctype="multipart/form-data">
			@if (isset($setting))

			@method('PATCH')

			@endif
			@csrf

			<div class="kt-portlet__body">
				<div class="row">
					<div class="col-xl-3">
						<label class="col-form-label">{{ __('companyName') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ $errors->any() ? old('company_name') : (isset($setting) ? $setting->company_name : '') }}" max="32" autofocus />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('companyOwner') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('company_owner') ? ' is-invalid' : '' }}" name="company_owner" value="{{ $errors->any() ? old('company_owner') : (isset($setting) ? $setting->company_owner : '') }}" max="32" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('companySlogan') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('company_slogan') ? ' is-invalid' : '' }}" name="company_slogan" value="{{ $errors->any() ? old('company_slogan') : (isset($setting) ? $setting->company_slogan : '') }}" max="64" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('logo') }}</label>
					</div>
					<div class="col-xl-9">
						<img class="img-fluid img-size" src="{{ isset($setting) ? $setting->logo : '' }}" alt="" onclick="$('#inputFile').click();" />
						<input type="file" id="inputFile" name="logo" class="form-control" accept="image/*" onchange="previewImage(event);" style="display: none;" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('taxId') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('tax_id') ? ' is-invalid' : '' }}" name="tax_id" value="{{ $errors->any() ? old('tax_id') : (isset($setting) ? $setting->tax_id : '') }}" max="32" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('phoneNumber') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ $errors->any() ? old('phone_number') : (isset($setting) ? $setting->phone_number : '') }}" max="32" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('address') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $errors->any() ? old('address') : (isset($setting) ? $setting->address : '') }}" max="128" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('email') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $errors->any() ? old('email') : (isset($setting) ? $setting->email : '') }}" max="32" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('location') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" value="{{ $errors->any() ? old('location') : (isset($setting) ? $setting->location : '') }}" max="32" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('workingHours') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('working_hours') ? ' is-invalid' : '' }}" name="working_hours" value="{{ $errors->any() ? old('working_hours') : (isset($setting) ? $setting->working_hours : '') }}" max="32" />
					</div>

					<div class="col-xl-3">
						<label class="col-form-label">{{ __('companyWebsite') }}</label>
					</div>
					<div class="col-xl-9">
						<input class="form-control{{ $errors->has('company_website') ? ' is-invalid' : '' }}" name="company_website" value="{{ $errors->any() ? old('company_website') : (isset($setting) ? $setting->company_website : '') }}" max="32" />
					</div>
				</div>
			</div>
			<div class="kt-portlet__foot">
				<div class="kt-form__actions">
					<button type="submit" class="btn btn-primary">{{ __('saveChanges') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection