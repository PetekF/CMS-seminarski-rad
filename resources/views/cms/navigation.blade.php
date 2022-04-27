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
                        <input type="text" name="href" placeholder="{{__('Link(href)')}}" class="p-2 border border-black w-full" value="{{ $navigationItem->href }}">
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
                {{-- <li class="p-3 bg-white border border-black">
                    <form action="" method="post">
                        <input type="text" placeholder="{{__('Link(href)')}}" class="p-2 border border-black w-full">
                        <input type="text" placeholder="{{__('Name')}}" class="p-2 border border-black w-full mt-2">
                    </form>
                </li> --}}
                
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