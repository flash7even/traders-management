<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script  type="text/javascript" src="https://www.tutorialrepublic.com/examples/js/typeahead/0.11.1/typeahead.bundle.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
      
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>

    <!-- <script  type="text/javascript" src="/assets/js/typeahead.js"></script> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- <title>{{ config('app.name', 'Tarango') }}</title> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@yield('head')

</head>

<style type="text/css">
    * {
        margin: 0;
    }
    html, body {
        height: 90%;
    }
    .wrapper {
        min-height: 100%;
        height: 100%;
        /*margin: 0 auto -142px; /* the bottom margin is the negative value of the footer's height */
    }
    .footer, .push {
        /*height: 142px; /* .push must be the same height as .footer */
    }
    .dcontent {
        color: black;
        border: 5px;
    }
}
</style>

@if(Auth::check())
<?php
    $loggedu = Auth::id();
    $loguinfo = "";
    $ulist = DB::select('select * from users where id = ?', [$loggedu]);
    foreach ($ulist as $key) {
        $loguinfo = $key;
        break;
    }
    Session::put('admin_level', $loguinfo->admin);
?>
@endif

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="background-color: #E4EBF4">
            <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>                        
            </button>
             <a class="navbar-brand" class="active" href="{{ url('/') }}"> হোম </a>
            </div>

            <ul class="nav navbar-nav  navbar-left">
                <!-- Branding Image -->
                <li class=""> <a class="navbar-brand" href="{{ url('/userlist') }}"> কাস্টোমার/মহাজন </a> </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-size: 18px">লেনদেন
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    <li><a class="" href="{{ url('/proceedtobuy') }}"> ক্রয় </a></li>
                    <li><a class="" href="{{ url('/proceedtosell') }}"> বিক্রয় </a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-size: 18px">প্রোডাক্ট
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    <li><a class="" href="{{ url('/product') }}"> প্রোডাক্টের লিস্ট </a></li>
                    <li><a class="" href="{{ url('/storage') }}"> বর্তমান স্টোরেজ </a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-size: 18px">হিসাব
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    <li><a class="" href="{{ url('/sellhistory') }}"> বিক্রয়ের হিসাব </a></li>
                    <li><a class="" href="{{ url('/buyhistory') }}"> ক্রয়ের হিসাব </a></li>
                    <li><a class="" href="{{ url('/duehistory') }}"> বাকির হিসাব </a></li>
                    </ul>
                </li>


                <?php
                $admin_level = Session::get('admin_level');
                if($admin_level == 10){
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-size: 18px">নতুন এন্ট্রি
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                    <li><a class="" href="{{ url('/adduser') }}"> নতুন কাস্টোমার এড </a></li>
                    <li><a class="" href="{{ url('/addproduct') }}"> নতুন প্রোডাক্ট এড </a></li>
                    <li><a class="" href="{{ url('/addcat') }}"> নতুন ক্যাটেগরী এড </a></li>
                    </ul>
                </li>
                <?php
                }
                ?>

            </ul>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                        <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        @if(Auth::check())
                        <?php
                            $admin_level = Session::get('admin_level');
                            if($admin_level == 10){
                        ?>
                            <a href="">Profile</a>
                            <a href="{{ url('/deleteall') }}">Delete All</a>
                        <?php
                            }
                        ?>
                        @endif

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        </li>
                        </ul>
                        </li>
                    @endif
                </ul>
            </div>
            </div>
        </nav>

        @yield('content')
    </div>


    <div class="wrapper">
        <div class="push"></div>
    </div>
    <div class="footer">
          <div class="container-fluid" style="padding:5px;border: 5px solid;background-color:#F0F0FF;border-color: #F8F8FC;text-align: center;">
                    <h5>© 2016-2017 Tarango Khan All Rights Reserved</h5>
          </div>
    </div>

</body>
</html>
