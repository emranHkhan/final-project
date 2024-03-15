function showLoader() {
    document.getElementById('loader').classList.remove('d-none')
}
function hideLoader() {
    document.getElementById('loader').classList.add('d-none')
}

function successToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "green",
        }
    }).showToast();
}

function errorToast(msg) {
    Toastify({
        gravity: "bottom", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        text: msg,
        className: "mb-5",
        style: {
            background: "red",
        }
    }).showToast();
}

function sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds))
}


function unauthorized(code) {
    if (code === 401) {
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = "/logout"
    }
}

function setToken(name, token, isBearer = false) {
    if (isBearer) localStorage.setItem(`${name}`, `Bearer ${token}`)
    else localStorage.setItem(`${name}`, JSON.stringify(token))
}

function getToken(token) {
    return localStorage.getItem(token)
}

function removeToken(token) {
    localStorage.removeItem(token)
}


function HeaderToken() {
    let token = getToken('token');

    return {
        headers: {
            Authorization: token
        }
    }
}

function getLinks(role) {
    const admin = [
        {
            name: 'Dashboard',
            url: '/admin/dashboard'
        },
        {
            name: 'Companies',
            url: '/admin/companies'
        },
        {
            name: 'Jobs',
            url: '/admin/jobs'
        },
        {
            name: 'Blogs',
            url: '/admin/blogs'
        },
        {
            name: 'Pages',
            url: '/admin/pages'
        },
        // {
        //     name: 'Plugins',
        //     url: '/admin/plugins'
        // },
        // {
        //     name: 'Employees',
        //     url: '/admin/employees'
        // }
    ]

    const company = [
        {
            name: 'Dashboard',
            url: '/company/dashboard'
        },
        {
            name: 'Jobs',
            url: '/company/jobs'
        },
        // {
        //     name: 'Blogs',
        //     url: '/company/blogs'
        // },
        {
            name: 'Plugins',
            url: '/company/plugins'
        }
    ]


    const candidate = [
        {
            name: 'Dashboard',
            url: '/candidate/dashboard'
        },
        {
            name: 'Jobs',
            url: '/candidate/jobs'
        },
        {
            name: 'Profile',
            url: '/candidate/profile'
        }
    ]


    if (role === 'admin') return admin
    if (role === 'candidate') return candidate
    if (role === 'company') return company
}

function isAuthenticated() {
    return getToken('token') !== null
}

function getFormattedDate(dateString) {

    const date = new Date(dateString);

    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const day = date.getUTCDate();
    const monthIndex = date.getUTCMonth();
    const year = date.getUTCFullYear();

    const formattedDate = day + ' ' + months[monthIndex] + ' ' + year;

    return formattedDate;

}
