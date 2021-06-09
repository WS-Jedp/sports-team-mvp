<?php

namespace App\Http\Controllers;

use App\Models\TrainingSchedule;
use App\Models\TrainingsHasExcercise;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TrainingsHasExcerciseController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'schedule_id' => 'required|integer',
            'excercise_id' => 'required|integer',
            'result' => 'nullable|string',
            'video_url' => 'nullable|string',
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
            $trainingHasExcercise = new TrainingsHasExcercise($validated);
            $trainingHasExcercise->save();
            $training = TrainingSchedule::find($validated['schedule_id']);
            $training->Excercises();
            $data = [
                'status' => 200,
                'data' => [
                    'training' => $training,
                    'msg' => "The excerise was created into the training $training->id was created successfully"
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




    public function udpate(Request $request, $id)
    {

        $trainingHasExcercise = TrainingsHasExcercise::where('schedule_id', $id)->first();
        $data = $request->input();
        try {
            foreach ($data as $key => $value) {
                $trainingHasExcercise->$key = $value;
            }
            $trainingHasExcercise->save();
            $data = [
                'status' => 201,
                'data' => [
                    'trainingExcercise' => $trainingHasExcercise
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





    public function destroy($schedule_id, $excercise_id)
    {
        TrainingsHasExcercise::where('schedule_id', $schedule_id)->where('excercise_id', $excercise_id)->delete();
        $data = [
            'status' => 201,
            'data' => [
                'msg' => "The excercise $excercise_id was deleted from the training $schedule_id"
            ]
        ];
        return response($data, 201);
    }


}
