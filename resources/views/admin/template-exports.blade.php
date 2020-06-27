@extends('admin.master')
<head>
<style>
    .update{
        
        display:none;

    }     
    #input_file{
      width:100px;
    }
    #sampleTemplate{
     display:none;
   
    }

</style>
</head>

@section('childHead')

<title>{{ __('templateManagement') }}</title>

@endsection

@section('sub-header')
<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('exportManagementTemplate') }}</h3>

			<span class="kt-subheader__separator kt-subheader__separator--v"></span>

			<span class="total-items">{{ __('total') . ': ' . $total }}</span>
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
			<!-- start table export -->
			<table class="table  table-bordered table-hover datatable" >
				<thead>
						<tr>
							<th></th>
							<th>{{ __('nameTemplate') }}</th>
							<th></th>
						</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th>{{ __('nameTemplate') }}</th>
						<th></th>
					</tr>
				<tfoot>
			</table>
			<!-- end table export -->
		</div>
	</div>
</div>
<script>
		$(document).ready(function() {
		var options = {
			scrollY: '50vh',
			scrollCollapse: true,
			searchDelay: 500,
			columnDefs: [
				{
					orderable: false,
					targets: 0,
					render: function(data, type, full, meta) {
						return '<input type="checkbox" class="form-control" value="' + data + '" />';
					}
				},{
					orderable: false,
					targets: 2,
					render: function(data, type, full, meta) {
						return '<a href="' + data[0] + '" download="'+ data[1] +'.docx"><button type="submit" class="btn btn-primary">Download</button ></a>';
					}
				}
			],
			order: [
				[1, 'asc']
			],
			select: {
				style: 'multi',
				selector: 'td:first-child'
			},
			pageLength: <?= $config['pageSize']; ?>,
			processing: true,
			serverSide: true,
			ajax: '{{ route("admin") }}/template-exports?api=true'
		};

		$('.datatable').DataTable(options).on('draw', function() {
			// setRowClickEvent();
		});
	});
</script>
@endsection	

