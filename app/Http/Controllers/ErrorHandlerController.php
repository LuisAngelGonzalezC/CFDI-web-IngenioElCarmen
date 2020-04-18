<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ErrorHandlerController extends Controller
{

    public function errorCode404()
    {
    	Session::flash('error', 'Error 404: Página no encontrada');
    	return back();
    }

    public function errorCode405()
    {
    	Session::flash('error', 'Error 405: Página no encontrada');
    	return back();
    }

    public function errorCode419()
    {
    	Session::flash('error', 'Error 419:');
    	return back();
    }
    
    public function errorCode429()
    {
    	Session::flash('error', 'Error 429: Demasiadas peticiones realizadas');
    	return back();
    }
    
    public function errorCode500()
    {
    	Session::flash('error', 'Error 500: Error interno del servidor');
    	return back();
    }

    public function errorCode503()
    {
    	Session::flash('error', 'Error 503: Servicio no disponible');
    	return back();
    }
}
