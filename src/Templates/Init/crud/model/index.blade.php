@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1 class="h4 float-left">[MODEL] - List</h1>

				<a href="{{route('[MODEL_LOWER].create')}}" class="btn btn-primary btn-sm float-right">Create</a>

				<div class="clearfix pb-2"></div>

				<div class="table-responsive table-striped">
					<table class="table">
						<thead>
							<tr>
[FIELDS_TH]
							<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach (\App\[MODEL]::all() as $item)
								<tr>
[FIELDS_TD]
									<td>
										<span class="btn btn-sm btn-danger mb-1" data-action="{{route('[MODEL_LOWER].destroy', $item->id)}}" data-toggle="modal" data-target="#deleteModal">Delete</span>
										<a href="{{route('[MODEL_LOWER].edit', $item->id)}}" class="btn btn-sm btn-primary mb-1">Edit</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel">Are you sure?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					This can not be undone.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

					<form class="form" action="" method="post">
						@csrf
						@method('delete')
						<input type="submit" value="Delete" class="btn btn-danger">
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('foot')
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
