<nav class="navbar-expand-lg navbar navbar-light bg-warning  justify-content-around p-3 ">
   <div class="container justify-content-evenly">
        <div>
    <a class="navbar-brand" href="{{ route('index') }}">
    <img src="{{ asset('/public/assets/logo.png')}}" width="100"  alt="VOA+">
{{--        /public/assets/logo.png--}}
  </a>
       
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    </div>
    <div class="collapse navbar-collapse justify-content-lg-end" id="navbarSupportedContent">
        <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('how-to-watch') }}" class="text-dark text-decoration-none p-3" target="_blank" style="font-weight: bold !important;">How to Watch</a></li>
        &nbsp;&nbsp;
        
        

        @if(!session()->has('auth_user') || session()->get('auth_user') == null)
            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('login') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">LOGIN</a></li>
            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('register') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">REGISTER</a></li>
        @elseif(session()->has('token_full_error') && session()->get('token_full_error') != null)
            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('reset_login_state') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">Remove All Devices</a></li>
            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('logout') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">logout</a></li>
        @elseif(session()->has('auth_user') && session()->has('auth_user') != null)
{{--            @if(Route::current()->getName() == 'login' || Route::current()->getName() == 'register' || Route::current()->getName() == 'index')--}}
{{--            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('my_account') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">Watch VOA+</a></li>--}}
{{--            @endif--}}
            @if(Route::current()->getName() == 'view_stream' || Route::current()->getName() == 'logged_stream'|| Route::current()->getName() == 'change-channel')
                <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('remove_device') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">Remove this device</a></li>
            @endif
            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('change_password_profile') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">Change password</a></li>
                    <hr class="m-0 p-0">
            <li class="nav-item mt-2 mt-lg-0 list-unstyled"><a href="{{ route('logout') }}" class="text-dark text-decoration-none p-3" style="font-weight: bold !important;">
                    Logout&nbsp;<i class="fa fa-power-off" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout"></i>
                </a></li>
        @endif
        
    </div>
   </div>
</nav>

