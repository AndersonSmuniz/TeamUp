<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EsporteResource;
use App\Models\Esporte;
use App\Models\Usuario;
use App\Traits\HttpResponses;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EsporteController extends Controller
{
    use HttpResponses;

    public function index()
    {
        if(Auth::user()->tipo_usuario_id == 1){
            return EsporteResource::collection(Esporte::all());
        }
        return EsporteResource::collection(Esporte::where('status', 'on')->get());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:50',
            'status' => 'required|string|max:3'
        ]);

        if ($validator->fails()) {
            return $this->error('Dados Invalidos', 422, $validator->errors());
        }

        $data = $validator->validated();

        $esporte = Esporte::create([
            'nome' => $data['nome'],
            'status'=> $data['status']
        ]);

        return $esporte ? $this->response('Esporte cadastrado com sucesso', 200, new EsporteResource($esporte))
            : $this->response('Esporte nao cadastrado', 400);

    }

    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'nome' => ['required','string','max:50',Rule::unique('esportes')->ignore($id)],
            'status' => 'required|string|max:3'
        ]);

        if ($validator->fails()) {
            return $this->error('Dados Invalidos', 422, $validator->errors());
        }

        $data = $validator->validated();

        $updateEsporte = Esporte::find($id);

        $esporte = $updateEsporte->update([
            'nome' => $data['nome'],
            'status'=> $data['status']
        ]);

        return $esporte ? $this->response('Esporte atualizado com sucesso', 201, new EsporteResource($updateEsporte))
            : $this->response('Falha ao atualizar esporte', 400);
    }

    public function show(string $id)
    {
        return new EsporteResource(esporte::where('id', $id)->first());
    }

    public function destroy(Esporte $esporte)
    {
        $deleted = $esporte->delete();

        return $deleted ? $this->response('Esporte deletado com sucesso', 200) :
            $this->response('Falha ao deletar esporte', 400);
    }
}
