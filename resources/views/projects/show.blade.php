@extends('layouts.app')
@section('content')

    <header class="d-flex align-items-center mb-3 py-4">
        <div class="d-flex justify-content-between align-items-end w-100">
            <p class="text-muted small fw-normal">
                <a href="/projects" class="text-muted small fw-normal text-decoration-none"> My
                    Projects</a> {{' / '}} {{$project->title}}
            </p>
            <div class="d-flex align-items-center">
                @foreach(@$project->members as $member)
                    <img src="{{gravatar_url($member->email) }}"
                         alt="{{$member->name}}'s avatar"
                         class="rounded-circle w-8 h-8 me-2">
                @endforeach
                    <img src="{{gravatar_url($project->owner->email)}}"
                         alt="{{$project->owner->name}}'s avatar"
                         class="rounded-circle w-8 h-8 me-2">

                <a href="{{$project->path(). '/edit'}}" class="btn btn-primary me-auto ">Edit project</a>
            </div>

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
                    @include('errors')
                </div>
            </div>

            <div class="col-lg-3 px-3 py-lg-5">
                @include('projects.card')
                @include('projects.activity.card')

                @can('manage',$project)
                    @include('projects.invite')
                @endif


        </div>
    </main>

@endsection
