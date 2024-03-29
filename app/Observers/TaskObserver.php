<?php

namespace App\Observers;

use App\Models\Task;
use Auth;
use Illuminate\Support\Facades\Cache;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Cache::forget("sidebar_projects");
        Cache::forget("projects_phases_tasks");
        $task->created_by = Auth::id();
        $task->updated_by = Auth::id();

        Task::withoutEvents(function () use ($task) {
            $task->save();
        });
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        Cache::forget("sidebar_projects");
        Cache::forget("projects_phases_tasks");
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void {
        Cache::forget("sidebar_projects");
        Cache::forget("projects_phases_tasks");
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
