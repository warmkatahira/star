<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>スターデザイン管理システム</title>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('image/favicon.svg') }}">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/sass/theme.scss'])

        <!-- LINE AWESOME -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&family=Lemonada&display=swap" rel="stylesheet">

        <!-- Lordicon -->
        <script src="https://cdn.lordicon.com/pzdvqjsp.js"></script>

        <!-- toastr.js -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </head>
    <body>
        <!-- アラート表示 -->
        <x-alert/>
        <div class="flex mt-3">
            @auth
                <a href="{{ route('top.index') }}" class="mr-10 ml-auto">ホーム</a>
            @else
                <a href="{{ route('login') }}" class="mr-10 ml-auto">ログイン</a>
            @endauth
        </div>
        <div class="text-center">
            <p class="text-3xl">スターデザイン管理システム</p>
        </div>
    </body>
</html>
