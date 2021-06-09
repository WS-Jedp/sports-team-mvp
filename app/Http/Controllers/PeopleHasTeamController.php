<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeopleHasTeam;
use App\Models\Person;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class PeopleHasTeamController extends Controller
{
    public function store(Request $request)
    {
        $validate = Validator::make($request->input(), [
            'person_id' => 'required|integer',
            'team_id' => 'required|integer',
        ]);

        $validate->validate();
        $validated = $validate->validated();

        $personHasTeam = new PeopleHasTeam($validated);
        $personHasTeam->save();
        $player = Person::find($validated['person_id']);
        $player->Teams();
        
        $data = [
            'status' => 201,
            'data' => [
                'player' => $player
            ]
        ];
        return response($data, 201);
    }



    
    public function destroy($team_id, $person_id)
    {
        PeopleHasTeam::where('user_id', $person_id)->where('team_id', $team_id)->delete();
        $data = [
            'status' => 201,
            'data' => [
                'msg' => "The $person_id was deleted from the team $team_id"
            ]
        ];
        return response($data, 201);
    }
}
