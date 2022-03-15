@extends("layout")

@section("title", "Login")

@section("main")
<div class="flex-box-v">
    <h1>Log in</h1>
    <form action="/login" method="post" class="login-form flex-box-v">
        @csrf
        <input type="email" name="email" placeholder="E-mail" autocomplete="off" value="{{old("email", "")}}"/>
        <input type="password" name="password" placeholder="Lozinka"/>
        <a href="/register">Registracija</a>
        <button type="submit">Ulogiraj se</button>
    </form>

    <div class="form-errors">
        @if(!empty($errors->getBag("login")->get("email")))
        <div class="form-error-segment">
            @foreach($errors->getBag("login")->get("email") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif

        @if(!empty($errors->getBag("login")->get("password")))
        <div class="form-error-segment">
            @foreach($errors->getBag("login")->get("password") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
        
        @if(!empty($errors->getBag("login")->get("user")))
        <div class="form-error-segment">
            @foreach($errors->getBag("login")->get("user") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

