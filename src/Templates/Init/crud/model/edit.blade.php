@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<h1 class="h4 float-left">[MODEL] - Edit</h1>

				<a href="{{route('[MODEL_LOWER].index')}}" class="btn btn-secondary btn-sm float-right">Back</a>

				<div class="clearfix pb-2"></div>
				<hr>
				<form action="{{route('[MODEL_LOWER].store')}}" method="post" class="form">
					@csrf
[FIELDS_FORM_GROUP]

					<input type="submit" value="Save" class="btn btn-block btn-primary">
				</form>
			</div>
		</div>
	</div>

@endsection
