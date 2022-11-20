<nav class="d-flex flex-column navbar navbar-expand-xl navbar-expand-lg navbar-expand-md  navbar-expand-sm w3-flat-clouds">

    <div class="container nav-up">
        <!--   brand in nav menu     -->
        <a class="navbar-brand" href="{{ route('home') }}">
            {{-- <img src="" alt="logo" width="90" height="70"> --}}
            وب سولو
        </a>
        <span onclick="openNav()" class="sidenav-open"><i class="fa fa-bars fa-2x"></i></span>
        <!--  navbar main item      -->
        <ul class="navbar-nav  header-up-item   mb-2 mt-3">
            @if(Auth::check())
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/users/icons8-user-32.png') }}" alt="user icon">
                    </a>
                    <ul class="dropdown-menu w3-flat-clouds">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">حساب کاربری</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">خروج</a></li>
                    </ul>
                </li>
            @else
                <li class="nav-item nav-sign-in text-center">
                    <a href="{{ route('loginForm') }}" class="nav-link btn me-2">ورود</a>
                </li>
                <li class="nav-item nav-sign-up text-center">
                    <a href="{{ route('registerForm') }}" class="nav-link btn me-2">ثبت نام</a>
                </li>
             @endif
            <li class="nav-item text-center">
                <a href="#" class="anchor-shop me-3 ">
                    <i class="fa fa-shopping-basket mt-2"></i>
                </a>
            </li>
        </ul>

    </div>

    <div class="container nav-down mt-2">
        <ul class="navbar-nav header-down-item-right">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">خانه</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sampleIndex') }}">نمونه کارها</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('articleIndex') }}">مقالات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('trainingIndex') }}">آموزش ها</a>
            </li>
        </ul>
        <ul class="navbar-nav header-down-item-left">
            <li class="nav-item">
                <a class="nav-link about-us" href="{{ route('aboutUs') }}">درباره ما</a>
            </li>
            <li class="nav-item">
                <a class="nav-link contact-us" href="{{ route('contactUs') }}">ارتباط با ما</a>
            </li>
        </ul>
    </div>
</nav>
