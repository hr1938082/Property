<?php

namespace App\Http\Controllers;

use App\Models\Propety;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskAssign;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // add method
    public function add(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $check = Propety::find($request->property_id);
            if ($check && Auth::user()->id == $check->user_id) {
                $task = $request->all();
                Task::create($task);
                return response()->json(["data" => [["task" => "inserted"]]]);
            }
            return response()->json(["data" => [["error" => "not belongs to you"]]]);
        }
        return response()->json(["data" => [["error" => "unauthenticated"]]]);
    }

    // select method
    public function select(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $select = Task::join('properties', 'task.property_id', '=', 'properties.id')
                ->select('task.id as id', 'task.property_id', 'properties.property_name', 'task.task')
                ->where('properties.user_id', Auth::user()->id);
            if ($request->id != "") {
                $select = $select->where('task.id', $request->id);
            }
            $select = $select->orderByDesc('task.property_id')
                ->get();
            return response()->json(["data" => $select]);
        }
    }
    // update method
    public function update(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $task = Task::find($request->id);
            if ($task) {
                $property = Propety::find($task->property_id);
                if ($property) {
                    if ($property->user_id == Auth::user()->id) {
                        $task->task = $request->task;
                        $task->save();
                        return response()->json(["data" => [["task" => "updated"]]]);
                    }
                    return response()->json(["data" => [["task" => "not belongs to you"]]]);
                }
                return response()->json(["data" => [["task" => "Property not found"]]]);
            }
            return response()->json(["data" => [["task" => "not found"]]]);
        }
    }
    // delete method
    public function delete(Request $request)
    {
        $check = Task::find($request->input('id'));
        if ($check) {
            $check2 = TaskAssign::where('task_id', $check->id)->get();
            if ($check2->count() > 0) {
                return response()->json(["data" => [["task" => "First remove all task assigned to Tenants"]]]);
            }
            $check->delete();
            return response()->json(["data" => [["task" => "Deleted"]]]);
        }
        return response()->json(["data" => [["error" => "Not Found"]]]);
    }
}
