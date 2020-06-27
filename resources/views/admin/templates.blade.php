@extends('admin.master')

@section('childHead')

<title>{{ __('Templates') }}</title>
@endsection

@section('content')
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">
		<div class="table-responsive">
			<table style="text-align:center" class="table table-striped table-bordered table-hover datatable">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Link</th>
						<th></th>
					</tr>
				</thead>
				<tfoot>
					@php $i = 0; @endphp
					@foreach ($kindOfTemplates as $item)
						<tr>
							<td>{{$i}}</td>
							<td>{{$item->name}}</td>
							<td>{{$item->link}}</td>
							<td>
								<a href="{{route('admin')}}/templates-detail/{{$item->id}}" class="btn btn-primary">Xem</a>
							</td>
						</tr>
						@php $i++; @endphp
					@endforeach
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection
