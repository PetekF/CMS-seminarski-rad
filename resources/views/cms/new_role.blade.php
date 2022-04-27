@extends("cms.layouts.layout")

@section("title", __('Roles'))

@section("main")

<h1 class="font-bold text-3xl mr-2 text-center mb-10">
    <span class="border-b-4 border-blue-900">{{ __($role_form_heading) }}</span>
</h1>

@include('cms.errors.role_errors', ['errors' => $errors])

<div class="flex justify-center">
    <form action="{{ $form_action }}" method="post">
        @csrf

        <div class="flex items-center justify-between">
            <label for="name">{{ __('Name') }}: </label>
            <input type="text" id="name" name="name" 
            value="{{ $role->name ?? '' }}"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        
        <div class="flex items-center justify-around">
            <button type="submit" 
            class="p-2 mt-10 w-full rounded bg-green-200 border border-black 
            hover:shadow-2xl hover:bg-green-500 flex items-center justify-center
            ">{{ __('Save') }}</button>
        </div>
        
    </form>
</div>
@endsection