@if(!empty($errors->getBag("users")->get("user")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("users")->get("user") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("password")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("users")->get("password") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("username")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("users")->get("username") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("first_name")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("users")->get("first_name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("last_name")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("users")->get("last_name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("users")->get("delete")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("users")->get("delete") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif