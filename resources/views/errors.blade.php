@if ($errors->any())

<div class="row">
	<div class="col-xl-12">
		<div class="errors alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)

				<li>{{ __($error) }}</li>

				@endforeach
			</ul>
		</div>
	</div>
</div>

@endif