<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [            
                    'name' => 'required',
                    'last_name' => 'required',
                    'second_last_name' => 'required',
                    'rfc' => 'required|unique:users',
                    'curp' => 'required|unique:users',
                    'imss' => 'required|unique:users',
                    'number' => 'required|unique:users',
                    'type' => 'required',
                    'password' => 'required',
                    'repeat_password' => 'required'
                ];
            }
            case 'PUT':
            {

                return [            
                    'name' => 'required',
                    'last_name' => 'required',
                    'second_last_name' => 'required',
                    'rfc' => 'required|unique:users,id,'.$this->id,
                    'curp' => 'required|unique:users,id,'.$this->id,
                    'imss' => 'required|unique:users,id,'.$this->id,
                    'number' => 'required|unique:users,id,'.$this->id,
                    'type' => 'required'
                ];
            }
            case 'PATCH':
            default:break;
        }
    }
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'last_name' => 'apellido paterno',
            'second_last_name' => 'apellido materno',
            'rfc' => 'RFC',
            'curp' => 'CURP',
            'imss' => 'número de seguro social',
            'number' => 'número de empleado',
            'email' => 'correo electrónico',
            'type' => 'tipo de usuario',
            'password' => 'contraseña',
            'repeat_password' => 'repetir contraseña'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El campo :attribute es obligatorio',
            'last_name.required' => 'El campo :attribute es obligatorio',
            'second_last_name.required' => 'El campo :attribute es obligatorio',
            'rfc.required' => 'El campo :attribute es obligatorio',
            'rfc.unique' => 'Ya existe un usuario con ese :attribute ',
            'curp.required' => 'El campo :attribute es obligatorio',
            'curp.unique' => 'Ya existe un usuario con ese :attribute ',
            'imss.required' => 'El campo :attribute es obligatorio',
            'imss.unique' => 'Ya existe un usuario con ese :attribute ',
            'number.required' => 'El campo :attribute es obligatorio',
            'number.unique' => 'Ya existe un usuario con ese :attribute ',
            'password.required' => 'El campo :attribute es obligatorio',
            'repeat_password' => 'El campo :attribute es obligatorio'
        ];
    }
    public function response()
    {
        return $this->redirector->to($this->getRedirectUrl())
        ->withInput()
        ->withErrors($errors, $this->errorBag);
    }
}
