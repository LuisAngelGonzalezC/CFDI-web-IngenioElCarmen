@extends('layouts.admin')
@section('content')
	<div class="row">
		<div class="col s12">
			<div class="card-panel">
				<h5 class="center">Empleados</h5>
                <a href="{{ route('user.create') }}" class="btn yellow darken-4 right">
                    <i class="material-icons right">add_box</i>Agregar
                </a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<div class="card card-users-table">
				<table id="users-table" class="display bordered hightlight centered responsive-table" cellpadding="0" width="100%">
                    <thead>
	                	<tr>
	                		<th>Número de empleado</th>
	                        <th>Nombre</th>
	                        <th>Apellido paterno</th>
	                        <th>Apellido materno</th>
	                        <th>Operaciones</th>
	                    </tr>
	                </thead>
				</table>
			</div>
		</div>
	</div>
    <div id="delete" class="modal delete-modal">
        <div class="modal-content center">
            <h4>¿Seguro que deseas eliminar al usuario?</h4>
        </div>
        {!! Form::open(['url' => '', 'id'=>'remove-user-modal', 'method' => 'delete','class'=>'modal-footer']) !!}
            {{ Form::token() }}
            {{ Form::submit('Eliminar',['class'=>'modal-action btn-flat']) }}
            <a href="#!" class="remove-data-from-delete-form modal-action modal-close btn-flat">Cancelar</a>
        {!! Form::close() !!}
    </div>
@endsection
@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        oTable = $('#users-table').DataTable({
        	//Modificar cuantos usuarios se podrán visualizar cuando se realizar la carga de la página
        	//pageLength: 10,
            processing: true,
            serverSide: true,
            ajax: '{!! route('api.user') !!}',
            columns: [
                { data: 'number', name: 'number'},
                { data: 'name', name: 'name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'second_last_name', name: 'second_last_name' },
                { data: 'action', name: 'action', orderable: false, seachable: false }
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
        
        $('.delete-modal').modal();
    });
</script>
<script>
    $(document).ready(function (e) {
        $(document).on("click", ".remove-user", function (e) {
            var url = $(this).attr('data-value');
            $('#remove-user-modal').attr('action', url);
        });
    });
</script>
@endpush