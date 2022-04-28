@extends('cms.layouts.layout')

@section("title", __('Navigation'))

@section("main")
<h1 class="font-bold text-3xl mr-2 inline-block">
    {{ __('Navigation') }}
</h1>
<form action="{{ route('new_navigation') }}" method="get" class="inline-block">
    @csrf
    <button type="submit" class="p-2 rounded bg-green-200 border border-black hover:shadow-2xl hover:bg-green-500">
        + {{ __("Add") }}
    </button>
</form>

@include('cms.errors.navigation_errors')

<div class="flex justify-center items-center mt-10">
    <div class="max-w-sm">
        <div class="bg-zinc-800 text-white p-3">
            <div class="flex justify-between">
                <span>{{ __('Main navigation') }}</span>
                <span></span>
            </div>
        </div>
    
        <div id="navigation_links">
            <ul id="navigation_items_list">
                @foreach ($navigation as $navigationItem)
                   <li class="p-3 bg-white border border-black mt-1">
                    <form action="{{ route('update_navigation', ['id' => $navigationItem->id]) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <label for="">{{__('Link(href)')}}: </label>
                        <select name="href" id="href" class="bg-white h-10 w-full border border-black">
                            @foreach (\App\Models\Page::select('slug')->where('is_published', 1)->get() as $page)
                                <option value="{{$page->slug}}"
                                @if ($page->slug === $navigationItem->href)
                                    selected
                                @endif
                                >
                                /{{$page->slug}}</option>
                            @endforeach
                        </select>


                        <label for="" class="inline-block mt-3">{{__('Name')}}: </label>
                        <input type="text" name="name" placeholder="{{__('Name')}}" class="p-2 border border-black w-full" value="{{ $navigationItem->name }}">

                        <button type="submit" class="mt-2 pl-3 pr-3 rounded bg-blue-200 border border-black hover:shadow-2xl hover:bg-blue-500">{{__('Update')}}</button>
                        <span data-id="{{$navigationItem->id}}" class="delete_button hover:cursor-pointer inline-block mt-2 pl-3 pr-3 rounded bg-red-200 border border-black hover:shadow-2xl hover:bg-red-500">{{__('Delete')}}</span>
                    </form>

                    <form id="delete_form_{{ $navigationItem->id }}" action="{{ route('delete_navigation', ['id' => $navigationItem->id]) }}" method="post" class="hidden">
                    @csrf
                    @method('DELETE')
                    </form>
                </li> 
                @endforeach
            </ul>
        </div>
        
    </div>
</div>

<script>
let deleteButtons = document.getElementsByClassName('delete_button');

Array.from(deleteButtons).forEach((button)=>{
	button.addEventListener('click', function(){
  	    if(!confirm('{{ __('Do you want to delete navigation item') }}')) {
            return false;
        }

        document.getElementById('delete_form_' + button.dataset.id).submit();
  })
})
</script>

@endsection