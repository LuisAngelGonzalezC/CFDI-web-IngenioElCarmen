@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<h5 class="center">Editar empleado: {{ $user->number }}</h5>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					{!! Form::open(['route' => ['user.update',$user->id], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
						{{ Form::token() }}
						@include('user.form')
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection