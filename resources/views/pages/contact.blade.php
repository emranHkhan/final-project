@extends('layout.app')

@section('content')
    <section>
        <div class="banner">
            <div class="banner-overlay">
                <img src="https://images.unsplash.com/photo-1534536281715-e28d76689b4d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Banner Image">
            </div>
        </div>

        <div class="m-5 row px-5">
            <div class="col-md-6 px-5">
                <h3>Contact Us</h3>
                <hr>
                <p><span class="font-weight-bold">Address: </span><span class="contact-page-address"></span></p>
                <p><span class="font-weight-bold">Phone: </span><span class="contact-page-mobile"></span></p>
                <p><span class="font-weight-bold">Email: </span><span class="contact-page-email"></span></p>
            </div>
            <div class="col-md-6 px-5">
                <h3>Get In Touch</h3>
                <hr>
                <form action="">
                    <input id="text" placeholder="Your Name" class="form-control" type="text" />
                    <br />
                    <input id="email" placeholder="Your Email" class="form-control" type="email" />
                    <br />
                    <input id="subject" placeholder="Subject" class="form-control" type="text" />
                    <br />
                    <input id="mobile" placeholder="Your Mobile No." class="form-control" type="mobile" />
                    <br />
                    <textarea id="query" placeholder="Your Query" class="form-control" type="text" rows="5"></textarea>
                    <br />
                    <button class="btn w-100 bg-gradient-primary">Submit</button>
                </form>
            </div>
        </div>

        <div class="card p-4 m-5">
            <h3 class="text-center text-primary">COMPANIES BELIEVED IN US</h3>
            <div class="card-body d-flex mt-2" id="top-most-companies"></div>
        </div>
    </section>


    <script>
        const topMostCompanies = document.getElementById('top-most-companies');
        const contactPageAddress = document.querySelector('.contact-page-address');
        const contactPageMobile = document.querySelector('.contact-page-mobile');
        const contactPageEmail = document.querySelector('.contact-page-email');

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

        async function getContactPageInfo() {
            const res = await axios.get('/contact/getContactPageInfo');

            contactPageAddress.textContent = res.data['data'][0].contact_page_address
            contactPageMobile.textContent = res.data['data'][0].contact_page_mobile
            contactPageEmail.textContent = res.data['data'][0].contact_page_email
        }

        getContactPageInfo()

        getTopCompanies()
    </script>
@endsection
