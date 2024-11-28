<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // 1. Display all paginated list of tasks with filters
    public function index(Request $request)
    {
        $query = Task::query();

        // Filter by completion status
        if ($request->has('completed')) {
            $query->where('completed', $request->completed);
        }

        // Filter by priority
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sorting tasks by due date
        if ($request->has('sort_by_due_date')) {
            $query->orderBy('due_date', $request->sort_by_due_date == 'desc' ? 'desc' : 'asc');
        }

        // Paginate results
        $tasks = $query->paginate(10);

        return response()->json($tasks);
    }

    // 2. Show a task by ID
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // 3. Store a new task with validation rules
    public function store(Request $request)
    {
        // Can use a custom request that validates the values first
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique|max:255',
            'description' => 'nullable|string|max:50',
            'completed' => 'boolean',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    // 4. Mark a task as complete by ID
    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $task->completed = true;
        $task->save();

        return response()->json($task);
    }

    // 5. Restore a soft-deleted task by ID
    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();

        return response()->json($task);
    }
}
