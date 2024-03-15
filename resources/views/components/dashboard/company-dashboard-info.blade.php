<div class="container">
    <button class="btn mt-3 btn btn-outline-primary d-none" id="job-post-btn">Post A Job</button>

    <div class="row" id="dashboard-info">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <h3 class="text-center">JOB SUMMARY</h3>
                            <hr />
                            <div class="col-md-6 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-success py-2 w-50 rounded-3 shadow-xl">
                                    <h5 class="text-center text-white text-uppercase">Pending Jobs</h5>
                                    <p id="pending-jobs" class="text-center text-2xl text-white"></p>
                                </div>
                            </div>
                            <div class="col-md-6 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-info py-2 w-50 rounded-3 shadow-xl">
                                    <h5 class="text-center text-white text-uppercase">Acitve Jobs</h5>
                                    <p id="active-jobs" class="text-center text-2xl text-white"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-none" id="job-post-form">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <div class="w-100 d-flex justify-content-between">
                        <h4>Job Info</h4>
                        <div class="btn btn-outline-primary" id="job-post-form-close">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Title</label>
                                <input id="job_title" placeholder="Job Title" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Company Name</label>
                                <input id="job_company_name" readonly class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Salary</label>
                                <input id="job_salary" placeholder="1000$" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Job Location</label>
                                <input id="job_location" placeholder="Hybrid/Office/Remote" class="form-control"
                                    type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Category</label>
                                <input id="job_category" placeholder="Developer, Designer, Engineer..."
                                    class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Tags</label>
                                <input id="job_tags" placeholder="UI/UX, Node, React..." class="form-control"
                                    type="text" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="postJob()" class="btn mt-3 w-100  bg-gradient-primary">Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const jobPostBtn = document.getElementById('job-post-btn');
    const jobPostForm = document.getElementById('job-post-form');
    const dashboardInfo = document.getElementById('dashboard-info');
    const jobPostFormClose = document.getElementById('job-post-form-close');

    const jobTitle = document.getElementById('job_title')
    const jobCompanyName = document.getElementById('job_company_name')
    const jobSalary = document.getElementById('job_salary')
    const jobLocation = document.getElementById('job_location')
    const jobCategory = document.getElementById('job_category')
    const jobTags = document.getElementById('job_tags')
    const pendingJobs = document.getElementById('pending-jobs');
    const activeJobs = document.getElementById('active-jobs');

    const company = JSON.parse(getToken('user'));

    jobPostBtn.onclick = function() {
        jobPostBtn.classList.remove('btn-outline-primary')
        jobPostBtn.classList.add('bg-gradient-primary')
        dashboardInfo.classList.add('d-none')
        jobPostForm.classList.remove('d-none')
    }

    jobPostFormClose.onclick = function() {
        jobPostBtn.classList.add('btn-outline-primary')
        jobPostBtn.classList.remove('bg-gradient-primary')
        dashboardInfo.classList.remove('d-none')
        jobPostForm.classList.add('d-none')
    }


    function showJobPostBtn(status) {
        if (status === 'active') jobPostBtn.classList.remove('d-none')
    }

    async function postJob() {

        const postBody = {
            'title': jobTitle.value,
            'salary': jobSalary.value,
            'location': jobLocation.value,
            'category': jobCategory.value,
            'tags': jobTags.value,
            'company_id': company.id
        }


        showLoader();

        const res = await axios.post('/company/job', postBody, HeaderToken());

        hideLoader();

        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);
        } else {
            errorToast(res.data['message'])
        }

        jobTitle.value = ''
        jobCategory.value = ''
        jobSalary.value = ''
        jobLocation.value = ''
        jobTags.value = ''


    }

    async function getCompanyData() {

        showLoader();
        const res = await axios.get("/company/" + company.id, HeaderToken())
        const data = res.data['data']

        showJobPostBtn(data['status'])

        hideLoader()

        if (res.status === 200 && res.data['status'] === 'success') {
            const companyInfo = res.data['data']
            jobCompanyName.value = companyInfo.name
        } else {
            errorToast(res.data['message']);
        }
    }

    async function getActiveAndPendingJobs() {
        showLoader();
        const res = await axios.post("/company/job-summary", {
                id: company.id
            },
            HeaderToken())
        hideLoader()
        if (res.status === 200 && res.data['status'] === 'success') {
            const pJobs = res.data['pendings']
            const aJobs = res.data['actives']

            pendingJobs.textContent = pJobs
            activeJobs.textContent = aJobs
        } else {
            errorToast(res.data['message']);
        }
    }

    getCompanyData()
    getActiveAndPendingJobs()
</script>
