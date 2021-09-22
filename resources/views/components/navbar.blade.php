<nav class="row shadow-lg m-0 fixed-top">
    <div
        class="col-lg-2 d-flex justify-content-between align-items-center bg-dark text-white border-bottom border-white">
        <a class="brand" href="#">
            <h3>Property</h3>
        </a>
        <div id="sidebar_btn"><i class="fas fa-bars"></i></div>
    </div>
    <div class="col-lg-10 bg-white d-none d-lg-flex justify-content-end align-items-center ">
        <div class="profile mr-4 text-center">
            <div class="dropdown " id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span>
                    <img src="{{ asset(Auth::user()->image) }}" alt="profile"/>
                    <p class="m-0">{{ Auth::user()->name }}</p>
                </span>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('editprofile') }}">
                    {{ __('Profile') }}
                </a>
                <a class="dropdown-item" href="{{ route('changepassword') }}">
                    {{ __('Change Password') }}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
