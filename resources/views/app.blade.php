<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <title inertia>Arduino Classroom</title>
    @routes
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @inertiaHead

</head>
<body>
    <div id="preloader-custom">
        <div class="spinner-custom"></div>
    </div>

    <div id="app" class="page-left-menu" data-page='@json($page)'></div>
</body>
</html>
