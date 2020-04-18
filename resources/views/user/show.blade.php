@extends('layouts.admin')
@section('content')
	<div id="edit-cfdi" class="modal edit-cfdi-modal">
        <div class="modal-content">
            <h4 class="center-align">Ingrese el archivo para remplazar</h4>
            <div class="row">
                {!! Form::open(['url' => '', 'id' => 'edit-cfdi-modal-form', 'method' => 'PUT', 'files' => 'true']) !!}
                    {{ Form::token() }}
                    <div class="col s12 file-field input-field">
                        <div class="btn">
                            <span>Archivo</span>
                            {{ Form::hidden('tag','1',['class'=>'hidden-edit-cfdi']) }}
                            {{ Form::file('file',['required']) }}
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Cargue uno o mas archivos">
                      </div>
                    </div>
                    <div class="col s12">          
                        <a 1="#!" class="modal-action modal-close btn-flat right">Cancelar</a>
                        {{ Form::submit('Agregar', ['class' => 'btn-flat right']) }}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>        
    </div>
    <div id="delete" class="modal delete-modal">
        <div class="modal-content center">
            <h4>¿Seguro que deseas eliminar el CFDI?</h4>
        </div>
        {!! Form::open(['url' => '', 'id'=>'remove-cfdi-modal', 'method' => 'delete','class'=>'modal-footer']) !!}
            {{ Form::token() }}
            {{ Form::hidden('tag','1',['class'=>'hidden-delete-cfdi']) }}
            {{ Form::submit('Eliminar',['class'=>'modal-action btn-flat']) }}
            <a href="#!" class="remove-data-from-delete-form modal-action modal-close btn-flat">Cancelar</a>
        {!! Form::close() !!}
    </div>
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<h5 class="center">Número de empleado: {{ $user->number }}</h5>
                <a href="{{ route('user.edit',$user->id) }}" class="btn yellow darken-4 right">
                    <i class="material-icons right">edit</i>Editar
                </a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					<div class="row">
						<div class="col s12">
							<h5>Datos generales</h5>
						</div>
						<div class="col s12 m6">
							<ul class="collection">
								<li class="collection-item grey white-text">Nombre completo</li>
						    	<li class="collection-item">{{ $user->name.' '.$user->last_name.' '.$user->second_last_name }}</li>
						    	<li class="collection-item grey white-text">Correo electrónico</li>
						    	<li class="collection-item">
						    		
						    		@if(!is_null($user->email))
						    		{{ $user->email }}						    		
						    		@else
						    			<p class="orange-text text-darken-3">
						    				Actualmente el usuario no tiene ningún correo electrónico registrado
						    				<i class="material-icons left">warning</i>
						    			</p>
						    		@endif
						    	</li>
						    	<li class="collection-item grey white-text">Tipo de usuario</li>
						    	<li class="collection-item">
						    		@if($user->type == 0)
						    			Usuario
						    		@else
										Administrador
						    		@endif
						    	</li>
						    </ul>
						</div>
						<div class="col s12 l6">
							<ul class="collection">
								<li class="collection-item grey white-text">CURP</li>
						    	<li class="collection-item">{{ $user->curp }}</li>
								<li class="collection-item grey white-text">RFC</li>
						    	<li class="collection-item">{{ $user->rfc }}</li>
						    	<li class="collection-item grey white-text">Número de seguro social</li>
						    	<li class="collection-item">{{ $user->imss }}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					<div class="row">
						<div class="col s12">
							<h5>CFDIs</h5>
						</div>
						<div class="col s12">
							@if(count($cfdis))
								<table class="centered striped responsive-movil">
									<thead>
										<tr>
											<th>
												Formato
											</th>
											<th>
												Etiqueta
											</th>
											<th>
												Fecha de registro
											</th>
											<th>
												Operaciones
											</th>
										</tr>
									</thead>
									<tbody>
										@foreach($cfdis as $cfdi)
											<tr>
												<td>
													@php
													$array = explode('.', $cfdi->name);
													@endphp
													@if ($array[1] === 'pdf')
														<div class="chip red lighten-3" style="font-weight: bold;">
															PDF
														</div>
													@elseif($array[1] === 'xml')
													<div class="chip light-green lighten-3">
														XML
													</div>
													@endif
												</td>
												<td>
													{{ link_to_route('readCFDI', $title = $cfdi->tag->name, $parameters = ['cfdi' => $cfdi->name, 'tag' => $cfdi->tag->name], $attributes = ['target'=>'_blank']) }}
												</td>
												<td>{{ $cfdi->created_at }}</td>
												<td>
													{{ link_to_route('getCFDI', 'Descargar', $parameters = ['cfdi' => $cfdi->name, 'tag' => $cfdi->tag->name], $attributes = ['class' => 'btn green', 'target'=>'_blank']) }}
													<a class="btn purple modal-trigger edit-cfdi" href="#edit-cfdi" data-value="{{ route('cfdi.update',$cfdi->id) }}" data-tag="{{ $cfdi->tag_id }}">Remplazar</a>
													<a class="btn red modal-trigger remove-cfdi" role="button" href="#delete" data-value="{{ route('cfdi.destroy',$cfdi->id) }}" data-tag="{{ $cfdi->tag_id }}">Eliminar</a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@else
							<h6 class="center-align">No hay ningún registro</h6>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
        $('.edit-modal').modal();
        $('.edit-cfdi-modal').modal();
        $('.add-modal').modal();
        $('.delete-modal').modal();
    </script>
    <script>
        $(document).ready(function (e) {
            $(document).on("click", ".remove-cfdi", function (e) {
                var url = $(this).attr('data-value');
                var tag = $(this).attr('data-tag');
                $('#remove-cfdi-modal').attr('action', url);
                $('.hidden-delete-cfdi').attr('value', tag);
            });
            $(document).on("click", ".edit-cfdi", function (e) {
                var url = $(this).attr('data-value');
                var tag = $(this).attr('data-tag');
                $('#edit-cfdi-modal-form').attr('action', url);
                $('.hidden-edit-cfdi').attr('value', tag);
            });
        });
    </script>
@endpush