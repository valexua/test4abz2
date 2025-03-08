<!DOCTYPE html>
<html lang="uk">

<title>Реєстрація </title>
@include('users/header')

<body>
    
    <div class="container mt-5">
    @if (url()->current() === url()->previous())
        <a href="/" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
    @else
        <a href="{{ url()->previous()  }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
    @endif

        <br><br>
        <h1 class="mb-4">Реєстрація нового користувача</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         <form method="POST" action="{{ '/api-register' }}" enctype="multipart/form-data"> <!--route('register2') -->
        @csrf
    <div class="form-group">
        <label for="name">Ім'я</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Введіть ім'я">
    </div>

    <div class="form-group">
        <label for="email">Електронна пошта</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="example@email.com">
    </div>

    <div class="form-group">
        <label for="phone">Телефон</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+380XXXXXXXXX">
    </div>

    <div class="form-group">
        <label for="position_id">Позиція</label>
        <select class="form-control" id="position_id" name="position_id">
            <option value="" disabled selected>Оберіть позицію</option>
            @foreach ($viewData as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="photo">Фотографія</label>
        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/jpeg">
    </div>

    <button type="submit" class="btn btn-lg btn-block btn-outline-primary mt-4">Зареєструватися</button>
</form>


        <!-- <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Ім'я</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email">Електронна пошта</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Підтвердження паролю</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-lg btn-block btn-outline-primary mt-4">Зареєструватися</button>
        </form> -->
    </div>
    <br>


</body>

    @include('users/footer')

</html>
