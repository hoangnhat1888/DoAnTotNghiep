@extends('admin.master')

@section('childHead')

<title>{{ __('Xin nghỉ phép') }}</title>

@endsection

@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('Xin nghỉ phép') }}</h3>

			<span class="kt-subheader__separator kt-subheader__separator--v"></span>

			<span class="total-items">{{ __('total') . ': ' . $total }}</span>
		</div>
		<div class="kt-subheader__toolbar">
			<button class="btn btn-primary" onclick="agreeItem();">Đồng ý</button>
			<button class="btn btn-primary" onclick="denyItems();">Từ chối</button>
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
						<th>{{ __('Bts_id') }}</th>
						<th>{{ __('name') }}</th>
						<th>{{ __('Email') }}</th>
						<th>{{ __('phoneNumber') }}</th>
						<th>{{ __('dayoff') }}</th>
						<th>{{ __('reason') }}</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th>{{ __('Bts_id') }}</th>
						<th>{{ __('name') }}</th>
						<th>{{ __('Email') }}</th>
						<th>{{ __('phoneNumber') }}</th>
						<th>{{ __('dayoff') }}</th>
						<th>{{ __('reason') }}</th>
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
			}],
			select: {
				style: 'multi',
				selector: 'td:first-child'
			},
			order: [
				[0, 'asc']
			],
			pageLength: <?= $config['pageSize']; ?>,
			processing: true,
			serverSide: true,
			ajax: '{{ route("admin") }}/work-off?api=true'
		};

		$('.datatable').DataTable(options);
	});

	function agreeItem( url = null) {
		let chkCheckeds = $('.datatable').find('input[type=checkbox]:checked');
		chkCheckeds.each(function(){
			var id = $(this).val();
			$.ajax({
				url: (url ? url : location.pathname) + '/' + id,
				method: 'POST',
				data: {
					'_method': 'PATCH',
					'_token': '{{ csrf_token() }}',
					'type':'update'
				},
				success: function(result) {
					if ($(chkCheckeds[chkCheckeds.length - 1]).val() === id) {
						location.reload();
					}
				}
			});
		});
	}

	function denyItems( url = null) {
		let chkCheckeds = $('.datatable').find('input[type=checkbox]:checked');
		chkCheckeds.each(function(){
		var id = $(this).val();

		$.ajax({
				url: (url ? url : location.pathname) + '/' + id,
				method: 'POST',
				data: {
					'_method': 'PATCH',
					'_token': '{{ csrf_token() }}',
					'type':'deny'
				},
				success: function(result) {
					if ($(chkCheckeds[chkCheckeds.length - 1]).val() === id) {
						location.reload();
					}
				}
			});
		});
	}

</script>

@endsection
