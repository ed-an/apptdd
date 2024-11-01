
    {{-- box --}}
    <div class="bg-white  p-3  rounded-3 shadow" style="height: 200px">
        <h3 class="fw-normal fs-1 py-3  mb-3 border-start border-5 border-info ps-3" style="margin-left: -0.8rem;">
            <a href="{{$project->path()}}"  class="text-black text-decoration-none">   {{$project->title}} </a>

        </h3>
        <div class="text-muted mb-4">{{Str::limit($project->description,100)}}</div>
        <footer >
            <form action="{{$project->path()}}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </footer >
    </div>
