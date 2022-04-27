@if(!empty($errors->getBag("login")->get("login_forbidden")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("login")->get("login_forbidden") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("login")->get("password")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("login")->get("password") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("login")->get("user")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("login")->get("user") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("login")->get("email")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("login")->get("email") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif