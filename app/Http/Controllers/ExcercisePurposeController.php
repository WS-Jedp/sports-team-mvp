<?php

namespace App\Http\Controllers;

use App\Models\ExcercisePurpose;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExcercisePurposeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'title' => 'required|min:5|max:42|string',
            'description' => 'required|string|string'
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
            $purpose = new ExcercisePurpose($validated);
            $purpose->save();
            $data = [
                'status' => 200,
                'data' => [
                    'purpose' => $purpose,
                    'msg' => "The purpose $purpose->id was created successfully"
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

    public function show(ExcercisePurpose $excercisePurpose)
    {
        $excercisePurpose->Excercises();
        $data = [
            'status' => 200,
            'data' => [
                'purpose' => $excercisePurpose
            ]
        ];
        return response($data, 200);
    }
}
