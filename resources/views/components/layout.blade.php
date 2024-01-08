<!doctype html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Redacted+Script:wght@400">

    @vite(['resources/css/test-vite.css', 'resources/js/test-vite.js', 'resources/css/app.css', 'resources/js/app.js', 'resources/css/profile.css', 'resources/css/accueil.css', 'resources/css/histoire.css'])

    <title>{{$titre ?? "Read'nLive"}}</title>
</head>
<body>
<x-header></x-header>
<main class="main-container">
    {{$slot}}
</main>
<footer>
    <div id="left">© IUT de Lens</div>
    <div id="right">
        <img src="{{url('/images/logo.jpg')}}" alt="">
    </div>
</footer>
</body>
</html>
