<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - BIS</title>

    <!-- Scripts -->
    @yield('scripts')
    {{-- <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    
    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- Bootstrap JavaScript CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

</head>

        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              
                <img class="float-start" src="{{ asset('images/logo-taguig.png') }}" alt="" width="96px" height="96px" class="d-inline-block align-text-top">
                <a class="ms-3 navbar-brand" href="#">
                    
                    <h4>Barangay Information System</h4>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02" >
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else

                            <li><a class="nav-link ms-3" href="/home">{{ __('Home') }}</a></li>
                            <li><a class="nav-link ms-3" href="{{ route('officials.index') }}">Barangay Officials</a></li>
                        

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle ms-3" href="#" id="navbarDarkDropdownMenuLink" role="button" aria-expanded="false">
                                      Services
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                      <li><a class="dropdown-item" href="{{ route('documents.create') }}">Request Document</a></li>
                                    @role('Admin')
                                      <li><a class="dropdown-item" href="{{ route('complaints.create') }}">Record Complaint</a></li>
                                      <li><a class="dropdown-item" href="{{ route('blotters.create') }}">File Blotter</a></li>
                                    @endrole
                                      <li><a class="dropdown-item" href="/documents/scan">Document Scanner</a></li>
                                      {{-- @if (Auth::user()->hasRole('Admin'))
                                        <li><a class="dropdown-item" href="{{ route('services.index') }}">Service Management</a></li>
                                      @endif --}}
                                    </ul>
                                  </li>

                        
                            @if (Auth::user()->hasRole('Admin'))
                            
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle ms-3" href="#" id="navbarDarkDropdownMenuLink" role="button" aria-expanded="false">
                                      Transactions
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                        <li><a class="dropdown-item" href="{{ route('documents.index') }}">Documents Management</a></li>
                                        <li><a class="dropdown-item" href="{{ route('complaints.index') }}">Complaints Management</a></li>
                                        <li><a class="dropdown-item" href="{{ route('blotters.index') }}">Blotters Management</a></li>
                                    </ul>
                                  </li>
                                
                                <li><a class="nav-link ms-3" href="{{ route('users.index') }}">User Management</a></li>
                                <li><a class="nav-link ms-3" href="{{ route('reports.index') }}">Reports</a></li>
                            @endif
                        
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle me-5 ms-5" href="#" id="navbarDarkDropdownMenuLink" role="button" aria-expanded="false">
                                Account
                                </a>

                                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ route('profiles.edit', Auth::user()->id) }}">{{ __('Edit Profile') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
            
        </nav>
    
    
    <main class="py-4">
        <div class="container" style="margin-top: 130px">
            {{ $slot }}
        </div>
    </main>

    @yield('custom-scripts')
</html>