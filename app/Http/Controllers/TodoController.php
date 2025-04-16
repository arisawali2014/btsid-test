<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function index()
    {
        return $this->successResponse('Success', $this->user->todos()->with('items')->get());
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $todo = $this->user->todos()->create($request->all());
        return $this->successResponse('Success', $todo);
    }

    public function destroy(Request $request)
    {
        $todo = $this->user->todos()->find($request->id);
        $todo->delete();
        return $this->successResponse('Success', $todo);
    }
    public function show(Request $request)
    {
        $todo = $this->user->todos()->find($request->id);
        if ($todo) {
            return $this->successResponse('Success', $todo);
        }
        return $this->errorResponse('Todo not found', 404);
    }
    public function update(Request $request)
    {
        $todo = $this->user->todos()->find($request->id);
        $todo->update(['checklist_completion_status' => !$todo->checklist_completion_status]);
        return $this->successResponse('Success', $todo);
    }
}
