<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstitucionController extends Controller
{
    /*
    |   :: input ::
    |   {
    |       "nombre" : "Nombre Institucion",
    |       "descripcion" : "Lorem Ipsum Dolor"
    |   }
    |
    */
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
            $institucion = Institucion::create($input);
            return response()->json([
                "response" => "success",
                "message" => "Institución creada satisfactoriamente.",
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

    /*
    |  :: Output ::
    |    {
    |        "response": "success",
    |        "message": "Institución creada satisfactoriamente.",
    |        "data": {
    |            "nombre": "nombreInstitucion",
    |            "descripcion": "descripciónInstitucion",
    |            "updated_at": "2021-09-16T02:03:21.000000Z",
    |            "created_at": "2021-09-16T02:03:21.000000Z",
    |            "id": 1
    |        }
    |    }
    |
    */





    public function getRules() {
        return [
            'nombre' => 'required|unique:institucions',
            'descripcion' => 'required',
        ];
    }

    public function getMessages() {
        return [
            'nombre.required' => 'Debe escribir un nombre para la Institución.',
            'nombre.unique' => 'Nombre de la Institución existente.',
            'descripcion.required' => 'Debe escribir la Descripción de la Institución.',
        ];
    }

}
