<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'apelido' => 'required|string|max:50|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'senha' => 'required|min:6',
            'celular' => 'nullable',
            'tipo_usuario_id' => 'required|exists:tipo_usuarios,id',
            'midia_social' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'apelido.required' => 'O campo apelido é obrigatório.',
            'apelido.max' => 'O campo apelido não pode ter mais de :max caracteres.',
            'apelido.unique' => 'O apelido já está em uso.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter no mínimo :min caracteres.',
        ];
    }
}
