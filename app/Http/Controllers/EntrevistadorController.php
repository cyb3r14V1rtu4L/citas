<?php

namespace App\Http\Controllers;

use App\Models\Entrevistador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntrevistadorController extends Controller
{
    public function create(Request $request) {
        $input = $request->all();
        $validatedData = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if($validatedData->fails()) {
            return response()->json([
                "response" => "error",
                "message" => $validatedData->errors()->first(),
                "code" => 400
            ]);
        }

        try {
            $entrevistador = Entrevistador::create($input);
            return response()->json([
                "response" => "success",
                "message" => "Entrevistador creado satisfactoriamente.",
                "data" => $entrevistador
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "response" => "error",
                    "message" => $e->getMessage()
                ]
            );
        }
    }

    public function getRules() {
        return [
            'nombre' => 'required|unique:entrevistadors',
        ];
    }

    public function getMessages() {
        return [
            'nombre.required' => 'Debe escribir un nombre para el Entrevistador.',
        ];
    }

}
