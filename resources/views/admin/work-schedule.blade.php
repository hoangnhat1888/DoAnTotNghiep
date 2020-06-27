@extends('admin.master')
@section('childHead')
<title>{{ __('workScheduleManagement') }}</title>
@endsection
@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('workScheduleManagement') }}</h3>

			<span class="kt-subheader__separator kt-subheader__separator--v"></span>

			<span class="total-items">{{ __('total') . ': ' . $total }}</span>
		</div>
		<div class="kt-subheader__toolbar">
			<button class="btn btn-primary" onclick="addItemSchedule();">{{ __('add') }}</button>
			<button class="btn btn-primary" onclick="deleteItems();">{{ __('remove') }}</button>
		</div>
	</div>
</div>

@endsection

@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover datatable dt-body-center">
				<thead>
					<tr>
						<th class="text-center "></th>
						<th class="text-center">{{ __('name')}}</th>
						<th class="w-auto text-center ">{{ __('monday') }}</th>
						<th class="w-auto text-center ">{{ __('tuesday') }}</th>
						<th class="w-auto text-center ">{{ __('wednesday') }}</th>
						<th class="w-auto text-center ">{{ __('thursday') }}</th>
						<th class="w-auto text-center ">{{ __('friday') }}</th>
						<th class="w-auto text-center ">{{ __('saturday') }}</th>

					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="text-center "></th>
						<th class="text-center ">{{ __('name') }}</th>
						<th class="w-auto text-center ">{{ __('monday') }}</th>
						<th class="w-auto text-center ">{{ __('tuesday') }}</th>
						<th class="w-auto text-center ">{{ __('wednesday') }}</th>
						<th class="w-auto text-center ">{{ __('thursday') }}</th>
						<th class="w-auto text-center ">{{ __('friday') }}</th>
						<th class="w-auto text-center ">{{ __('saturday') }}</th>

					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<script>
		$(document).ready(function() {
			var options = {

				scrollCollapse: true,
				searchDelay: 500,
				ordering: false,
				columnDefs: [{
					orderable: false,
					targets: 0,
					width: "3%",
					render: function(data, type, full, meta) {
						return '<input type="checkbox" class="form-control" value="' + data + '"/>';
				}
				}, {
				orderable: false,
				targets: 1,
				width: "20%",
				className: 'text-center'
				}, {
				orderable: false,
				targets: 2,
				className: 'text-center'
				}, {
				orderable: false,
				targets: 3,
				className: 'text-center'
				}, {
				orderable: false,
				targets: 4,
				className: 'text-center'
				}, {
				orderable: false,
				targets: 5,
				className: 'text-center'
				}, {
				orderable: false,
				targets: 6,
				className: 'text-center'
				}, {
				orderable: false,
				targets: 7,
				className: 'text-center'
				}],

				pageLength: <?= $config['pageSize']; ?>,
				processing: true,
				serverSide: true,
				ajax: '{{ route("admin") }}/work-schedule?api=true'
			};

			$('.datatable').DataTable(options).on('draw', function() {
				setRowClickEvent();
			});

		});

		function addItemSchedule(url = null) {
			let chkCheckeds = $('.datatable').find('input[type=checkbox]:checked');

			if (chkCheckeds.length>1) {
				alert("Only check 1 to create new schedule");
			}
			else if (chkCheckeds.length == 1){
				var id = $(chkCheckeds).val();
				location.href = (url ? url : location.pathname) +'/'+id+'/create';
			}else{
				alert("Hong co dzui");
			}
		}

	</script>
@endsection
