<div class="bg-white  p-3  rounded-3 shadow d-flex flex-column mt-4" >
    <h3 class="fw-normal fs-1 py-3  mb-3 border-start border-5 border-info ps-3" style="margin-left: -0.8rem;">
        Invite a User
    </h3>
    <form method="POST" action="{{$project->path(). '/invitations'}}">
        @csrf
        <div class="mb-4">
            <input type="email" name="email" class="border  border-secondary w-100 rounded mb-3 py-2 px-3" placeholder="Email address">
        </div>
        <button type="submit" class="small">Invite</button>
    </form>

    @include('errors', ['bag' => 'invitations'])
</div>
