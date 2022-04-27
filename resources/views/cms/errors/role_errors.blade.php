@if(!empty($errors->getBag("roles")->get("duplicate_name")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("roles")->get("duplicate_name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("roles")->get("name")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("roles")->get("name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("roles")->get("delete")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("roles")->get("delete") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif