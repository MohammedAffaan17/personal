<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'task' => 'required|string',
        ]);

        $task = Task::create([
            'user_id' => $request->input('user_id'),
            'task' => $request->input('task'),
            'status' => 'pending',
        ]);

        return response()->json(['status' => 1, 'message' => 'Successfully created a task', 'task' => $task]);
    }

    public function updateTaskStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:pending,done',
        ]);

        $task = Task::findOrFail($request->input('task_id'));

        $task->update(['status' => $request->input('status')]);

        return response()->json(['status' => 1, 'message' => 'Marked task as ' . $request->input('status'), 'task' => $task]);
    }

    public function deleteTask(Request $request)
    {
        try {
            $taskId = $request->input('task_id');

            Task::where('id', $taskId)->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Task deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error deleting task: ' . $e->getMessage(),
            ], 500);
        }
    }
}
