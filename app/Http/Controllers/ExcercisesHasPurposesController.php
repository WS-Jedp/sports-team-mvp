<?php

namespace App\Http\Controllers;

use App\Models\Excercise;
use App\Models\ExcercisesHasPurposes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExcercisesHasPurposesController extends Controller
{
    


    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'excercise_id' => 'required|integer',
            'purpose_id' => 'required|integer',
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
            $excerciseHasPurpose = new ExcercisesHasPurposes($validated);
            $excerciseHasPurpose->save();
            $excercise = Excercise::find($validated['excercise_id']);
            $excercise->Purposes();
            $data = [
                'status' => 200,
                'data' => [
                    'training' => $excercise,
                    'msg' => "The purpose was added into the excercise $excercise->id successfully"
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




    public function udpate(Request $request)
    {

        $excerciseHasPurpose = ExcercisesHasPurposes::where('excercise_id', $request->excercise_id)->where('purpose_id', $request->purpose_id )->first();
        $data = $request->input();
        try {
            foreach ($data as $key => $value) {
                $excerciseHasPurpose->$key = $value;
            }
            $excerciseHasPurpose->save();
            $data = [
                'status' => 201,
                'data' => [
                    'excerciseHasPurpose' => $excerciseHasPurpose
                ]
            ];
            return response($data, 201);
        } catch (QueryException $exc) {
            $resp = [
                'status' => 400,
                'data' => [
                    'error' => $exc->getMessage()
                ]
            ];
            return response($resp, 400);
        }

    }




    public function destroy($purpose_id, $excercise_id)
    {
        ExcercisesHasPurposes::where('purpose_id', $purpose_id)->where('excercise_id', $excercise_id)->delete();
        $data = [
            'status' => 201,
            'data' => [
                'msg' => "The purpose $purpose_id was deleted from the excercise $excercise_id"
            ]
        ];
        return response($data, 201);
    }



}
