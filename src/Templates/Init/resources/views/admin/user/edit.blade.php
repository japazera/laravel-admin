@extends('layouts.admin')

@section('content')
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Usuários</h1>
		<div class="">
			<a href="{{route('user.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-users fa-sm"></i> Lista de Usuários</a>
			<a href="{{route('user.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm"></i> Criar Usuário</a>

		</div>

	</div>

	<!-- Card - Create -->
	<div class="card shadow">

		<!-- Card Head -->

		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold">Editar Usuário <span class="text-primary">{{$user->id}}</span></h6>
			<div class="dropdown no-arrow">
				<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
					<div class="dropdown-header">Ações</div>
					<a href="" data-action="{{route('user.destroy', $user->id)}}" data-toggle="modal" data-target="#deleteModal" class="dropdown-item btn-danger" ><i class="fas fa-user-slash fa-sm"></i> Deletar</a>
				</div>
			</div>
		</div>

		<!-- Card Body -->
		<div class="card-body">

			<form action="{{route('user.update', $user->id)}}" method="post" class="form">
				@csrf
				@method('put')
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="name">Nome</label>
						<input type="text" name="name" value="{{old('name', $user->name)}}" class="form-control">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email</label>
						<input type="text" name="email" value="{{old('email', $user->email)}}" class="form-control">
					</div>
					<div class="form-group col-md-6">
						<label for="email_verified_at">Email verificado em</label>
						<input type="text" name="email_verified_at" value="{{old('email_verified_at', $user->email_verified_at)}}" class="form-control" disabled>
					</div>
					<div class="form-group col-md-6">
						<label for="password">Senha</label>
						<input type="password" name="password" value="" class="form-control">
						<small id="emailHelp" class="form-text text-muted">Deixe em branco para manter a mesma senha</small>

					</div>

					<input type="submit" value="Salvar" class="btn btn-block btn-primary">
				</div>
			</form>

		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel">Você tem certeza?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Essa ação é irreverssível!
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>

					<form class="form" action="{{route('user.destroy', $user->id)}}" method="post">
						@csrf
						@method('delete')
						<input type="submit" value="Deletar" class="btn btn-sm btn-danger">
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('foot')
	<script type="text/javascript">

	$(document).ready(function() {
		$('#myModal').each(function(e){
			$(this).click(function(e) {
				var action = this.dataset.action;
				$('#deleteModal form').attr('action', action);
			});
		});
	});
	</script>
@endsection
