@extends("cms.layouts.layout")

@section("title", __('Users'))

@section("main")

<h1 class="font-bold text-3xl mr-2 text-center mb-10">
    <span class="border-b-4 border-blue-900">{{ __($user_form_heading) }}</span>
</h1>

@include('cms.errors.user_errors', ['errors' => $errors])

<div class="flex justify-center">
    <form action="{{ $form_action }}" method="post">
        @csrf

        <div class="flex items-center justify-between">
            <label for="username">{{ __('Username') }}: </label>
            <input type="text" id="username" name="username" 
            value="{{ $user->username ?? '' }}"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        <div class="flex items-center justify-between">
            <label for="first_name">{{ __('First name') }}: </label>
            <input type="text" id="first_name" name="first_name"
            value="{{ $user->first_name ?? '' }}"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        <div class="flex items-center justify-between">
            <label for="last_name">{{ __('Last name') }}: </label>
            <input type="text" id="last_name" name="last_name"
            value="{{ $user->last_name ?? '' }}"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        <div class="flex items-center justify-between">
            <label for="email">{{ __('Email') }}: </label>
            <input type="email" id="email" name="email"
            value="{{ $user->email ?? '' }}"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        <div class="flex items-center justify-between">
            <label for="password" 
            title="{{ __('Password must contain at least 6 characters, 1 uppercase letter, 1 lowercase, 1 number and 1 special character') }}"
            >{{ __('Password') }}*: </label>
            <input type="password" id="password" name="password"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        <div class="flex items-center justify-between">
            <label for="password_confirmation">{{ __('Confirm password') }}: </label>
            <input type="password" id="password_confirmation" name="password_confirmation"
            class="border border-black m-2 h-10 p-3 rounded shadow-inner">
        </div>
        <div class="flex items-center justify-around">
            <label for="role">{{ __('Role') }}: </label>
            <select name="role" id="role" class="bg-white h-10">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst(__($role->name)) }}</option>
                @endforeach
            </select>
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