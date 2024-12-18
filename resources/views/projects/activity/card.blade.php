<div class="bg-white  p-3  rounded-3 shadow mt-5">
    <ul class="fs-6 list-unstyled "  >
        @foreach($project->activity as $activity)
            <li class="mb-1">
                @if(str_contains($activity->description,'project') || str_contains($activity->description,'task'))
                    @include("projects.activity.{$activity->description}")
                @else
                    @include("projects.activity.{$activity->description}_project")
                @endif

               <span class="text-muted">
                   {{$activity->created_at->diffForHumans(null, true)}}
                </span>

            </li>
        @endforeach
    </ul>
</div>
