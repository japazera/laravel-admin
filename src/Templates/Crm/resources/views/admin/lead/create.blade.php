@extends('layouts.admin')

@section('content')

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Leads</h1>
		<a href="{{route('lead.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-list fa-sm"></i> Lista de Leads</a>
	</div>

	<!-- Card - Create -->
	<div class="card shadow">

		<!-- Card Head -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Criar Lead</h6>
		</div>

		<!-- Card Body -->
		<div class="card-body">

			<form action="{{route('lead.store')}}" method="post" class="form">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="name">Nome</label>
						<input type="text" name="name" value="{{old('name')}}" class="form-control {{$errors->has('name') ? 'is-invalid' : null}}" required>
						@if($errors->has('name'))
							<span class="text-danger">{{ $errors->first('name') }}</span>
						@endif
					</div>

					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="text" name="email" value="{{old('email')}}" class="form-control {{$errors->has('email') ? 'is-invalid' : null}}" required>
						@if($errors->has('email'))
							<span class="text-danger">{{ $errors->first('email') }}</span>
						@endif
					</div>

					<div class="form-group col-md-3">
						<label for="name">Origem</label>
						<input type="text" name="utm_source" value="{{old('utm_source')}}" class="form-control {{$errors->has('utm_source') ? 'is-invalid' : null}}">
						@if($errors->has('utm_source'))
							<span class="text-danger">{{ $errors->first('utm_source') }}</span>
						@endif
					</div>

					<div class="form-group col-md-3">
						<label for="name">Mídia</label>
						<input type="text" name="utm_medium" value="{{old('utm_medium')}}" class="form-control {{$errors->has('utm_medium') ? 'is-invalid' : null}}">
						@if($errors->has('utm_medium'))
							<span class="text-danger">{{ $errors->first('utm_medium') }}</span>
						@endif
					</div>

					<div class="form-group col-md-3">
						<label for="name">Campanha</label>
						<input type="text" name="utm_campaign" value="{{old('utm_campaign')}}" class="form-control {{$errors->has('utm_campaign') ? 'is-invalid' : null}}">
						@if($errors->has('utm_campaign'))
							<span class="text-danger">{{ $errors->first('utm_campaign') }}</span>
						@endif
					</div>

					<div class="form-group col-md-3">
						<label for="name">Termo</label>
						<input type="text" name="utm_term" value="{{old('utm_term')}}" class="form-control {{$errors->has('utm_term') ? 'is-invalid' : null}}">
						@if($errors->has('utm_term'))
							<span class="text-danger">{{ $errors->first('utm_term') }}</span>
						@endif
					</div>

					<input type="submit" value="Save" class="btn btn-block btn-primary">
				</div>
			</form>
		</div>
	</div>
@endsection
