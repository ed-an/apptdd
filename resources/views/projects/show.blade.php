@extends('layouts.app')
@section('content')

    <header class="d-flex align-items-center mb-3 py-4">
        <div class="d-flex justify-content-between align-items-end w-100">
            <p class="text-muted small fw-normal">
                <a href="/projects" class="text-muted small fw-normal text-decoration-none"> My
                    Projects</a> {{' / '}} {{$project->title}}
            </p>
            <a href="{{$project->path(). '/edit'}}" class="btn btn-primary me-2">Edit project</a>
        </div>
    </header>
    <main>
        <div class="d-lg-flex">
            <div class="col-lg-9 px-3 mx-n3 mb-3">
                <div class="mb-5">

                    <div class="fs-4 text-muted  fw-normal mb-3">Task</div>
                    {{-- Task --}}
                    @foreach($project->tasks as $task)
                        <div class="bg-white  p-3  rounded-3 shadow mb-3">
                            <form method="POST" action="{{ $task->path()  }}">
                                @method('PATCH')
                                @csrf
                                <div class="d-flex">
                                    <input name="body" value="{{$task->body}}"
                                           class="w-100 border-0 {{$task->completed ? 'text-secondary': ''}}">
                                    <input name="completed" type="checkbox"
                                           {{$task->completed ? 'checked' : ''}} onchange="this.form.submit()">
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="bg-white  p-3  rounded-3 shadow mb-3">
                        <form action="{{$project->path(). '/tasks' }} " method="post">
                            @csrf
                            <input placeholder="add new task..." class="w-100 border-0" name="body">
                        </form>
                    </div>

                </div>
                <div class="mb-5">
                    <div class="fs-4 text-muted  fw-normal mb-3">General Notes</div>
                    {{-- General Notes --}}
                    <form method="POST" action="{{$project->path()}}">
                        @csrf
                        @method('PATCH')

                        <textarea name="notes" class="bg-white  p-3  rounded-3 shadow w-100 border-0 mb-3"
                                  style="min-height: 200px"
                                  placeholder="Anything special that you want to make a note of">{{$project->notes}}</textarea>
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                    </form>

                    @if($errors->any())
                        <div class="mb-3 mt-3">
                            @foreach($errors->all() as $error)
                                <li class="small text-danger">{{$error}}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-35 px-3">
                @include('projects.card')
                @include('projects.activity.card')
            </div>
        </div>
    </main>

@endsection
