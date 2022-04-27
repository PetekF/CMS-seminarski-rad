@if(!empty($errors->getBag("users")->get("user")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("users")->get("user") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("password")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("users")->get("password") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("username")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("users")->get("username") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("first_name")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("users")->get("first_name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("last_name")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("users")->get("last_name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("delete")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("users")->get("delete") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif
