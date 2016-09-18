<html lang="en">
<head>
    @include('partials/head')
    <title>Photogram - @yield('title')</title>
</head>
<body>
    @include('partials/header')

    <div class="container">
        @yield('content')
    </div>

    @include('partials/footer')
</body>
</html>