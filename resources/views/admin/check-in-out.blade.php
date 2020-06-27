@extends('admin.master')
@section('childHead')
<title>{{ __('timeInOutManagement') }}</title>
@endsection
 
@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('timeInOutManagement') }}</h3>

			<span class="kt-subheader__separator kt-subheader__separator--v"></span>

			<span class="total-items">{{ __('total') . ': ' . $total }}</span>
		</div>
		<div class="kt-subheader__toolbar">
			<a href="admin/list-employee/create/{{$users[0]->user_id}}"><button class="btn btn-primary">{{ __('add') }}</button></a>
            <button class="btn btn-primary" onclick="deleteItems();">{{ __('remove') }}</button>
		</div>
	</div>
</div>

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
					{{ __('timeInOutManagement') }} <i class="fas fa-angle-double-right"></i> {{ strtoupper($name) }}
				</h3>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover datatable">
  			    <thead>
                    <tr>
                        <th></th>
                        <th>{{ __('id') }}</th>
                        <th>{{ __('direction') }}</th>
                        <th>{{ __('interactive_date') }}</th>
                        <th>{{ __('interactive_time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <input class="form-control" type="checkbox" name="checkbox" value="{{$user->id}}">
                            </td>
                            <td>{{$user->id}}</td>
                            <td>{{$user->direction}}</td>
                            <td>{{$user->interactive_date}}</td>
                            <td>{{$user->interactive_time}}</td>  
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
					<tr>
                        <th></th>
						<th>id</th>
						<th>{{ __('direction') }}</th>
						<th>{{ __('interactive_date') }}</th>
						<th>{{ __('interactive_time') }}</th>
					</tr>
				</tfoot>
            </table>
        </div>
    </div>
</div>
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
        <label class="">{{ __('totalTimeWork') }}: {{$total_time_work}} ngày</label>
        <label class="">{{ __('totalSalary') }}: {{$salary}} vnđ</label>
    </div>
</div>

<script>
	$(document).ready(function() {
		var options = {
			scrollY: '50vh',
			scrollCollapse: true,
			searchDelay: 500,
			select: {
				style: 'multi',
				selector: 'td:first-child'
			},
			order: [
				[2, 'asc']
			]
		};
		$('.datatable').DataTable();
		$('.datatable tbody tr').click( function() {
			//if ($($(this).children()[]).prop('tagName') == 'TD') {
				var id = $(this).find('input[type=checkbox]').val();
				if (id) {
					editItem(id);
				}
			//}
		});
		$('.datatable tr td:first-child').children().each(function() {
				$(this).parent().click(function(e) {
					e.stopPropagation();
				});
		});
    });
</script>

@endsection
