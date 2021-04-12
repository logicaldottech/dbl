<html>
<head>
<title>@yield('title')</title>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}" />

</head>

<body>
  <input type="hidden" id="APP_URL" value="{{url('/')}}"/>
  <header class="app-header">
    <nav class="app-topbar navbar navbar-light">
      <a class="navbar-brand" href="{{url('/')}}" >Dollar Business Leads</a>
      <div class="app-topbar-right">
        <div class="notification">
        <i class="action-sort-icon"  stroke-width="2" data-feather="bell"></i>
      </div>
      <div class="top-bar-dropdown" id="top-bar-dropdownlink">
        <div class="dropdown">
          <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span>{{'f'}}</span>  <span id="UserMenu"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Profile</a>
            <a class="dropdown-item" href="#">Credits</a>
            <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
          </div>
        </div>
      </div><!--.top-bar-dropdown-->
      </div><!--.app-topbar-right-->
    </nav>
  </header><!--.app-header-->
<div>
  @yield('content')
</div>

  <script src="https://use.fontawesome.com/48f2f9a745.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
  </body>
  </html>
