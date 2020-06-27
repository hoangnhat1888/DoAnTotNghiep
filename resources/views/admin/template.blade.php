@extends('admin.master')

@section('childHead')

<title>Quản lý mẫu</title>

@endsection

@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">Quản lý mẫu</h3>

			<span class="kt-subheader__separator kt-subheader__separator--v"></span>
     
			
		</div>
		<div class="kt-subheader__toolbar">
			<button class="btn btn-primary" onclick="addItem();">{{ __('add') }}</button>
			<!-- <button class="btn btn-primary btn-full-width" onclick="editItem();">{{ __('edit') }}</button> -->
			<button class="btn btn-primary" onclick="deleteItems();">{{ __('remove') }}</button>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover datatable">
				<thead>
					<tr>
						<th></th>
						<th>Tên mẫu</th>
						<th>Xử lý</th>
					</tr>
                </thead>
                <tbody> 
                @foreach($templates as $template)
					<tr>
						<td class="tdclick"><input type="checkbox" class="form-control" value="{{$template->id}}" /></td>
                        <td class="tdclick">{{$template->name}}</td>
                        <td>
                            <a href="/{{$template->link}}" download="/{{$template->name}}.docx"> 
                             <button class="btn btn-primary">
                                   Download
                             </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
				<tfoot>
					<tr>
						<th></th>
						<th>Tên mẫu</th>
						<th>Xử lý</th>
					</tr>
                </tfoot>
			</table>
		</div>
	</div>
</div>
<script>
</script>
@endsection
