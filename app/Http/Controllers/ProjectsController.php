<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index(): \Illuminate\View\View
    {

        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $project = auth()->user()->projects()->create($this->validateRequest());
        return redirect($project->path());
    }

    public function show( Project $project): \Illuminate\View\View
    {
        $this->authorize('update', $project);
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * @return array
     */
    public function validateRequest(): array
    {
        return request()->validate(
            [
                'title' => 'sometimes|required',
                'description' => 'sometimes|required',
                'notes' => 'nullable'
            ]
        );
    }

}
