@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<h5 class="center">CFDIs</h5>
				<a href="#addCFDIs" class="btn yellow darken-4 right modal-trigger">
                    <i class="material-icons right">add_box</i>Agregar
                </a>
			</div>
		</div>
	</div>
    <div id="addCFDIs" class="modal addcfdis-modal">
        {!! Form::open(['route' => 'tag.store', 'method' => 'POST', 'files' => 'true']) !!}
        {{ Form::token() }}
        <div class="modal-content center">
            <div class="row">
                <div class="col s12">
                    <h4>Agregar CFDIs</h4>
                </div>
                <div class="col s12 input-field">
                    <i class="material-icons prefix">attach_file</i>
                    {{ Form::text('name', null, ['class' => 'validate', 'id' => 'icon_prefix', 'required']) }}
                    <label for="icon_prefix">Nombre de etiqueta</label>
                </div>
                <div class="col s12 file-field input-field">
                    <div class="btn">
                        <span>Archivos</span>
                        {{ Form::file('file[]',['multiple'=>'multiple','required']) }}
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Cargue uno o mas archivos">
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {{ Form::submit('Agregar', ['class' => 'modal-action btn-flat']) }}
            <a href="#!" class="modal-action modal-close btn-flat">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
    <div id="deleteCFDIs" class="modal deletecfdis-modal">
        <div class="modal-content center">
            <div class="row">
                <div class="col s12">
                    <h4>¿Estás seguro que deseas eliminar todos los CFDIs?</h4>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        {!! Form::open(['url' => '', 'method' => 'DELETE', 'id' => 'remove-tag-modal']) !!}
            {{ Form::token() }}
            {{ Form::submit('Eliminar',['class'=>'modal-action btn-flat']) }}
            <a href="#!" class="modal-action modal-close btn-flat">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content center">
                    @if(count($tags))
                        <table class="centered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha de registro</th>
                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->created_at }}</td>
                                    <td>
                                        <a class="btn blue" href="{{ route('tag.show', $tag->id) }}">Revisar</a>
                                        
                                        <a class="btn red remove-tag modal-trigger" href="#deleteCFDIs" data-value="{{ route('tag.destroy',$tag->id) }}">Eliminar</a>

                                        {{ link_to_route('tag.send', $title = 'Enviar', $parameters = ['tag' => $tag->id], $attributes = ['class'=>'btn purple darken-3']) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h5>No existe ningún registro</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>      
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('.addcfdis-modal').modal();
    });
</script>
<script>
    $('.deletecfdis-modal').modal();
</script>
<script>
    $(document).ready(function (e) {
        $(document).on("click", ".remove-tag", function (e) {
            var url = $(this).attr('data-value');
            $('#remove-tag-modal').attr('action', url);
        });
    });
</script>
@endpush