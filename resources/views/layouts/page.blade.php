<html>
<head>
<title>@yield('title')</title>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
  <input type="hidden" id="APP_URL" value="{{url('/')}}"/>
  <input type="hidden" id="USERID" value="{{$user->id}}"/>
  @component('components.appheader',['user' => $user,'isHome' => false]  )
	@endcomponent
  @yield('content')

  @component('components.appfooter')
	@endcomponent
  <script type="text/javascript" src="{{asset('js/other.js')}}"></script>
  </body>
  </html>
