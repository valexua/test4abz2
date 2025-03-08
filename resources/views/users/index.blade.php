<!DOCTYPE html>
<html lang="uk">
    <title>Список користувачів</title>
    @include('users/header')

<body>
    

    <div class="container mt-5">
        @if (url()->current() === url()->previous())
            <a href="/" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
        @else
            <a href="{{ url()->previous()  }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
        @endif
        <br><br>

        <!-- <h1 class="mb-4">User list</h1> -->
        <div class="card text-white bg-secondary mb-3" style="max-width: 256rem;">
            <div class="card-header"><h1>Користувачі:</h1></div>
        <div id="userList" class="list-group">
            @foreach ($users as $user)
            <div class="list-group-item list-group-item-action d-flex align-items-center">
                <img src="{{ $user->photo }}" alt="ID {{ $user->id }}" class="rounded-circle mr-3" width="70" height="70">
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
        </div>
        <button id="loadMore" class="btn btn-lg btn-block btn-light mt-4" data-url="{{ url('/users/load-more') }}" data-offset="10">Показати більше</button>
        </div>
   
        <br>
        <br>

        <!-- <h1 class="mb-4">User list</h1> -->
        <div class="card text-white bg-secondary mb-3" style="max-width: 256rem;">

            <div class="card-header"><h1>Користувачі Api users:</h1></div>

         <div id="userListApi" class="list-group">

            @foreach ($usersApi as $user)

            <div class="list-group-item list-group-item-action d-flex align-items-center">
                
                <img src="{{ $user->photo }}" alt="ID {{ $user->id }}" class="rounded-circle mr-3" width="50" height="50">
                <div>
                    <p><strong>{{ $user->name }}</strong></p>
                    <p class="text-muted">
                        Email: {{ $user->email }}<br>
                        Phone: {{ $user->phone }}<br>
                        Position: {{ $user->position }}
                    </p>
                </div>
            </div>

            @endforeach

         </div>

            <button id="loadMoreApi" 
                    class="btn btn-lg btn-block btn-light mt-4" 
                    data-url="{{ url('/users/load-more-api') }}" 
                    data-page=2> Показати більше </button>
            
        </div>

    </div>
    <br><br>

    <script>
        $(document).ready(function() {
            $('#loadMore').click(function() {

                const url = $(this).attr('data-url');
                const offset = $(this).data('offset');

                $.get(url + '?offset=' + offset)
                 .done(function(data) {
                    $('#userList').append(data);
                    $('#loadMore').data('offset', offset + 6);
                    if ($('#userList').find('#noMoreUsers').length) { $('#loadMore').hide(); }
                 })
                 .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Error: " + textStatus, errorThrown);
                    console.log("Response Text: ", jqXHR.responseText);
                 });
            });


            $('#loadMoreApi').click(function() {

                const url = $(this).attr('data-url');
                const page = $(this).data('page');

                $.get(url + '?page=' + page)
                 .done(function(data) {
                    $('#userListApi').append(data);
                    $('#loadMoreApi').data('page', page + 1);
                    if ($('#userListApi').find('#noMoreUsers2').length) { $('#loadMoreApi').hide(); }
                 })
                 .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Error: " + textStatus, errorThrown);
                    console.log("Response Text: ", jqXHR.responseText);
                 });
            });
        });
    </script>
</body>

    @include('users/footer')
    
</html>
