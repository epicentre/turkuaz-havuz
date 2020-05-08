<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
</head>
<body>
<div id="app"></div>

{{-- Load the application scripts --}}
<script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>
