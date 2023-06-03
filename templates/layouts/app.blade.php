<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="URL Shortening Service">
    <meta name="author" content="Rcsvpg">

    <!-- CSS -->
    @include('layouts.css')

    <title>URL Shortening Service</title>
    <link rel="canonical" href="https://mur.ls">

    <!-- Favicons -->

    <!-- Custom styles for this template -->
    {{-- todo: link additional css --}}
    <link href="/css/main.css" rel="stylesheet">

</head>
<body>
    <header>

    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        
    </footer>
    <!-- javascript -->
    @include('layouts.javascript')

</body>
</html>