    @csrf
    <div class="field mb-5">
        <label class="form-label" for="title">Title</label>
        <div class="control">
            <input type="text"
                   class="form-control bg-transparent border border-secondary rounded-sm p-2 small w-100"
                   name="title"
                   placeholder="My next awesome project"
                   value="{{ $project->title }}" required >
        </div>
    </div>
    <div class="field mb-5">
        <label  class="form-label" for="description">Description</label>
        <div class="control">
                <textarea name="description"
                          class="form-control bg-transparent border border-secondary rounded-sm p-2 small w-100"
                          placeholder="Description" required>{{$project->description}}</textarea>
        </div>
    </div>
    <div class="field mb-5">
        <div class="control">
            <button class="btn btn-primary me-2" type="submit">{{$buttonText}}</button>
            <a  class="button link-is" href="{{$project->path()}}">Cancel</a>
        </div>
    </div>


        @if($errors->any())
            <div class="mb-3 mt-3">
                    @foreach($errors->all() as $error)
                        <li class="small text-danger">{{$error}}</li>
                    @endforeach
            </div>
        @endif


