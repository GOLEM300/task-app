<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $task_repository;

    /**
     * @param TaskRepository $task_repository
     */
    public function __construct(TaskRepository $task_repository)
    {
        $this->task_repository = $task_repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(TaskIndexRequest $request) : JsonResponse
    {
        try {
            $filters = $request->only(['date_to_finish', 'status']);

            $tasks = $this->task_repository->search($filters);

            return response()->json($tasks);
        } catch (\Exception $e) {
            Log::error('Index tasks error: ' . $e->getMessage());

            return response()->json(['error' => 'Something wrong'], 500);
        }
    }

    /**
     * @param TaskStoreRequest $request
     * @return JsonResponse
     */
    public function store(TaskStoreRequest $request) : JsonResponse
    {
        try {
            $task = Task::create($request->all());

            return response()->json($task, 201);
        } catch (\Exception $e) {
            Log::error('Show task error: ' . $e->getMessage());

            return response()->json(['error' => 'Something wrong'], 500);
        }
    }


    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task) : JsonResponse
    {
        try {
            return response()->json($task);
        } catch (\Exception $e) {
            Log::error('Show task error: ' . $e->getMessage());

            return response()->json(['error' => 'Something wrong'], 500);
        }
    }

    /**
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(TaskUpdateRequest $request, Task $task) : JsonResponse
    {
        try {
            $task->update($request->all());

            return response()->json($task);
        } catch (\Exception $e) {
            Log::error('Update task error: ' . $e->getMessage());

            return response()->json(['error' => 'Something wrong'], 500);
        }
    }

    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy(Task $task) : JsonResponse
    {
        try {
            $task->delete();

            return response()->json(['message' => 'Task deleted']);
        } catch (\Exception $e) {
            Log::error('Destroy task error: ' . $e->getMessage());

            return response()->json(['error' => 'Something wrong'], 500);
        }
    }
}
