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

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png?v=m2nMeB4vkl">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png?v=m2nMeB4vkl">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png?v=m2nMeB4vkl">
    <link rel="manifest" href="/images/favicon/site.webmanifest?v=m2nMeB4vkl">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg?v=m2nMeB4vkl" color="#5bbad5">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico?v=m2nMeB4vkl">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml?v=m2nMeB4vkl">
    <meta name="theme-color" content="#ffffff">

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
