<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Team;
use Illuminate\Database\QueryException;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'name' => 'required|min:3|max:20',
            'description' => 'required|min:10',
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
            $team = new Team($validated);
            $team->save();
            $data = [
                'status' => 201,
                'data' => [
                    'team' => $team->User(),
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




    public function udpate(Request $request, Team $team)
    {

        $data = $request->input();
        try {
            foreach ($data as $key => $value) {
                $team->$key = $value;
            }
            $team->save();
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
                'team' => $team
            ]
        ];
        return response($resp, 201);
    }




    public function destroy(Team $team)
    {
        $id = $team->id;
        $team->delete();
        $data = [
            'status' => 201,
            'data' => [
                'message' => "The team $id was deleted succesfully"
            ]
        ];

        return response($data, 201);
    }




    public function index()
    {
        $data = [
            'status' => 200,
            'data' => [
                'teams' => Team::all()
            ]
        ];
        return response($data, 200);
    }





    public function show(Team $team)
    {
        $team->Players();
        $team->Videos();
        $team->Trainings();

        $data = [
            'status' => 200,
            'data' => [
                'team' => $team
            ]
        ];
        return response($data, 200);

    }
}
