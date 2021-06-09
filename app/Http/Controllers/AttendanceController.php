<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    public function index()
    {
        $all = Attendance::all();
        $data = [
            'status' => 200,
            'data' => [
                'attendances' => $all
            ]
        ];
        return response($data, 200);
    }




    public function show(Attendance $attendance)
    {
        $attendance->Schedule();

        $data = [
            'status' => 200,
            'data' => [
                'attendance' => $attendance
            ]
        ];
        return response($data, 200);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'player_id' => 'required|integer',
            'schedule_id' => 'required|integer',
            'response' => 'required|string|min:5|max:12',
            'state' => 'required|string|min:5|max:12'
        ]);
        try {
            $validator->validate();
        } catch(ValidationException $exc) {
            $data = [
                "status" => 400,
                "data" => [
                    "error" => $exc->getMessage(),
                ]
            ];
            return response($data, 400);
        }

        $validated = $validator->validated();
        
        try  {
            $attendance = new Attendance($validated);
            $attendance->save();
            $data = [
                'status' => 201,
                'data' => [
                    'atten$attendance' => $attendance->User(),
                ]
            ];
            return response($data, 201);
        } catch(QueryException $exc) {
            $data = [
                "status" => 400,
                "data" => [
                    'error' => $exc->getMessage()
                ]
            ];
        }

    }




    public function update(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'player_id' => 'required|integer',
            'schedule_id' => 'required|integer',
        ]);
        try {
            $validator->validate();
        } catch(ValidationException $exc) {
            $data = [
                "status" => 400,
                "data" => [
                    "error" => $exc->getMessage(),
                ]
            ];
            return response($data, 400);
        }

        $validated = $validator->validated();
        
        try  {
            $inputs = $request->input();
            $attendance = Attendance::where('player_id', $inputs['player_id'])->where('schedule_id', $inputs['schedule_id'])->first();
            foreach ($inputs as $key => $value) {
                $attendance->$key = $value;
            }
            $attendance->save();
            $data = [
                'status' => 201,
                'data' => [
                    'atten$attendance' => $attendance->User(),
                ]
            ];
            return response($data, 201);
        } catch(QueryException $exc) {
            $data = [
                "status" => 400,
                "data" => [
                    'error' => $exc->getMessage()
                ]
            ];
            return response($data, 400);
        }
    }


}
