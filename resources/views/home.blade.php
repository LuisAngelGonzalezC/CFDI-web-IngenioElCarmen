<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Ingenio El Carmen</title>
        <link rel="shortcut icon" href="{{ asset('img/logo_icon.jpg') }}"/>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body style="background-color: #FFF !important;">
        <main class="container center">
            <div class="row hide-on-small-only">
                <br><br><br><br><br>
            </div>
            <div class="row">
                <div class="col m5 s12 offset-m1">
                    <br><br><br>
                    <img class="responsive-img" src="{{ asset('img/logo.jpg') }}">
                </div>
                <div class="col m5 s12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Iniciar sesión</span>
                            {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}
                                <div class="row">
                                    <div class="col s12 input-field inline">
                                        <i class="material-icons prefix">account_box</i>
                                        {{ Form::number('number', null, ['class' => 'validate', 'required', 'autofocus']) }}
                                        {{ Form::label('number', 'Número de empleado', ['data-error'=>'', 'data-success'=>'']) }}
                                        {!! $errors->first('number', '<span class="left red-text text-darken-2">:message</span>') !!}
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 input-field inline">
                                        <i class="material-icons prefix">vpn_key</i>
                                        {{ Form::password('password', ['class' => 'validate','required','minlength'=>'8','maxlength'=>'16']) }}
                                        {{ Form::label('password', 'Contraseña', ['data-error'=>'', 'data-success'=>'']) }}
                                        {!! $errors->first('password', '<span class="left red-text text-darken-2">:message</span>') !!}
                                    </div>
                                </div>                    
                                <div class="row">
                                    <div class="col s12 center">
                                        {{ Form::submit('Ingresar' , ['class' => 'btn teal darken-4']) }}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>    
                </div>
            </div>
        </main>
        <footer class="page-footer white center">
            <div class="footer-copyright">
                <div class="container grey-text text-center">
                    © 2018 Ingenio El Carmen S.A. de C.V. Todos los derechos reservados.
                </div>
            </div>
        </footer>
        <script src="{{ asset('js/app.js') }}"></script>
        @include('partials.alerts')
    </body>
</html>
