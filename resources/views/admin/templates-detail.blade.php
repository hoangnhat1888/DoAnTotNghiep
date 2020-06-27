@extends('admin.master')

@section('childHead')

<title>{{ __('Templates Detail') }}</title>

@endsection

@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">

		<form class="kt-form" method="POST" action="{{ route('admin') }}/export{{ isset($templatesdetail) ?  __('/' . $templatesdetail->id) : __('') }}" enctype="multipart/form-data">
			@if (isset($templatesdetail))

			@method('PATCH')

			@endif
			@csrf

			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 name="{{$title->id}}" class="kt-portlet__head-title">{{ __($title->name) }}</h3>
				</div>
			</div>

			@if(session('notification'))
				<div class="alert alert-success">
					{{session('notification')}}
				</div>
			@endif
			<div class="kt-portlet__body">
				<div class="row">
					@foreach($field_name as $i)
						<div class="col-xl-3">
							<label class="col-form-label" style="text-transform: uppercase">{{str_replace("_"," ",$i)}}</label>
						</div>
						@if(str_contains($i,'date')||str_contains($i,'day'))
							<div class="col-xl-9">
								{{-- <input class="form-control" type="date" required name="{{$i}}" value="{{ $errors->any() ? old($i) : ''}}"> --}}
								<input class="form-control" type="date" name="{{$i}}">
							</div>
						@elseif(str_contains($i,'date'))
							<div class="col-xl-9">
								<input class="form-control" type="number" name="{{$i}}">
							</div>
						@else
							<div class="col-xl-9">
								<input class="form-control" type="text" name="{{$i}}">
							</div>
						@endif
					@endforeach
					<div class="col-xl-9">
						<input class="form-control" type="hidden" name="idTitle" value="{{$title->id}}">
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
