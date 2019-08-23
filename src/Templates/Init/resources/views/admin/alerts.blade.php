@if(session('success'))
	<div class="card bg-success text-white shadow mb-3">
		<div class="card-body">
			{{session('success')}}
		</div>
	</div>
@endif

@if(session('errors') || session('error'))
	<div class="card bg-danger text-white shadow mb-3">
		<div class="card-body">
			@if(session('errors'))
				<ul class="mb-0">
					@foreach (session('errors')->getMessages() as $error)
						<li>{{$error[0]}}</li>
					@endforeach
				</ul>
			@endif
			{{session('danger')}}
		</div>
	</div>
@endif
