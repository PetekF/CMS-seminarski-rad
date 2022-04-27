@if(!empty($errors->getBag("navigation")->get("name")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("navigation")->get("name") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("navigation")->get("href")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("navigation")->get("href") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif