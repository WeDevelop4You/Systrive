<!doctype html>
<html>
    <head>
        <title>WeDevelop4you</title>

        <meta charset="utf-8">
        <meta name="author" content="Pascal Huberts">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="pascal,huberts,pascal huberts,netherlands,website,web development,web designer,application,developer,html,php,javascript,css,wedevelop4you,we develop for you">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#006eff">
        <meta name="twitter:card" content="summary_large_image">
        <meta property="og:title" content="Web developer: WeDevelop4You"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="https://www.wedevelop4you.nl"/>
        <meta property="og:image" content="https://www.wedevelop4you.nl/images/WeDevelop4You.png"/>

        <link rel="icon" href="{{ asset('images/site-icon.png') }}">
        <link rel="stylesheet" href="{{ asset('css/site/app.css') }}">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black&display=swap" rel="stylesheet">

        <script>window.Laravel = { crsfToken: '{{ csrf_token() }}' }</script>
    </head>

    <body>
        <div id="app">
            <Index/>
        </div>
    </body>
    <script src="{{ asset('js/site/app.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140790022-1"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-140790022-1');
    </script>
</html>
