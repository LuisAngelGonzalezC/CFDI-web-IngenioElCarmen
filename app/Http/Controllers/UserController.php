<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Yajra\DataTables\Datatables;
use App\User;
use App\Cfdi;
use App\Tag;
use Validator;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin','revalidate']);
    }

    public function apiUser()
    {
        $user = User::select(['id', 'number', 'name', 'last_name', 'second_last_name'])->get();
        return Datatables::of($user)
        ->editColumn('number', function($user){
        return '<a id="'.$user->number.'" href="'.route('user.show',$user->id).'">'.$user->number.'</a> ';
        })
        ->addColumn('action', function($user){
        return '<a href="'.route('user.edit',$user->id).'" class="waves-effect waves-light btn blue">Editar</a> ' .
        '<a class="btn red modal-trigger remove-user" role="button" href="#delete" data-value="'.route('user.destroy',$user->id).'">Eliminar</a>';
        })
        ->rawColumns(['number', 'action'])
        ->toJson();
    }

    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }
    
    public function store(StoreUser $request)
    {     
        if($request->password == $request->repeat_password) {
            $user = new User;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->second_last_name = $request->second_last_name;
            $user->rfc = $request->rfc;
            $user->curp = $request->curp;
            $user->imss = $request->imss;
            $user->number = $request->number;
            $user->email = $request->email;
            $user->type = $request->type;
            $user->confirmation_code = str_random(25);
            $user->password = bcrypt('$request->password');
            $user->save();
            
            Session::flash('success', 'Usuario agregado correctamente');
            return view('user.index');
        }
        else
            return back()
            ->withErrors(['password' => 'La contraseña no coincide'])
            ->withInput();
    }

    public function show($id)
    {
        $user = User::find($id);
        $cfdis = Cfdi::where('user_id', $user->id)->get();
        return view('user.show', compact('user','cfdis'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(StoreUser $request, $id)
    {             
        $user = User::find($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->second_last_name = $request->second_last_name;
        $user->rfc = $request->rfc;
        $user->curp = $request->curp;
        $user->imss = $request->imss;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->type = $request->type;
        
        if (! is_null($request->password)) {
            if ($request->password == $request->repeat_password) {
                $user->password = bcrypt($request->password);
            }
            else
                return back()
                ->withErrors(['password' => 'La contraseña no coincide'])
                ->withInput(request(['password']));
        }
        $user->save();

        Session::flash('success', 'Usuario actualizado correctamente');
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Session::flash('success', 'Usuario eliminado correctamente');
        return redirect()->route('user.index');
    }
}
