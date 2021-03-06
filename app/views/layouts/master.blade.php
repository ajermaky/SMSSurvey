<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('title') | SMS Surveys</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <script src="{{ asset('assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{action('HomeController@showWelcome')}}">SMS Survey</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Phone Numbers<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ action('PhoneNumbersController@index') }}">Edit Phone Numbers</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ action('PhoneNumbersController@failed') }}">Failed Messages</a></li>
                  </ul>
                </li>
                <li><a class="navbar-brand" href="{{ action('SurveyQuestionsController@index') }}">Questions</a></li>
                <li><a class="navbar-brand" href="{{ action('ModemController@index') }}">Modem Usage</a></li>
                <li><a class="navbar-brand" href="{{ action('SettingsController@index') }}">Settings</a></li>

            </ul>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<div class="container">
    @yield('content')

    <hr>

    <footer>
        <p>&copy; Cal-it2 2015</p>
    </footer>
</div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('assets/js/vendor/jquery-1.11.1.min.js') }}"><\/script>')</script>

<script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
