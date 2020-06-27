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
					{{ __('templateManagement') }} <i class="fas fa-angle-double-right"></i> {{ (isset($user) ? __('edit') : __('add')) }}
				</h3>
			</div>
		</div>
		<div class="table table-striped table-bordered table-hover datatable">
            <div class="kt-portlet__body">
            <form method="POST" action="/admin/template" enctype="multipart/form-data">
            @csrf
				<div class="row">
                            <div class="col-xl-3">
                                <label class="col-form-label"><h3>Tên Mẫu</h3></label>
                            </div>
                            <div class="col-xl-9">
                                <input type="text" name="name" placeholder="tên mẫu" class="form-control">
					        </div>
                            <div class="col-xl-3">
                                <label for="chosefile"><h3>Chọn File</h3></label>
                            </div>
                            <div class="col-xl-9">
                                <input type="file" accept=".docx,doc" name="file" class="form-control">
                            </div>
                        
                            <div class="col-xl-3">
                                
                            </div>
                            <div class="col-xl-9" style>
                                <button class="btn btn-primary">Thêm Mẫu</button>
                            </div>
                </div>
            </form>
            </div>
		</div>
	</div>



@endsection

