<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class TaskController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        $tasks = Tasks::where('user_id', $user->id)->get()->toArray();

        return $tasks;
    }

    public function store(Request $request){
        $user = $request->user();

        $task = new Tasks([
            'user_id' => $user->id,
            'task' => $request->input('task'),
            'complete' => "O"
        ]);
        $task->save();

        return response()->json(['message' => 'Task created'], 200);
    }

    public function show($id){
        $task = Tasks::find($id);
        return response()->json($task);
    }

    public function update(Request $request, $id){
        $task = Tasks::findOrFail($id);
        $task->update($request->all());

        return response()->json(['message' => 'Task updated'], 200);
    }

    public function destroy($id){
        Tasks::find($id)->delete();

        return response()->json(['message' => 'Task deleted'], 204);
    }
}