@if(!empty($errors->getBag("roles")->get("duplicate_name")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("roles")->get("duplicate_name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("roles")->get("name")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("roles")->get("name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("roles")->get("delete")))
<div class="border border-red-800 bg-red-500">
    @foreach($errors->getBag("roles")->get("delete") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif