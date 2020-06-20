<?php
namespace App\Repositories;

use Image;
use App\Project;

class ProjectsRepository{
    public function create($request)
    {
        $request->user()->projects()->create([
            'name' => $request->name,
            'thumbnail' => $this->thumb($request),
        ]);
    }

     public function thumb($request)
    {
        if($request->hasFile('thumbnail')){
            $thumb = $request->thumbnail;
            $name = $thumb->hashName();
            $thumb->storeAs('public/thumbs/original', $name);
            Image::make($thumb)->resize(200,90)->save(storage_path('app/public/thumbs/cropped/') . $name);

            return $name;
        }else{
            return null;
        }
    }

    public function update($request, $id)
    {
        $project = Project::find($id);

        $project->name = $request->name;


        if($request->hasFile('thumbnail')){
            $project->thumbnail = $this->thumb($request);
        }

        $project->save();
    }

    public function list()
    {
        return request()->user()->projects;
    }

    public function todos($project)
    {
        return $project->tasks()->where('completion', 0)->get();
    }

    public function dones($project)
    {
        return $project->tasks()->where('completion', 1)->get();
    }
}
