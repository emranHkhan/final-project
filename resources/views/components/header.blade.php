<nav class="navbar navbar-expand-lg bg-primary" id="top-navbar">
    <div class="container-fluid">
        <a class="navbar-brand text-light text-2xl font-weight-bolder font-italic" href={{ url('/') }}>JOBPULSE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon text-light">+</span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex w-100">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}"
                        href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('blogs') ? 'active' : '' }}"
                        href="{{ route('blogs') }}">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('jobs') ? 'active' : '' }}"
                        href="{{ route('jobs') }}">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item" id="signup">
                    <a class="nav-link text-white {{ request()->is('userRegistration') ? 'active' : '' }}"
                        href="{{ route('register') }}">Sign Up</a>
                </li>
                <li class="nav-item" id="login">
                    <a class="nav-link text-white {{ request()->is('userLogin') ? 'active' : '' }}"
                        href="{{ route('login') }}">Log In</a>
                </li>
                <li class="float-right h-auto d-flex ml-2" id="profile">
                    <div class="user-dropdown">
                        <img class="icon-nav-img" src="{{ asset('images/user.webp') }}" alt="" />
                        <div class="user-dropdown-content">
                            <div class="mt-4 text-center">
                                <img class="icon-nav-img" src="{{ asset('images/user.webp') }}" alt="" />
                                <h6 id="username" class="mt-2"></h6>
                                <hr class="user-dropdown-divider p-0" />
                            </div>
                            <a href="#" class="side-bar-item" id="dashboard">
                                <span class="side-bar-item-caption" id="dashboard_name"></span>
                            </a>
                            <a href="{{ url('/userProfile') }}" class="side-bar-item">
                                <span class="side-bar-item-caption account"></span>
                            </a>
                            <a href="{{ url('/logout') }}" onclick="removeInfo()" class="side-bar-item">
                                <span class="side-bar-item-caption">Logout</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function removeInfo() {
        removeToken('token')
        removeToken('user')
    }

    function showLinks() {
        const user = JSON.parse(getToken('user'));
        if (user) {
            document.getElementById('login').classList.add('d-none');
            document.getElementById('signup').classList.add('d-none');;
            document.getElementById('profile').classList.remove('d-none')

            if (user.role === 'candidate') {
                document.querySelector('.account').textContent = 'Account'
            } else {
                document.querySelector('.account').textContent = 'Profile'
            }
        } else {
            document.getElementById('profile').classList.add('d-none')
        }
    }

    function showUserName() {
        const {
            firstName,
            lastName,
            role
        } = JSON.parse(getToken('user')) || {
            firstName: '',
            lastName: ''
        };
        document.getElementById('username').textContent = `Welcome! ${firstName} ${lastName}`;
        document.getElementById('dashboard').href = '/' + role + '/dashboard';
        document.getElementById('dashboard_name').textContent = 'Dashboard';
    }

    showLinks()
    showUserName()
</script>
