@if(session()->has('_error'))
	<div class="row">
		<p class="alert alert-danger">{{ session()->get('_error') }}</p>
	</div>
@endif