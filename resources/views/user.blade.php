@extends('layouts.user')
@section('content')
	<div class="row hide-on-small-only">
	    <br><br>
	</div>
	<!-- Logout-Modal -->
    <div id="email" class="modal email-modal">
        <div class="modal-content center">
            <h4>Correo electrónico</h4>
            <blockquote class="left-align">
	    		<b>Nota:</b>
	    		@if(count(Auth::user()->email))
	    		@if(Auth::user()->confirmed === 0)
					Por favor revisa en tu bandeja de entrada el mensaje de verificación de tu correo electrónico.
	    		@else
					Gracias por registrar tu cuenta.
	    		@endif
		    	@else
		    		Agrega un correo electrónico para poder recibir tus CFDIs al instante.
		    	@endif
	    	</blockquote>    	
	        <ul class="collapsible" data-collapsible="accordion">
	        	<li>
			    	<div class="collapsible-header"><i class="material-icons">email</i>Correo electrónico</div>
			    	<div class="collapsible-body">
			    		<div class="row">
			    			<div class="col s12 left-align">
			    				@if(count(Auth::user()->email))
						    		@if(Auth::user()->confirmed === 0)
										Si necesitas enviar de nuevo el mensaje de verificación, da clic en el botón "enviar".
						    		@endif
						    		@if(Auth::user()->confirmed === 1)
										Si necesitas cambiar el correo electrónico remplázalo aquí.
						    		@endif
						    	@endif
			    			</div>
			    		</div>
			    		{!! Form::open(['route'=>['email.verify',Auth::user()->id], 'method'=>'POST']) !!}
				            {{ Form::token() }}
				            <div class="row">
				            	<div class="input-field col s12">
						        	<i class="material-icons prefix">email</i>
						        	{{ Form::email('email', (count(Auth::user()->email)) ? Auth::user()->email : NULL, ['class'=>'validate', 'required']) }}
						        	{{ Form::label('email', 'Correo electrónico') }}
						        </div>
						        <div class="col s12">
						        	{{ Form::submit((count(Auth::user()->email)) ? 'Enviar' : 'Agregar',['class'=>'btn orange right']) }}
						        </div>
				            </div>
				        {!! Form::close() !!}
			    	</div>
			    </li>
	            
	        </ul>
        </div>
    </div>
	<div class="row">
		<div class="col l12">
			<div class="card-panel center-align">
				@if(count($cfdis))
					<table class="centered striped highlight responsive-table">
						<thead>
							<tr>
								<th>Formato</th>
								<th>Descripción</th>
								<th>Fecha de registro</th>
								<th>Operación</th>
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
										{{ $cfdi->tag->name }}
									</td>
									<td>{{ $cfdi->created_at }}</td>
									<td>
										{{
	                                        link_to_route('getFile', $title = 'Descargar', $parameters = ['cfdi' => $cfdi->id, 'tag' => $cfdi->tag_id], $attributes = ['class'=>'btn blue darken-3', 'target'=>'_blank'])
	                                    }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
				<h4>Sin registro</h4>
				<p>Actualmente no tienes ningún CFDI registrado, en caso de necesitar información contácta al departamento de informática.</p>
				@endif
			</div>
		</div>
	</div>
@endsection
@push('scripts')
<script>
	$('.email-modal').modal();
    $('.collapsible').collapsible();
</script>
@endpush