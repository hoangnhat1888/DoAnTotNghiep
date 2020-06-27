
@extends('admin.master')
@section('childHead')

<title>{{ __('templateManagement') }}</title>

@endsection

@section('sub-header')

@endsection
@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
		<div class="kt-portlet__head">
			<div class="kt-portlet__head-label">
				<button type="button" class="btn btn-primary back" onclick="backToPreviousPage();">
					<i class="fas fa-angle-double-left">&nbsp;</i>
				</button>
				<h3 class="kt-portlet__head-title">
					{{ __('exportManagementTemplate') }} <i class="fas fa-angle-double-right"></i> {{ (isset($user) ? __('edit') : __('add')) }}
				</h3>
			</div>
		</div>
	
		<form action="admin/template-exports" method="post" enctype="multipart/form-data">
			@csrf 
						<!-- <span>Nhập Tên</span>
						<input type = "text" name="name"  >
						<input type = "file" name="_file" >
						<button type="submit" name = "btnSubmit"> submit</button> -->
					<div class="kt-portlet__body">
						<div class="row">
						<!-- 0 -->
						<div class="col-xl-3">
							<label class="col-form-label">{{ __('nameTemplate') }}</label>
						</div>
						<div class="col-xl-9">
							<input type="text" name="name"class="form-control"  placeholder="Nhập tên template" />
						</div>
						<!-- 1 -->
						<div class="col-xl-3">
							<label class="col-form-label">Chọn File</label>
						</div>
						<div class="col-xl-9">
							<input type = "file" name="_file">
						</div>
						<!-- 2 -->
						<div class="col-xl-3">
							<label class="col-form-label"></label>
						</div>
						<div class="col-xl-9">
							<button type="submit" name="btnSubmit" class="btn btn-primary" >{{__('upload')}}</button>
						</div>
					</div>
			</div>
		</form>
 	</div>
</div>
@endsection