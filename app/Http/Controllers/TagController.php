<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\CfdiEmail;
use App\User;
use App\Tag;
use App\Cfdi;
use Session;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','admin','revalidate']);
    }
    
    public function send($id)
    {
        $tag = Tag::find($id);

        $cfdis = DB::table('cfdis')
            ->select('cfdis.id','cfdis.name','users.email')
            ->join('tags', 'cfdis.tag_id', '=', 'tags.id')
            ->where('tags.id','=', $id)
            ->join('users', 'cfdis.user_id', '=', 'users.id')
            ->where('users.confirmed','=', true)
            ->get();
        
        foreach ($cfdis as $cfdi) {
            Mail::to($cfdi->email)->send(new CfdiEmail($cfdi, $tag));
        }
        Session::flash('success', 'CFDIs enviados correctamente');
        return back();
    }

    public function index()
    {
        $tags = Tag::all();
        return view('tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Crear directorio
        $directory = 'public/'.$request->name;
        Storage::makeDirectory($directory);
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->save();

        $tag_id = $tag->id;

        foreach ($request->file as $file) {
            //Capturar el número de empleado
            $array = explode(' ', $file->getClientOriginalName());
            $user_id = $array[1];          

            //Validar que la extensión sea pdf
            if ($file->getClientOriginalExtension() == 'pdf' || $file->getClientOriginalExtension() == 'xml') {
                   
                //Validar si existe un usuario con el número del archivo
                if (! is_null($instance = User::where('number', $user_id)->first())) {
                    
                    //Guardar el nombre del archivo en una variable
                    $filename = $file->getClientOriginalName();

                    //Almacenamiento
                    Storage::putFileAs($directory, $file, $filename);
                    
                    //Guardado en la Base de datos
                    $cfdi = new Cfdi;
                    $cfdi->user_id = $instance->id;
                    $cfdi->tag_id = $tag_id;
                    $cfdi->name = $filename;
                    $cfdi->save();
                }
            }
        }
        Session::flash('success', 'CFDIs agregados correctamente');
        return redirect()->route('tag.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);        
        return view('tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tag.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Obtener la etiqueta
        $tag = Tag::find($id);

        //Obtener todos los CFDIs que tengan relación con la etiqueta
        $cfdis =  Cfdi::where('tag_id',$id)->get();

        //Directorio
        $directory = 'public/';

        foreach ($cfdis as $cfdi) {
            Storage::move($directory.$tag->name.'/'.$cfdi->name, $directory.$request->name.'/'.$cfdi->name);
        }
        Storage::deleteDirectory($directory.$tag->name);
        $tag->name = $request->name;
        $tag->save();
        
        Session::flash('success', 'Nombre de la etiqueta actualizada correctamente');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Eliminar CFDIs de la BD
        $cfdis = Cfdi::where('tag_id', $id)->get();
        foreach ($cfdis as $cfdi) {
            $cfdi->delete();
        }
        //Buscar Etiqueta
        $tag = Tag::find($id);

        //Eliminar directorio
        $directory = 'public/'.$tag->name;
        Storage::deleteDirectory($directory);

        //Eliminar Etiqueta de la BD
        $tag->delete();

        Session::flash('success', 'CFDIs eliminados correctamente');
        return back();
    }
}
