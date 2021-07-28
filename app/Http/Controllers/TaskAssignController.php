<?php

namespace App\Http\Controllers;

use App\Models\Propety;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskAssign;
use App\Models\Tendent;

class TaskAssignController extends Controller
{
    // add method
    public function add(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $check = Task::join('properties', 'properties.id', '=', 'task.property_id')
                ->where('properties.user_id', Auth::user()->id)->get();
            if ($check->count() > 0) {
                $check_tendent = Tendent::where([['tendent_id', $request->user_id], ['is_live', 1]])->get();
                if ($check_tendent->count() > 0) {
                    $check_task = Task::find($request->task_id);
                    if ($check_task) {
                        $check_task_assign = TaskAssign::where('task_id', $request->task_id)->first();
                        if (!$check_task_assign) {
                            $add = [
                                "user_id" => $request->user_id,
                                "task_id" => $request->task_id,
                                "status" => "pending",
                                "date" => $request->date,
                            ];
                            if (TaskAssign::create($add)) {
                                $input = [
                                    "user_id" => Auth::user()->id,
                                    "property_id" => $check[0]->id,
                                    "description" => "Task '" . $check[0]->task . "' Assigned for property ".$check[0]->property_name,
                                    "stt" => 1,
                                    "stl" => 0
                                ];
                                NotificationsController::insert($input);
                            }
                            return response()->json(["data" => [["task_assign" => "Added"]]]);
                        }
                        return response()->json(["data" => [["error" => "Already Added"]]]);
                    }
                    return response()->json(["data" => [["error" => "task not found"]]]);
                }
                return response()->json(["data" => [["error" => "tenant not belongs to property"]]]);
            }
            return response()->json(["data" => [["error" => "not belongs to you"]]]);
        }
        return response()->json(["data" => [["error" => "unauthenticated"]]]);
    }


    // select method
    public function select(Request $request)
    {
        if (Auth::user()->user_type_id == 1) {
            $select = TaskAssign::select(
                'task_assign.id',
                'task_assign.user_id',
                'users.name as user_name',
                'users.email as user_email',
                'task.task',
                'task_assign.status',
                'task_assign.date'
            )
                ->join('task', 'task_assign.task_id', '=', 'task.id')
                ->join('properties', 'properties.id', '=', 'task.property_id')
                ->join('users', 'task_assign.user_id', 'users.id')
                ->where('properties.user_id', Auth::user()->id);
            if ($request->user_id != "") {
                $select = $select->where('task_assign.user_id', $request->user_id);
            }
            if ($request->id != "") {
                $select = $select->where('task_assign.id', $request->id);
            }
            $select = $select->get();
            return response()->json(["data" => $select]);
        }
        if (Auth::user()->user_type_id = 2) {
            $select = TaskAssign::select(
                'task_assign.id',
                'task_assign.user_id',
                'users.name as user_name',
                'users.email as user_email',
                'task.task',
                'task_assign.status',
                'task_assign.date'
            )
                ->join('task', 'task_assign.task_id', '=', 'task.id')
                ->join('users', 'task_assign.user_id', 'users.id')
                ->where('task_assign.user_id', Auth::user()->id)
                ->get();
            return response()->json(["data" => $select]);
        }
        return response()->json(["data" => [["error" => "no data found"]]]);
    }

    // update method
    public function update(Request $request)
    {
        $check = TaskAssign::find($request->input('id'));
        if ($check) {
            if (Auth::user()->user_type_id == 1) {
                $check_property = Task::where('id', $check->task_id)
                    ->join('properties', 'properties.id', 'task.property_id')
                    ->where('properties.user_id', Auth::user()->id);
                if ($check_property) {
                    $upload = $request->all();
                    $check = $check->update($upload);
                    return response()->json(["data" => [["task_assign" => "updated"]]]);
                }
                return response()->json(["data" => [["task_assign" => "not belongs to you"]]]);
            } elseif (Auth::user()->user_type_id == 2) {
                $check_tendent = Task::find($check->task_id);
                $check_property = Tendent::where([['property_id', $check_tendent->property_id], ['tendent_id', Auth::user()->id], ['is_live', 1]])->first();
                if ($check_property) {
                    $upload = $request->all();
                    if($check->update($upload))
                    {
                        $property = Propety::find($check_tendent->property_id);
                        $input = [
                            "user_id" => $property->user_id,
                            "property_id" => $property->id,
                            "description" => "Task '" . $check_tendent->task . "' completed for property $property->property_name",
                            "stt" => 1,
                            "stl" => 1
                        ];
                        NotificationsController::insert($input);
                    }
                    return response()->json(["data" => [["task_assign" => "updated"]]]);
                }
                return response()->json(["data" => [["task_assign" => "not belongs to you"]]]);
            }
        }
        return response()->json(["data" => [["task_assign" => "not found"]]]);
    }

    // delete method
    public function delete(Request $request)
    {
        $check = TaskAssign::find($request->input('id'));
        if ($check) {
            $check->delete();
            return response()->json(["data" => [["task_assign" => "deleted"]]]);
        }
        return response()->json(["data" => [["task_assign" => "not found"]]]);
    }
}
