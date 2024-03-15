@extends('layout.app')

@section('content')
    <section>
        <div class="banner">
            <div class="banner-overlay">
                <img src="https://images.unsplash.com/photo-1531545514256-b1400bc00f31?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Banner Image">
            </div>
            <div class="banner-text">
                <h1 class="about-page-title text-uppercase"></h1>
            </div>
        </div>

        <div class="m-5 row px-5">
            <h3>Company History</h3>
            <p class="company-history"></p>
        </div>

        <div class="m-5 row px-5">
            <h3>Our Vision</h3>
            <p class="company-vision"></p>
        </div>

        <div class="card p-4 m-5">
            <h3 class="text-center text-primary">COMPANIES BELIEVED IN US</h3>
            <div class="card-body d-flex mt-2" id="top-most-companies-2"></div>
        </div>
    </section>

    <script>
        const topMostCompanies = document.getElementById('top-most-companies-2');
        const aboutPageTitle = document.querySelector('.about-page-title');
        const companyHistory = document.querySelector('.company-history');
        const companyVision = document.querySelector('.company-vision');

        async function getTopCompanies() {
            const res = await axios.get('/home/getTopCompanies');
            const topCompanies = res.data['data']


            let html = ''


            topCompanies.forEach(company => {
                html +=
                    `<div class="border-2 w-20 text-center text-5xl font-italic font-weight-bold text-capitalize">${company.name}</div>`
            })
            topMostCompanies.innerHTML = html;
        }

        async function getAboutPageInfo() {
            const res = await axios.get('/about/getAboutPageInfo')

            aboutPageTitle.textContent = res.data['data'][0].about_page_title
            companyHistory.textContent = res.data['data'][0].about_company_history
            companyVision.textContent = res.data['data'][0].about_company_vision
        }

        getAboutPageInfo()
        getTopCompanies()
    </script>
@endsection
