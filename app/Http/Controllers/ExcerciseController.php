<?php

namespace App\Http\Controllers;

use App\Models\Excercise;
use App\Models\ExcercisesHasPurposes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExcerciseController extends Controller
{
    public function index()
    {
        $all = Excercise::all();
        $data = [
            'status' => 200,
            'data' => [
                'exercises' => $all
            ]
        ];
        return response($data, 200);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'title' => 'required|string|min:10|max:90',
            'description' => 'required|string|min:10',
            'purposes' => 'required|array',
            'cover_url' => 'nullable|string',
            'video_url' => 'nullable|string',
            'type_id' => 'required|integer'
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

        $validated = $validator->validated();
        try {
            $purposes = $validated['purposes'];

            unset($validated['purposes']);
            $excercise = new Excercise($validated);
            $excercise->save();

            for ($i=0; $i < count($purposes); $i++) { 
                new ExcercisesHasPurposes([
                    'excercise_id' => $excercise->id,
                    'purpose_id' => $purposes[$i]
                ]);
            }

            $data = [
                'status' => 201,
                'data' => [
                    'excercise' => $excercise
                ]
            ];
            return response($data, 201);
        } catch (QueryException $th) {
            $data = [
                "status" => 400,
                "data" => [
                    'error' => $exc->getMessage()
                ]
            ];
            return response($data, 400);
        }
    }




    public function show(Excercise $excercise)
    {
        $excercise->Type();
        $excercise->Purposes();
        $excercise->TrainingSchedules();

        $data = [
            'status' => 200,
            'data' => [
                'exercise' => $excercise
            ]
        ];
        return response($data, 200);
    }
}
