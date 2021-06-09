<?php

namespace App\Http\Controllers;

use App\Models\ExcerciseType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExcerciseTypeController extends Controller
{

    public function index()
    {
        $all = ExcerciseType::all();
        $data = [
            'status' => 200,
            'data' => [
                'excercise_types' => $all
            ]
        ];
        return response($data, 200); 
    }




    public function show(ExcerciseType $excercise_type)
    {
        $excercise_type->Excercises();

        $data = [
            'status' => 200,
            'data' => [
                'excercise_type' => $excercise_type
            ]
        ];
        return response($data, 200);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'type' => 'required|string|min:5|max:21'
        ]);
        
        try {
            $validator->validate();
        } catch (ValidationException $exc) {
            $data = [
                'status' => 400,
                'data' => [
                    'error' => $exc->getMessage()
                ]
            ];
            return response($data, 400);
        }

        
        try {
            $validated = $validator->validated();
            $excercise_type = new ExcerciseType($validated);
            $excercise_type->save();
            $data = [
                'status' => 200,
                'data' => [
                    'excercise_type' => $excercise_type,
                    'msg' => "The excercise type $excercise_type->id was created successfully"
                ]
            ];
            return response($data, 201);
        } catch (QueryException $exc) {
            $data = [
                'status' => 400,
                'data' => [
                    'error' => $exc->getMessage()
                ]
            ];
            return response($data, 400);
        }
    }





    public function udpate(Request $request, ExcerciseType $excercise_type)
    {

        $data = $request->input();
        try {
            foreach ($data as $key => $value) {
                $excercise_type->$key = $value;
            }
            $excercise_type->save();
        } catch (QueryException $exc) {
            $resp = [
                'status' => 400,
                'data' => [
                    'error' => $exc->getMessage()
                ]
            ];
            return response($resp, 400);
        }

        $resp = [
            'status' => 201,
            'data' => [
                'excercise_type' => $excercise_type
            ]
        ];
        return response($resp, 201);
    }




    public function destroy(ExcerciseType $excercise_type)
    {
        $id = $excercise_type->id;
        $excercise_type->delete();

        $data = [
            'status' => 201,
            'data' => [
                'msg' => "The excercise type $id was deleted"
            ]
        ];
        return response($data, 201);
    }


}
