@extends('admin.master')

@section('childHead')

<title>{{ __('usersManagement') }}</title>

@endsection

@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('usersManagement') }}</h3>

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
			<table class="table table-striped table-bordered table-hover datatable">
				<thead>
					<tr>
						<th></th>
						<th>{{ __('name') }}</th>
						<th>{{ __('username') }}</th>
						<th>{{ __('email') }}</th>
						<th>{{ __('phoneNumber') }}</th>
						<th>{{ __('position') }}</th>
						<th>{{ __('startDate') }}</th>
						<th>{{ __('signingDate') }}</th>
						<th>{{ __('signingTerm') }}</th>
						<th>{{ __('endDate') }}</th>
						<th>{{ __('annualLeave') }}</th>
						<th>{{ __('remainingDays') }}</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<!-- 0 -->
						<th></th>
						<!-- 1 -->
						<th>{{ __('name') }}</th>
						<!-- 2 -->
						<th>{{ __('username') }}</th>
						<!-- 3 -->
						<th>{{ __('email') }}</th>
						<!-- 4 -->
						<th>{{ __('phoneNumber') }}</th>
						<!-- 5 -->
						<th>{{ __('position') }}</th>
						<!-- 6 -->
						<th>{{ __('startDate') }}</th>
						<!-- 7 -->
						<th>{{ __('signingDate') }}</th>
						<!-- 8 -->
						<th>{{ __('signingTerm') }}</th>
						<!-- 9 -->
						<th>{{ __('endDate') }}</th>
						<!-- 10 -->
						<th>{{ __('annualLeave') }}</th>
						<!-- 11 -->
						<th>{{ __('remainingDays') }}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var options = {
			scrollX: '100%',
			scrollY: '50vh',
			responsive: false,
			scrollCollapse: true,
			searchDelay: 500,
			columnDefs: [{
				orderable: false,
				targets: 0,
				render: function(data, type, full, meta) {
					return '<input type="checkbox" class="form-control" value="' + data + '" />';
				}
			}, {
				orderable: false,
				targets: 1
			}, {
				orderable: false,
				targets: 4
			}, {
				orderable: false,
				targets: 5
			}, {
				orderable: false,
				targets: 10
			}, {
				orderable: false,
				targets: 11
			}],
			select: {
				style: 'multi',
				selector: 'td:first-child'
			},
			order: [
				[2, 'asc']
			],
			pageLength: <?= $config['pageSize']; ?>,
			processing: true,
			serverSide: true,
			ajax: '{{ route("admin") }}/users?api=true'
		};

		$('.datatable').DataTable(options).on('draw', function() {
			setRowClickEvent();

			session.getData('userId');
			session.setData('userId', 'asaassaas');
			session.containKey('userId');
			session.clearData('userId');
			session.clearSessions();
		});
	});
</script>

@endsection