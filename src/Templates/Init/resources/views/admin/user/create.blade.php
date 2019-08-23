@extends('layouts.admin')

@section('content')

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Usuários</h1>
		<a href="{{route('user.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-users fa-sm"></i> Lista de Usuários</a>
	</div>

	<!-- Card - Create -->
	<div class="card shadow">

		<!-- Card Head -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Criar Usuário</h6>
		</div>

		<!-- Card Body -->
		<div class="card-body">

			<form action="{{route('user.store')}}" method="post" class="form">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="name">Nome</label>
						<input type="text" name="name" value="{{old('name')}}" class="form-control">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="text" name="email" value="{{old('email')}}" class="form-control">
					</div>
					<div class="form-group col-md-12">
						<label for="password">Senha</label>
						<input type="password" name="password" value="{{old('password')}}" class="form-control">
					</div>

					<input type="submit" value="Save" class="btn btn-block btn-primary">
				</div>
			</form>
		</div>
	</div>

@endsection
