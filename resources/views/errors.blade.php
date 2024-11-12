
@if($errors->{ $bag ?? 'default'}->any())
    <ul class="mt-5 list-unstyled">
        @foreach($errors->{ $bag ?? 'default'}->all() as $error)
            <li class="small text-danger">{{$error}}</li>
        @endforeach
    </ul>
@endif
