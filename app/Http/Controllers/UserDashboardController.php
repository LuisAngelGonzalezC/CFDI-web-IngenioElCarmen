<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationEmail;
use App\Mail\CfdiEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Cfdi;
use App\Tag;
use App\User;
use Session;

class UserDashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth',['except'=>['validation']]);
        $this->middleware('revalidate',['except'=>['verify','getFile']]);
	}

    public function index()
    {
    	$id = Auth::user()->id;
    	$cfdis = Cfdi::where('user_id', $id)->get();
    	$tags = Tag::all();
    	return view('user', compact('cfdis','tags'));
    }

    public function getFile(Request $request)
    {
    	$tag = Tag::find($request->tag);
    	$cfdi = Cfdi::find($request->cfdi);
    	$cfdi->status = true;
    	$cfdi->save();
    	$directory = storage_path('app/public/' . $tag->name.'/'.$cfdi->name);
    }

    public function verify(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        if ($instance = User::where('email',$request->email)->first())
        {
            if ($instance->id == Auth::user()->id) {
                $user->email = $request->email;
                $user->confirmation_code = str_random(25);
                $user->save();

                Mail::to($user->email)->send(new ConfirmationEmail($user));
                Session::flash('info', 'Por favor confirma tu correo electrónico');
                return back();
            }
            else
            {
                Session::flash('error', 'El correo electrónico ya ha sido registrado anteriormente por otro usuario.');
                return back();
            }

        }
        else
        {
            if (User::find(Auth::user()->confirmed == true)) {
                $user->confirmed = false;
            }
            $user->email = $request->email;
            $user->confirmation_code = str_random(25);
            $user->save();

            Mail::to($user->email)->send(new ConfirmationEmail($user));
            Session::flash('info', 'Por favor confirma tu correo electrónico');
            return back();
        }
    }
    public function validation($confirmation_code, $email)
    {
        if ($user = User::where('email', $email)->where('confirmation_code', $confirmation_code)->first())
        {
            $user->confirmed = true;
            $user->save();
            Session::flash('success', 'Verificación completada');
            if (Auth::check()) {
                return redirect()->route('user');
            }
            else
                return redirect()->route('home');
        }
        else
        {   
            Session::flash('error', 'Problema al verificar el correo electrónico');
            if (Auth::check()) {
                return redirect()->route('user');
            }
            else
                return redirect()->route('home');         
        }    
    }
}
