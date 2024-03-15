<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title></title>

    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastify.min.css') }}" rel="stylesheet" />


    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}"
        rel="stylesheet" />

    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>


    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>




</head>

<body>



    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>


    <nav class="navbar fixed-top px-0 shadow-sm bg-white">
        <div class="container-fluid">

            <a class="navbar-brand text-2xl font-weight-bold" href="{{ url('/') }}">
                JOBPULSE
            </a>



            <div class="float-right h-auto d-flex">
                <div class="user-dropdown">
                    <span id="role"
                        class="font-weight-bold mr-1 text-uppercase badge rounded-pill bg-secondary"></span>
                    <img class="icon-nav-img" src="{{ asset('images/user.webp') }}" alt="" />
                    <div class="user-dropdown-content ">
                        <div class="mt-4 text-center">
                            <img class="icon-nav-img" src="{{ asset('images/user.webp') }}" alt="" />
                            <h6 id="current_user" class="mt-2"></h6>
                            <hr class="user-dropdown-divider  p-0" />
                        </div>
                        <a href="{{ url('/userProfile') }}" class="side-bar-item">
                            <span class="side-bar-item-caption dashboard-account"></span>
                        </a>
                        <a href="{{ url('/logout') }}" onclick="removeInfo()" class="side-bar-item">
                            <span class="side-bar-item-caption">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div id="sideNavRef" class="side-nav-open d-flex flex-column shadow"></div>


    <div id="contentRef" class="content">
        @yield('content')
    </div>



    <script>
        if (!isAuthenticated()) {
            document.querySelector('body').style.display = 'none';
            window.location.href = '/userLogin'
        }

        function removeInfo() {
            removeToken('token')
            removeToken('user')
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

            if (role === 'candidate') {
                document.querySelector('.dashboard-account').textContent = 'Account';
            } else {
                document.querySelector('.dashboard-account').textContent = 'Profile';
            }

            document.getElementById('current_user').textContent = `Welcome! ${firstName} ${lastName}`;
            document.getElementById('role').textContent = role;
        }

        function showLinksBasedOnRole() {
            const user = JSON.parse(getToken('user'))
            const links = getLinks(user.role)

            let linksString = ""
            links.forEach(link => {
                let {
                    url
                } = link
                linksString += `
                <a href="${url}" class="side-bar-item ${url === window.location.pathname ? 'side-bar-item-active' : 'my-1'}">
                    <i class="fas fa-chevron-right"></i>
                    <span class="side-bar-item-caption">${link.name}</span>
                </a>
                `
            })

            document.getElementById('sideNavRef').innerHTML = linksString
        }

        showUserName()
        showLinksBasedOnRole()
    </script>

</body>

</html>
