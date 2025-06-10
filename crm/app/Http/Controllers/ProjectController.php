<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::with('tasks')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'name' => 'required|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        return Project::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $project->load('tasks');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'name' => 'sometimes|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $project->update($data);

        return $project;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
