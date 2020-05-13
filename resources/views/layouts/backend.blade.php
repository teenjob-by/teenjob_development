<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Teenjob.by - панель управления') }}</title>

    <!-- Scripts -->


    <script> window.Laravel = { csrfToken: 'csrf_token() ' } </script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ mix('/css/backend/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="admin">
        <Layout
                :user-name='@json(auth()->user()->name)'
                :user-id='@json(auth()->user()->id)'
                :user-token='@json(auth()->user()->createToken('Token')->accessToken)'>
        </Layout>
    </div>
    <script src="{{ mix('/js/backend/app.js') }}"></script>
</body>
</html>
