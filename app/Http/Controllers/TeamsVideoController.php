<?php

namespace App\Http\Controllers;

use App\Models\TeamsVideo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TeamsVideoController extends Controller
{

    public function index($id)
    {
        $teamVideos = TeamsVideo::where('team_id', $id)->get();
        $data = [
            'status' => 200,
            'data' => [
                'videos' => $teamVideos
            ]
        ];
        return response($data, 200);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'team_id' => 'required|integer',
            'title' => 'required|string|min:5|max:42',
            'description' => 'required|string|min:10',
            'video' => 'required|file'
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
        $team_id = $validated['team_id'];

        try  {
            unset($validated['video']);
            $video_file = $request->file('video');
            $video_name = $video_file->getClientOriginalName();

            $teamsVideo = new TeamsVideo($validated);
            $teamsVideo->video_url = Storage::disk('local')->put($video_name, $video_file);
            $teamsVideo->save();
            $data = [
                'status' => 201,
                'data' => [
                    'video' => $teamsVideo->Team(),
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

    

    public function destroy(TeamsVideo $teamsVideo)
    {
        $id = $teamsVideo->id;
        $teamsVideo->delete();
        $data = [
            'status' => 201,
            'data' => [
                'msg' => "The video $id was deleted!"
            ]
        ];
        return response($data, 201); 
    }
}
