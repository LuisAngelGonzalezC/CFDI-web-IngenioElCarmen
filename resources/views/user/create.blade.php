@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<h5 class="center">Agregar empleados</h5>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					{!! Form::open(['route' => 'user.store', 'method' => 'POST']) !!}
						{{ Form::token() }}
						@include('user.form')		
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection