<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=auto, initial-scale=1.0">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <title>@yield('page_title')</title>
</head>
<body>

<header>
    <nav>@include('themes.default.navigation')</nav>
</header>

<main class="content-container">
    @yield('page_body')
</main>    


</body>
</html>