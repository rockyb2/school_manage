<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title></title>
    @vite('resources/css/app.css')
   @include('sweetalert2::index')



</head>
<body class="  ">
    {{ $slot }}
    @stack('scripts')
</body>
</html>
