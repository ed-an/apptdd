<div class="bg-white  p-3  rounded-3 shadow mt-2">
    <ul class="fs-6 list-unstyled "  >
        @foreach($project->activity as $activity)
            <li class="mb-1">

                    @include("projects.activity.{$activity->description}")
               <span class="text-muted">
                   {{$activity->created_at->diffForHumans(null, true)}}
                </span>

            </li>
        @endforeach
    </ul>
</div>
