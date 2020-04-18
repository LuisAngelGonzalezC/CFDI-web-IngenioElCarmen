<div class="row">
	<div class="col s12 l4 input-field inline">
		{{ Form::text('name', (isset($user->name))? $user->name : null, ['class' => 'validate', 'required', 'autofocus']) }}
        {{ Form::label('name', 'Nombre(s)', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('name', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
	<div class="col s12 l4 input-field inline">
		{{ Form::text('last_name', (isset($user->last_name))? $user->last_name : null, ['class' => 'validate', 'required']) }}
        {{ Form::label('last_name', 'Apellido paterno', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('last_name', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
	<div class="col s12 l4 input-field inline">
		{{ Form::text('second_last_name', (isset($user->second_last_name))? $user->second_last_name : null, ['class' => 'validate', 'required']) }}
        {{ Form::label('second_last_name', 'Apellido materno', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('second_last_name', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
</div>
<div class="row">
	<div class="col s12 l6 input-field inline">
		{{ Form::text('rfc', (isset($user->rfc))? $user->rfc : null, ['class' => 'validate', 'required']) }}
        {{ Form::label('rfc', 'RFC', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('rfc', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
	<div class="col s12 l6 input-field inline">
		{{ Form::text('curp', (isset($user->curp))? $user->curp : null, ['class' => 'validate', 'required']) }}
        {{ Form::label('curp', 'CURP', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('curp', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
</div>
<div class="row">
	<div class="col s12 l6 input-field inline">
		{{ Form::text('imss', (isset($user->imss))? $user->imss : null, ['class' => 'validate', 'required']) }}
        {{ Form::label('imss', 'Número de seguro social', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('imss', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
	<div class="col s12 l6 input-field inline">
		{{ Form::number('number', (isset($user->number))? $user->number : null, ['class' => 'validate', 'required']) }}
        {{ Form::label('number', 'Número de empleado', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('number', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
</div>
<div class="row">
	<div class="col s12 l6 input-field inline">
		{{ Form::email('email', (isset($user->email))? $user->email : null, ['class' => 'validate']) }}
        {{ Form::label('email', 'Correo electrónico (opcional)', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('email', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
	<div class="col s12 l6">
		<p>Tipo de usuario</p>
		<p>
			<input name="type" type="radio" value="0" id="usuario" required
			@if(isset($user->type))
				@if($user->type === 0)
					checked="checked"
				@endif
			@endif
			/>
      		<label for="usuario">Usuario</label>
      		<input name="type" type="radio" value="1" id="administrador" 
			@if(isset($user->type))
				@if($user->type === 1)
					checked="checked"
				@endif
			@endif
      		/>
      		<label for="administrador">Administrador</label>
		</p>
		{!! $errors->first('type', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
</div>
<div class="row">
	@if(isset($user))
		<div class="col s12">
			<blockquote>
				<i class="material-icons left">help</i>Si necesitas restablecer la contraseña, por favor ingresa los datos (de lo contrario hacer caso omiso).
			</blockquote>
		</div>
	@endif
	<div class="col s12 l6 input-field inline">
		
		{{ Form::password('password', ['class' => 'validate', 'minlength'=>'8', 'maxlength'=>'16', (empty($user))? 'required' : '']) }}
        {{ Form::label('password', 'Contraseña', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('password', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
	<div class="col s12 l6 input-field inline">
		{{ Form::password('repeat_password', ['class' => 'validate', 'minlength'=>'8','maxlength'=>'16', (empty($user))? 'required' : '']) }}
        {{ Form::label('repeat_password', 'Repite la contraseña', ['data-error'=>'', 'data-success'=>'']) }}
        {!! $errors->first('repeat_password', '<span class="left red-text text-darken-2">:message</span>') !!}
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="row">
			<div class="col s6">
				{{ Form::submit('Registrar', ['class' => 'btn blue right']) }}
			</div>
			<div class="col s6">
				{{Form::reset('Borrar', ['class' => 'btn green'])}}
			</div>
		</div>
	</div>
</div>