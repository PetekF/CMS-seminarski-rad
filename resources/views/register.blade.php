@extends("layout")

@section("title", "Register")

@section("main")
<div class="flex-box-v">
    <h1>Registracija</h1>
    <form action="/register" method="post" class="registration-form flex-box-v">
         @csrf
         <input type="text" name="name" placeholder="Ime" autocomplete="off" value="{{old("name", "")}}"/>
         <input type="email" name="email" placeholder="E-mail" autocomplete="off" value="{{old("email", "")}}"/>
         <input type="password" name="password" placeholder="Lozinka"/>
         <input type="password" name="password_confirmation" placeholder="Ponovi lozinku" />
         <a href="/login">Log in</a>
         <button type="submit">Registritaj se</button>
    </form>
    @if(session()->has("registration_success"))
    <div class="registration-success">
        <p style="text-align: center">Registracija uspješna!</p>
        <p><a href="/login">Ulogirajte se</a> u svoj korisnički račun</p>
    </div>
    @endif
    <div class="form-errors">
        @if(!empty($errors->getBag("registration")->get("name")))
        <div class="form-error-segment">
            @foreach($errors->getBag("registration")->get("name") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
        
        @if(!empty($errors->getBag("registration")->get("email")))
        <div class="form-error-segment">
            @foreach($errors->getBag("registration")->get("email") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
        
        @if(!empty($errors->getBag("registration")->get("password")))
        <div class="form-error-segment">
            @foreach($errors->getBag("registration")->get("password") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
        
        @if(!empty($errors->getBag("registration")->get("password_confirmation")))
        <div class="form-error-segment">
            @foreach($errors->getBag("registration")->get("password_confirmation") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
        
        @if(!empty($errors->getBag("registration")->get("user")))
        <div class="form-error-segment">
            @foreach($errors->getBag("registration")->get("user") as $error)
            <p>&#8226 {{$error}}</p>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection

