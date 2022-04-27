@extends("cms.layouts.layout")

@section("title", __('Pages'))

@section("main")

<h1 class="font-bold text-3xl mr-2 text-center mb-10">
    <span class="border-b-4 border-blue-900">{{ __('Create new navigation item') }}</span>
</h1>

@include('cms.errors.navigation_errors')

<div class="flex justify-center items-center mt-10">
    <div>
        <form action="{{ route('create_navigation_item') }}" method="post">
            @csrf

            <div class="flex items-center justify-between">
                <label for="href">{{ __('Link(href)') }}</label>
                <input type="text" name="href" id="href" class="border border-black m-2 h-10 p-3 rounded shadow-inner">
            </div>
            <div class="flex items-center justify-between">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="border border-black m-2 h-10 p-3 rounded shadow-inner">
            </div>

            <button type="submit"
            class="p-2 mt-10 w-full rounded bg-green-200 border border-black 
            hover:shadow-2xl hover:bg-green-500 flex items-center justify-center">
                {{ __('Save') }}
            </button>

        </form>
    
    </div>
</div>

@endsection