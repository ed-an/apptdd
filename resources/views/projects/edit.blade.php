@extends('layouts.app')
@section('content')
    <div class="col-lg-6 mx-lg-auto bg-white p-5 py-md-5 px-md-5 rounded shadow">
    <h1 class="fs-2 fw-normal mb-5 text-center" >
        Edit Your Project
    </h1>
    <form
        method="POST"
        action="{{$project->path()}}"
        class=""
    >
        @method('PATCH')
        @include('projects.form', [
            'buttonText' => 'Update Project'
        ])
    </form>
    </div>
@endsection
