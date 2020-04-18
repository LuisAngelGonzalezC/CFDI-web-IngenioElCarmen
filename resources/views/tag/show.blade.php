@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col s12">
			<div class="card-panel center">
				<p><h5>CFDIs: </h5>{{ $tag->name }} </p>
				<a href="#add" class="btn right modal-trigger">
                    <i class="material-icons right">add_box</i>Agregar CFDI
                </a>
                <a href="#edit" class="btn yellow darken-4 right modal-trigger">
                    <i class="material-icons right">edit</i>cambiar nombre
                </a>      
			</div>
		</div>
	</div>
    <div id="edit" class="modal edit-modal">
        <div class="modal-content">
            <h4 class="center-align">Cambiar nombre de la etiqueta</h4>
            <div class="row">
                {!! Form::open(['route' => ['tag.update',$tag->id], 'method' => 'PUT']) !!}
                    {{ Form::token() }}
                    <div class="col s12 input-field inline">
                        {{ Form::text('name', $tag->name, ['class' => 'validate', 'required', 'autofocus']) }}
                        {{ Form::label('name', 'Nombre', ['data-error'=>'', 'data-success'=>'']) }}
                    </div>
                    <div class="col s12">          
                        <a 1="#!" class="remove-data-from-delete-form modal-action modal-close btn-flat right">Cancelar</a>
                        {{ Form::submit('Cambiar', ['class' => 'btn-flat right']) }}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>        
    </div>

    <div id="add" class="modal add-modal">
        <div class="modal-content">
            <h4 class="center-align">Ingrese los archivos</h4>
            <div class="row">
                {!! Form::open(['route' => ['cfdi.store'], 'method' => 'POST', 'files' => 'true']) !!}
                    {{ Form::token() }}
                    <div class="col s12 file-field input-field">
                        <div class="btn">
                            <span>Archivos</span>
                            {{ Form::hidden('tag',$tag->id) }}
                            {{ Form::file('file[]',['multiple'=>'multiple', 'required']) }}
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Cargue uno o mas archivos">
                      </div>
                    </div>
                    <div class="col s12">          
                        <a 1="#!" class="remove-data-from-delete-form modal-action modal-close btn-flat right">Cancelar</a>
                        {{ Form::submit('Agregar', ['class' => 'btn-flat right']) }}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>        
    </div>
    <div id="edit-cfdi" class="modal edit-cfdi-modal">
        <div class="modal-content">
            <h4 class="center-align">Ingrese el archivo para remplazar</h4>
            <div class="row">
                {!! Form::open(['url' => '', 'method' => 'PUT', 'files' => 'true', 'class' => 'edit-cfdi-modal-form']) !!}
                    {{ Form::token() }}
                    <div class="col s12 file-field input-field">
                        <div class="btn">
                            <span>Archivo</span>
                            {{ Form::hidden('tag', $tag->id) }}
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
            {{ Form::hidden('tag', $tag->id) }}
            {{ Form::submit('Eliminar',['class'=>'modal-action btn-flat']) }}
            <a href="#!" class="remove-data-from-delete-form modal-action modal-close btn-flat">Cancelar</a>
        {!! Form::close() !!}
    </div>
    <div class="row">
        <div class="col s12">
        	<div class="card">
        		<div class="card-content">
        			<table id="cfdi-table" class="display bordered hightlight centered responsive-table" cellpadding="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha de registro</th>
                                <th>Operaciones</th>
                                <th>Enviar</th>
                            </tr>
                        </thead>
                    </table>
        		</div>
        	</div>
        </div>
    </div>      
@endsection
@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
    <script>
        $(document).ready(function(e) {
            oTable = $('#cfdi-table').DataTable({

                //Modificar cuantos usuarios se podrán visualizar cuando se realizar la carga de la página
                //pageLength: 10,
                processing: true,
                serverSide: true,
                ajax: '{!! route('api.cfdi', ['id' => $tag->id]) !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, seachable: false },
                    { data: 'send', name: 'send', orderable: false, seachable: false }
                ],
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
            $("select").val('10');
            $('select').addClass("browser-default");
            $('select').material_select();
        });
    </script>
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
                $('#remove-cfdi-modal').attr('action', url);
            });
        });
    </script>
    <script>
        $(document).ready(function (e) {
            $(document).on("click", ".edit-cfdi", function (e) {
                var url = $(this).attr('data-value');
                $('.edit-cfdi-modal-form').attr('action', url);
            });
        });
    </script>
@endpush