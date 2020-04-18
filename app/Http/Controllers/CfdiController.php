<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Datatables;
use App\Mail\CfdiEmail;
use Session;
use App\Tag;
use App\User;
use App\Cfdi;

class CfdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','admin']);
        $this->middleware('revalidate',['except'=>['getCfdi','readCfdi']]);
    }
    
    public function apiCfdi($id)
    {
        $tag = Tag::find($id);
        $cfdi = Cfdi::where('tag_id', $id)->get();

        return Datatables::of($cfdi)
        ->editColumn('name', function($cfdi) use($tag){
        return link_to_route('readCFDI', $title = $cfdi->name, $parameters = ['cfdi' => $cfdi->name, 'tag' => $tag->name], $attributes = ['target'=>'_blank']);
        })
        ->addColumn('action', function($cfdi) use ($tag){
        return link_to_route('getCFDI', 'Descargar', $parameters = ['cfdi' => $cfdi->name, 'tag' => $tag->name], $attributes = ['class' => 'waves-effect waves-light btn green', 'target'=>'_blank']).'  '.
        '<a class="waves-effect waves-light btn purple modal-trigger edit-cfdi" href="#edit-cfdi" data-value="'.route('cfdi.update',$cfdi->id).'">Remplazar</a> ' .
        '<a class="btn red modal-trigger remove-cfdi" role="button" href="#delete" data-value="'.route('cfdi.destroy',$cfdi->id).'">Eliminar</a>';
        })
        ->addColumn('send', function($cfdi){
            if ($cfdi->user->confirmed == 1) return link_to_route('cfdi.send', 'Enviar', $parameters = ['cfdi' => $cfdi->id, 'tag' => $cfdi->tag_id, 'user' => $cfdi->user_id], $attributes = ['class' => 'waves-effect waves-light btn purple']);
            if ($cfdi->user->confirmed == 0) return 'Pendiente';
            return 'Cancel';
        })
        ->rawColumns(['name', 'action','send'])
        ->toJson();
    }

    public function getCfdi(Request $request)
    {
        $directory = storage_path('app/public/' . $request->tag.'/'.$request->cfdi);
        //return Storage::disk('public')->download($directory);
        return response()->download($directory);
    }

    public function readCfdi(Request $request)
    {
        
        $directory = storage_path('app/public/' . $request->tag.'/'.$request->cfdi);
        return response()->file($directory);
    }

    public function send($cfdi, $tag, $user)
    {
        $user = User::find($user);
        $cfdi = Cfdi::find($cfdi);
        $tag = Tag::find($tag);

        Mail::to($user->email)->send(new CfdiEmail($cfdi, $tag));

        Session::flash('success', 'CFDI enviado correctamente');
        return back();
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = Tag::find($request->tag);
        
        //Directorio
        $directory = 'public/'.$tag->name;

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
                    $cfdi->tag_id = $tag->id;
                    $cfdi->name = $filename;
                    $cfdi->save();
                }
            }
        }
        Session::flash('success', 'CFDIs agregados correctamente');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        //

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    }
    public function update(Request $request, $id)
    {
        $file = $request->file;
        //Capturar el número de empleado
        $array = explode(' ', $file->getClientOriginalName());
        $user = User::where('number', $array[1])->get();
        $user_id = $user[0]->id;

        //Validar que la extensión sea pdf
        if ($file->getClientOriginalExtension() == 'pdf' || $file->getClientOriginalExtension() == 'xml') {
            
            //Validar si existe un usuario con el número del archivo
            if ($instance = Cfdi::where('id', $id)->where('user_id',$user_id)->first()) {
                
                //Buscar la etiqueta
                $tag = Tag::find($request->tag);
                
                //Guardar el nombre del archivo en una variable
                $filename = $file->getClientOriginalName();

                //Eliminar el archivo
                $cfdi = Cfdi::find($id);
                $directory = 'public/'.$tag->name;
                Storage::delete($directory.'/'.$cfdi->name);
                
                //Almacenamiento
                Storage::putFileAs($directory, $file, $filename);
                
                //Guardado en la Base de datos
                $cfdi->name = $filename;
                $cfdi->save();
                Session::flash('success', 'CFDI actualizado correctamente');
            }
        }  
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //Buscar Etiqueta
        $tag = Tag::find($request->tag);
        
        //Bucar CFDI
        $cfdi = Cfdi::find($id);

        //Crear dirección del directorio
        $directory = 'public/'.$tag->name.'/'.$cfdi->name;

        Storage::delete($directory);
        $cfdi->delete();

        Session::flash('success','CFDI eliminado correctamente');
        return back();
    }
}
