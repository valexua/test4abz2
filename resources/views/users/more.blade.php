@if ( $users != null )
    @foreach ($users as $user)
    <div class="list-group-item list-group-item-action d-flex align-items-center">
        <img src="{{ $user->photo }}" alt="ID {{ $user->id }}" class="rounded-circle mr-3" width="50" height="50">
            <div>
                <p><strong>{{ $user->name }}</strong></p>
                <p class="text-muted">
                    Email: {{ $user->email }}<br>
                    Phone: {{ $user->phone ?? "" }}<br>
                    Position: {{ $user->position ?? "" }}
                </p>
            </div>
    </div>
    @endforeach
@endif

@if (!($hasMoreUsers ?? true) && isset($users) )
    <div id="noMoreUsers"></div>
@endif

@if (!($hasMoreUsers2 ?? true) && $users == [])
    <div id="noMoreUsers2"></div>
@endif
