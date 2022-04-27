@extends("cms.layouts.emtpy_layout")

@section("title", "Login")

@section("main")
<div class="flex-box-v">
    <form action="/login" method="post">
        @csrf
        <div class="flex flex-col justify-center items-center h-screen">
            <div class="flex flex-col justify-center items-center p-5 outline outline-1 rounded">
                <h1 class="text-center font-bold text-blue-500 text-3xl m-3">CMS</h1>
                <input type="text" name="username" placeholder="{{__("Username")}}" autocomplete="off" value="{{old("username", "")}}"
                       class="border border-black m-2 h-10 p-3 rounded shadow-inner"/>
                <input type="password" name="password" placeholder="{{__("Password")}}"
                       class="border border-black m-2 h-10 w-100 p-3 rounded"/>
                <div>
                    <input type="checkbox" name="remember_me" id="remember_me" value="true"/> 
                    <label for="remember_me">{{__("Remember me")}}</label>
                </div>  

                <button type="submit" 
                        class="p-3 rounded bg-blue-200 m-3 border border-black hover:shadow-2xl hover:bg-blue-500">
                    {{__("Log in")}}
                </button>
            </div>
        <div class="form-errors">

        @include('cms.errors.login_errors', ['errors' => $errors])

    </form>
</div>
@endsection

