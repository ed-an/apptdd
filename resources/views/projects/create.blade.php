@extends('layouts.app')
@section('content')
    <div class="col-lg-6 mx-lg-auto bg-white p-5 py-md-5 px-md-5 rounded shadow">
    <h1 class="fs-2 fw-normal mb-5 text-center" >
        Let's start something new
    </h1>
    <form
        method="POST"
        action="/projects"
        class=""
    >
    @include('projects.form', [
        'project' => new App\Models\Project,
        'buttonText' => 'Create Project'
    ])
    </form>
    </div>

@endsection
