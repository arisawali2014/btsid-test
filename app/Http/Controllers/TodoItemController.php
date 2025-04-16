<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoItemController extends Controller
{

    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function index(Request $request)
    {
        $todo = $this->user->todos()->find($request->id);
        if ($todo) {
            $todoItem = $todo->items()->get();
            return $this->successResponse('Success', $todo);
        }
        return $this->errorResponse('Todo not found', 404);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }
        $todoItem = $this->user->todos()->find($request->id)->items()->create($request->all());
        return $this->successResponse('Success', $todoItem);
    }

    public function destroy(Request $request)
    {
        $todoItem = $this->user->todos()->find($request->id)->items()->find($request->item_id);
        $todoItem->delete();
        return $this->successResponse('Success', $todoItem);
    }
    public function show(Request $request)
    {
        $todo = $this->user->todos()->find($request->id);
        if ($todo) {
            $todoItem = $todo->items()->find($request->item_id);
            return $this->successResponse('Success', $todoItem);
        }
        return $this->errorResponse('Todo not found', 404);
    }
    public function rename(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $todoItem = $this->user->todos()->find($request->id)->items()->find($request->item_id);
        $todoItem->update($request->all());
        return $this->successResponse('Success', $todoItem);
    }
    public function update(Request $request)
    {
        $todoItem = $this->user->todos()->find($request->id)->items()->find($request->item_id);
        $todoItem->update(['item_completion_status' => !$todoItem->item_completion_status]);
        return $this->successResponse('Success', $todoItem);
    }
}
