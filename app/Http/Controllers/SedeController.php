<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SedeController extends Controller
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
            $institucion = Sede::create($input);
            return response()->json([
                "response" => "success",
                "message" => "Sede creada satisfactoriamente.",
                "data" => $institucion
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
            'nombre' => 'required|unique:sedes',
            'descripcion' => 'required',
            'institucion_id' => 'required',
        ];
    }

    public function getMessages() {
        return [
            'nombre.required' => 'Debe escribir un nombre para la Sede.',
            'nombre.unique' => 'Nombre de la Sede existente.',
            'descripcion.required' => 'Debe escribir la Descripción de la Sede.',
            'institucion_id.required' => 'Debe Seleccionar una Institución para la Sede.',

        ];
    }

}
