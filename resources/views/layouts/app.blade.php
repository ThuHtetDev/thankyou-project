<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Thank You </title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
    .flex-wrapper {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
      justify-content: space-between;
      background: url("/images/bg01.jpg") top center;
      background-repeat: no-repeat;
      background-size: 100% auto;
      background-position: center top;
      background-attachment: fixed;
    }
    </style>
</head>
<body>
  <div id="app" class="flex-wrapper">
    <sidebar-component></sidebar-component>
    
    <div class="content-wrapper">
      <router-view></router-view>
    </div>

    <footer-component></footer-component>
  </div>
 
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
