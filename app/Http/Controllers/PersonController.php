<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Person;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class PersonController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|min:30',
            'phone' => 'required|string',
            'biography' => 'nullable|string',
            'height' => 'nullable|integer',
            'weight' => 'nullable|integer', 
            'position' => 'nullable|string|min:3|max:21',
            'user_id' => 'required|integer'
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
            $person = new Person($validated);
            $person->save();
            $data = [
                'status' => 201,
                'data' => [
                    'person' => $person->User(),
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




    public function udpate(Request $request, Person $person)
    {

        $data = $request->input();
        try {
            foreach ($data as $key => $value) {
                $person->$key = $value;
            }
            $person->save();
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
                'person' => $person
            ]
        ];
        return response($resp, 201);
    }




    public function destroy(Person $person)
    {
        $id = $person->id;
        $person->destroy($id);
        $data = [
            'status' => 201,
            'data' => [
                'message' => "The person $id was deleted succesfully"
            ]
        ];

        return response($data, 201);
    }




    public function index()
    {
        $data = [
            'status' => 200,
            'data' => [
                'people' => Person::all()
            ]
        ];
        return response($data, 200);
    }





    public function show(Person $person)
    {
        $person->User();

        $data = [
            'status' => 200,
            'data' => [
                'person' => $person
            ]
        ];
        return response($data, 200);

    }
}
