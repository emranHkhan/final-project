<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div id="nav-buttons">
                    <button class="btn btn-outline-primary admin-about active">About</button>
                    <button class="btn btn-outline-primary admin-contact mx-2">Contact</button>
                    <button class="btn btn-outline-primary admin-blogs">Blogs</button>
                </div>

                <div class="info admin-about-page-info w-50">
                    <div>
                        <label>About Page Title</label>
                        <input id="about_page_title" placeholder="" class="form-control" type="text" />
                        <br />
                        <label>Company History</label>
                        <textarea id="about_company_history" placeholder="" class="form-control" type="text"></textarea>
                        <br />
                        <label>Company Vision</label>
                        <textarea id="about_company_vision" placeholder="" class="form-control" type="text"></textarea>
                        <br />
                        <div class="d-none">
                            <img id="about_page_banner" src="" alt="">
                        </div>
                        <br />
                        <div class="">
                            <label>About Page Banner Image</label>
                            <button class="btn btn-outline-success">Upload</button>
                        </div>
                        <br />
                        <button class="btn w-25 bg-gradient-primary" onclick="saveAboutPageInfo()">Save</button>
                    </div>
                </div>
                <div class="info admin-contact-page-info d-none w-25">
                    <div>
                        <label>Email</label>
                        <input id="jobpulse_email" placeholder="" class="form-control" type="email" />
                        <br />
                        <label>Company Address</label>
                        <input id="jobpulse_address" placeholder="" class="form-control" type="text" />
                        <br />
                        <label>Company Mobile No.</label>
                        <input id="jobpulse_mobile" placeholder="" class="form-control" type="mobile" />
                        <br />
                        <button class="btn bg-gradient-primary" onclick="saveContactPageInfo()">Save</button>
                    </div>
                </div>
                <div class="info admin-blogs-page-info d-none w-50">
                    <div>
                        <label>Blog Page Title</label>
                        <input id="blog_page_title" placeholder="" class="form-control" type="text" />
                        <br />
                        <div class="d-none">
                            <img id="blog_page_banner" src="" alt="">
                        </div>
                        <br />
                        <div class="">
                            <label>Blog Banner Image</label>
                            <button class="btn btn-outline-success">Upload</button>
                        </div>
                        <br />
                        <button class="btn w-25 bg-gradient-primary" onclick="saveBlogsPageInfo()">Save</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const buttons = document.querySelectorAll("#nav-buttons button");
    const infoDivs = document.querySelectorAll(".info");

    buttons.forEach(button => {
        button.addEventListener("click", function() {
            buttons.forEach(btn => btn.classList.remove("active"));
            infoDivs.forEach(div => div.classList.add("d-none"));

            this.classList.add("active");

            const index = Array.from(buttons).indexOf(this);

            infoDivs[index].classList.remove("d-none");
        });
    });

    async function saveAboutPageInfo() {
        const payload = {
            about: {
                about_page_title: document.getElementById("about_page_title").value,
                // about_page_banner: document.getElementById("about_page_banner").src,
                about_company_history: document.getElementById("about_company_history").value,
                about_company_vision: document.getElementById("about_company_vision").value
            }
        }

        console.log(payload);

        const res = await axios.post('/admin/savePageData', JSON.stringify(payload), HeaderToken());

        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);
        } else {
            errorToast(res.data['message']);
        }
    }

    async function saveContactPageInfo() {
        const payload = {
            contact: {
                contact_page_email: document.getElementById("jobpulse_email").value,
                contact_page_address: document.getElementById("jobpulse_address").value,
                contact_page_mobile: document.getElementById("jobpulse_mobile").value
            }
        }

        const res = await axios.post('/admin/savePageData', JSON.stringify(payload), HeaderToken());

        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);
        } else {
            errorToast(res.data['message']);
        }

    }

    async function saveBlogsPageInfo() {
        const payload = {
            blog: {
                blogs_page_title: document.getElementById("blog_page_title").value,
                // blogs_page_banner: document.getElementById("blog_page_banner").src,
            }
        }

        const res = await axios.post('/admin/savePageData', JSON.stringify(payload), HeaderToken());

        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);
        } else {
            errorToast(res.data['message']);
        }

    }
</script>
