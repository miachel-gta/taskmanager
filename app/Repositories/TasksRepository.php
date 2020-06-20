<?php
namespace App\Repositories;

use App\Task;
use Auth;

class TasksRepository {
    public function create($request)
    {
        Task::create([
            'name' => $request->name,
            'completion' => (int) false,
            'project_id' => $request->project,
        ]);
    }

    public function update($request, $id)
    {
        Task::where('id', $id)->update([
            'name' => $request->name,
            'project_id' => $request->project_id,
        ]);
    }

    public function todos()
    {
        return Auth::user()->tasks()->where('completion', 0)->paginate(5);
    }

    public function dones()
    {
        return Auth::user()->tasks()->where('completion', 1)->paginate(5);
    }

}
