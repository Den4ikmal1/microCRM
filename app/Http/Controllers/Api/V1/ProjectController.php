<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\ProjectCreateRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::paginate();
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function store(ProjectCreateRequest $request)
    {
        return Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->fill($request->all());
        $project->save();
        return $project;
    }

    public function destroy(Project $project)
    {
        if($project->delete())
            return response()->json([], 204);
    }
}