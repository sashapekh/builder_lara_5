<!DOCTYPE html>
<html lang="[lang]" prefix="og: http://ogp.me/ns#">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='true' name='HandheldFriendly'/>
    <meta content='width' name='MobileOptimized'/>
    <meta content='yes' name='apple-mobile-web-app-capable'/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="/favicon.ico">

    @yield('seo_tags')
</head>
<body>

<div id="content_page">
    @yield('main')
</div>
</body>
</html>