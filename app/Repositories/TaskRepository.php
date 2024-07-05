<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    /**
     * @param array $filters
     * @return Collection|array
     */
    public function search(array $filters = []): Collection|array
    {
        $query = Task::query();

        if (isset($filters['date_to_finish'])) {
            $query->whereDate('date_to_finish', $filters['date_to_finish']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }
}
