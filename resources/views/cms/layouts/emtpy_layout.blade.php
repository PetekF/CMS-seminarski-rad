<!doctype html>
<html lang="en">
    <head>
        <meta name="author" content="Filip Petek"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - CMS</title>
        <!--<link rel="stylesheet" href="css/style.css"/>-->
        <!--<link rel="stylesheet" href="css/app.css"/>-->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div>
            @yield('main')
        </div>
    </body>
</html>
 
