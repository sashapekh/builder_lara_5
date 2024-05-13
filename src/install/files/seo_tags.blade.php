<title> {{$page->getSeoTitle()}} {{Setting::get("okonchanie-title")}} </title>
<meta name="description" content="{{$page->getSeoDescription()}}" />
<meta property="og:title" content="{{$page->getSeoTitle()}} {{Setting::get("okonchanie-title")}}"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="{{URL::current()}}" />
<meta property="og:description" content="{{$page->getSeoDescription()}}"/>