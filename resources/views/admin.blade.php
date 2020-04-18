@extends('layouts.admin', ['dashboard' => '1'])
@section('content')
<div class="row hide-on-small-only">
                <br><br>
            </div>
            <br>      
            <div class="row center">
                <div class="col s12 l4 offset-l1">
                    <a href="{{ route('user.index') }}" class="orange-text text-darken-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <h2>Empleados</h2>
                                </div>
                                <div class="row">
                                    <i class="material-icons large">group</i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s12 l4 offset-l2">
                    <a href="{{ route('tag.index') }}" class="orange-text text-darken-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <h2>CFDIs</h2>
                                </div>
                                <div class="row">
                                    <i class="material-icons large">insert_drive_file</i>
                                </div>
                            </div>
                        </div>    
                    </a>
                </div>
            </div>
@endsection