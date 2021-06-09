<?php

namespace App\Http\Controllers;

use App\Models\TrainingSchedule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TrainingScheduleController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'datetime' => 'required|date',
            'team_id' => 'required|integer'
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
            $training = new TrainingSchedule($validated);
            $training->state = 'waiting';
            $training->save();
            $data = [
                'status' => 200,
                'data' => [
                    'training' => $training,
                    'msg' => "The training $training->id was created successfully"
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




    public function udpate(Request $request, TrainingSchedule $trainingSchedule)
    {

        $data = $request->input();
        try {
            foreach ($data as $key => $value) {
                $trainingSchedule->$key = $value;
            }
            $trainingSchedule->save();
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
                'training' => $trainingSchedule
            ]
        ];
        return response($resp, 201);
    }




    public function show(TrainingSchedule $trainingSchedule)
    {
        $trainingSchedule->Attendances();
        $trainingSchedule->Excercises();
        $trainingSchedule->Team();

        $data = [
            'status' => 200,
            'data' => [
                'training' => $trainingSchedule
            ]
        ];
        return response($data, 200);
    }




    public function index()
    {
        $all = TrainingSchedule::all();
        $data = [
            'status' => 200,
            'data' => [
                'trainings' => $all
            ]
        ];
        return response($data, 200);
    }
}
