@extends('admin.master')
@section('childHead')
<title>{{ __('listWorkTimes') }}</title>
@endsection
@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('listWorkTimes') }}</h3>

			<span class="kt-subheader__separator kt-subheader__separator--v"></span>

			<span class="total-items">{{ __('total') . ': ' . $total }}</span>
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
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var options = {
			scrollY: '50vh',
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
			ajax: '{{ route("admin") }}/list-employee?api=true'
		};

		$('.datatable').DataTable(options).on('draw', function() {
			$('.datatable tr').click(function() {
				if ($($(this).children()[0]).prop('tagName') !== 'TH') {
					var id = $(this).find('input[type=checkbox]').val();
					if (id) {
						showItem(id);
					}
				}
			});
		});
	});
	function showItem(id, url = null) {
			location.href = (url ? url : location.pathname) + '/' + id + '/show';
		}
</script>

@endsection
