<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectsRepository;
use App\Http\Requests\ProjectRequest;
use App\Project;
use Image;

class ProjectsController extends Controller
{
    protected $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth');
    }

    public function index()
    {
        /*$projects = $this->repo->list();*/
        $projects = project::get();
        dd($projects);
        return view('welcome', compact('projects'));
    }

    public function store(ProjectRequest $request)
    {
        $this->repo->create($request);
        return back();
    }

    public function show(Project $project)
    {
        $todos = $this->repo->todos($project);
        $dones = $this->repo->dones($project);
        $projects = \Auth::user()->projects()->pluck('name', 'id');
        return view('projects.show', compact('project', 'todos', 'dones', 'projects'));
    }

    public function update(ProjectRequest $request, $id)
    {
        $this->repo->update($request, $id);
        return back();
    }

    public function destroy(Project $project){
        $project->delete();
        return back();
    }


}
