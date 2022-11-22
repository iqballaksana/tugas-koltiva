<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href={{ asset('assets/css/bootstrap.min.css') }}>
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="alert alert-success mt-5" role="alert">
                Boostrap 5 is working!
            </div>    
        </div>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    </body>
</html>
