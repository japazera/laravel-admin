@extends('layouts.admin')

@section('head')
	<!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	  <h1 class="h3 mb-0 text-gray-800">Usuários</h1>
	  <a href="{{route('user.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm"></i> Criar Usuário</a>
	</div>

	<!-- Card - Lista de Usuários -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>Email</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						@foreach (\App\User::all() as $item)
							<tr>
								<td>{{$item->id}}</td>
								<td>{{$item->name}}</td>
								<td>{{$item->email}}</td>
								<td>
									<a href="{{route('user.edit', $item->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-user-edit fa-sm"></i> Editar</a>

									<span class="btn btn-sm btn-danger" data-action="{{route('user.destroy', $item->id)}}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-user-slash fa-sm"></i> Deletar</span>
								</td>

							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
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

					<form class="form" action="" method="post">
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

	<!-- Page level plugins -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {
		$('span[data-target="#deleteModal"]').each(function(e){
			$(this).click(function(e) {
				var action = this.dataset.action;
				$('#deleteModal form').attr('action', action);
			});
		});
	});
	</script>

@endsection
