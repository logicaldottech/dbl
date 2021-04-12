<header class="app-header">
  <nav class="app-topbar navbar navbar-light">
    <a class="navbar-brand" href="{{url('/')}}" >
      <img src="{{asset('assets/img/logocolored.png')}}" />
    </a>
    <div class="app-topbar-right">
      <a href="{{url('/purchase')}}" class="btn btn-outline-success" id="purchaselink">Purchase Credits</a>
      <div class="d-none notification">
      <i class="action-sort-icon"  stroke-width="2" data-feather="bell"></i>
    </div>
    <div class="top-bar-dropdown" id="top-bar-dropdownlink">
      <div class="dropdown">
        <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <input type="hidden" id="user_id_login" value={{$user->id}} readonly/>
        <span>{{$user->first_name . " " . $user->last_name}}</span>  <span id="UserMenu"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          @if ($isHome === false )
          <a class="dropdown-item" href="{{url('/')}}">Home</a>
          @endif
          <a class="dropdown-item" href="{{url('/profile')}}">Profile</a>
          <a class="dropdown-item" href="{{route('credits')}}">Credits</a>
          <a class="dropdown-item" href="{{route('my-download-view')}}">Downloads</a>
          <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
        </div>
      </div>
    </div><!--.top-bar-dropdown-->
    </div><!--.app-topbar-right-->
  </nav>
</header><!--.app-header-->
