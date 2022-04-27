@if(!empty($errors->getBag("pages")->get("taken")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("pages")->get("taken") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("pages")->get("delete")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("pages")->get("delete") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("pages")->get("title")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("pages")->get("title") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(!empty($errors->getBag("pages")->get("slug")))
<div class="text-center border bg-red-500 p-3 m-3">
    @foreach($errors->getBag("pages")->get("slug") as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif
