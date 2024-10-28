@extends('layouts.app')
@section('content')
    <header class="d-flex align-items-center mb-3 py-4">
        <div class="d-flex justify-content-between align-items-end w-100">
            <h2 class="text-muted small fw-normal">My Projects</h2>
            <a href="/projects/create" class="text-muted text-decoration-none btn btn-primary">New project</a>
        </div>
    </header>
    <main class="d-lg-flex flex-lg-wrap mx-n3">
        @forelse($projects as $project)
           <div class="col-lg-4 px-3 pb-4">
               @include('projects.card')
           </div>
        @empty
            <div>No projects yet.</div>
    </main>
    @endforelse
@endsection

