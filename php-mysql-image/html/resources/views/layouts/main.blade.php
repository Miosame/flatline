<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Flatline</title>
        <link href="/resources/fontawesome-free-5.12.0-web/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/tailwind.min.css">
        <link rel="stylesheet" href="/css/main.css">
        @if(Route::current()->getName() == 'index' && env('DASHBOARD_REFRESH', 0) != 0)
            <meta http-equiv="refresh" content="{{env('DASHBOARD_REFRESH')}}">
        @endif
    </head>
    <body>
        <div class='block mx-auto mb-10 w-full px-5 md:w-1/3 max-w-xs'>
            <a href="/"><img src='/img/logo.png' class='mx-auto' /></a>

            @if (isset($online) && isset($offline))
                <div class='text-center'>
                    <div class='online inline-block rounded-full p-1 px-3 mb-2 md:mb-0 mr-2 sm:mr-5 text-white font-bold'>online: {{ $online ?? 0 }}</div> <div class='offline inline-block rounded-full p-1 px-3 text-white font-bold'>offline: {{ $offline ?? 0 }}</div>
                </div>
            @endif
        </div>
        @yield('content')
    </body>
</html>