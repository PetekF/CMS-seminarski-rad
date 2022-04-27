<!doctype html>
<html lang="en">
    <head>
        <meta name="author" content="Filip Petek"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - CMS</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('ckeditor4/ckeditor/ckeditor.js')}}"></script>
        <style>
            .my-admin-header-height{
                height: 48px;
                max-height: 48px;
            }

            .my-admin-content-height{
                height: calc(100vh - 48px);
                max-height: calc(100vh - 48px);
            }

        </style>
    </head>
    <body class="h-screen max-h-screen">
        {{-- <div class="max-h-full"> --}}
            <div class="w-screen my-admin-header-height p-2 pl-5 pr-5 text-white bg-slate-800 border-b-4 border-blue-500 flex justify-between md:justify-end">
                <div class="hover:text-blue-400 hover:underline pl-2 ml-2 md:hidden hover:cursor-pointer select-none">
                    <span id="menu-button">{{__("Menu")}}</span>
                </div>
                <div class="hover:text-red-400 hover:underline border-l border-white pl-2 ml-2">
                    <a href="/logout">{{__("Log out")}}</a>
                </div>
            </div>
            <div class="flex flex-grow my-admin-content-height bg-gray-300 relative ">
                <div id="navigation-menu" class="hidden md:flex md:w-56 border-r-4 border-blue-500">
                    @include('cms.includes.cms_navigation')
                </div>
                <div class="p-8 flex-grow overflow-auto"> {{-- flex-grow was here --}}
                    @yield('main')
                </div>
            </div>
        {{-- </div> --}}
    </body>

    <script>
        let nav = document.getElementById("navigation-menu");
        let navBtn = document.getElementById("menu-button");

        navBtn.addEventListener("click", function(){
            if(nav.classList.contains("hidden")){
                nav.classList.remove("hidden");
                nav.classList.add("absolute");
            }
            else{
                nav.classList.add("hidden");
                nav.classList.remove("absolute");
            }
        });
    </script>
</html>
 