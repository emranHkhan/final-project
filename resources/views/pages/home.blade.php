@extends('layout.app')

@section('content')
    <section class="">
        <div class="banner">
            <div class="banner-overlay">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Banner Image">
            </div>
            <div class="banner-text">
                <h1>FIND YOUR DREAM JOB</h1>
                <p>Thousands of jobs availabe</p>
            </div>
        </div>

        <div class="card p-4 m-5">
            <h3 class="text-center text-primary">TOP COMPANIES</h3>
            <div class="card-body d-flex mt-2" id="top-companies"></div>
        </div>

        <div class="p-4 m-5">
            <h3 class="text-center text-primary">RECENT JOBS</h3>
            <div class="w-70 card-body mx-auto">
                <div class="w-50 mx-auto mt-2 d-flex gap-2" id="categories"></div>
                <div class="" id="jobs-by-category"></div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            const categories = document.getElementById('categories');
            const jobsByCategory = document.getElementById('jobs-by-category');
            const topMostCompanies = document.getElementById('top-companies');

            function dispalyJobCategories(jobCategories) {
                let html = ''
                jobCategories.forEach((jobCategory, index) => {
                    html +=
                        `
                        <p data-category='${jobCategory.name}' class='job-category text-capitalize border border-2 border-primary rounded px-2 text-primary cursor-pointer ${index === 0 ? 'active' : ''}'>${jobCategory.name} (${jobCategory.jobs_count})</p>
                        `;
                })
                categories.innerHTML = html;
            }

            async function saveJobCandidate(jobId, candidateId) {
                const res = await axios.post('/home/saveJobCandidate', {
                    candidateId,
                    jobId
                })
                if (res.status === 200 && res.data['status'] === 'success') {
                    successToast(res.data['message']);
                } else {
                    errorToast(res.data['message']);
                }
            }

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

            async function getJobsByCategories(category) {
                const res = await axios.post('/home/jobsByCategory', {
                    category
                })
                const jobs = res.data.data;
                let html = ''

                jobs.forEach((job, index) => {
                    html += `
                    <div class="job-info d-flex w-70 my-2 mx-auto justify-content-between border border-2 border-white shadow-sm p-3 rounded bg-body">
                        <div class="w-70">
                            <div class="d-flex gap-2">
                                <p class="text-capitalize bg-primary text-white rounded px-2 py-1">${job.title}</p>
                                <p class="text-capitalize bg-secondary text-white rounded px-2 py-1">${job.location}</p>
                                <p class="text-capitalize bg-info text-white rounded px-2 py-1">${job.company.name}</p>
                            </div>
                            <div class="d-flex gap-2">
                                ${job.tags.split(',').map(tag => `<p class="text-capitalize px-1 bg-success text-white rounded">${tag}</p>`).join('')}
                            </div>
                            <button type="button" class="btn btn-info px-3 py-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                View
                            </button>
                        </div>
                        <div class="w-20 d-flex justify-content-end flex-column">
                            <p class='text-center font-weight-bold border border-2 border-success rounded-3'>$${job.salary}</p>
                            <button data-jobId=${job.id} class="btn apply-btn bg-secondary text-white">Apply</button>
                        </div>
                    </div>
                    `
                })

                html +=
                    `<a href={{ url('/jobs') }} class='all-jobs shadow-sm text-center border border-2 border-primary text-primary w-70 mx-auto py-1 rounded d-block'>All Jobs</a>`

                jobsByCategory.innerHTML = html;

                [...document.querySelectorAll('.apply-btn')].forEach(btn => {
                    btn.addEventListener('click', function() {
                        const currentUser = JSON.parse(getToken('user'));
                        if (!currentUser) {
                            errorToast('Please! login to apply')
                            return
                        }

                        if (currentUser.role !== 'candidate') {
                            errorToast('Only candidate can apply for this job')
                            return
                        }

                        saveJobCandidate(this.getAttribute('data-jobId'), currentUser.id)
                    });
                });

            }

            function selcetCategory() {
                [...document.querySelectorAll('.job-category')].forEach(cat => {
                    cat.addEventListener('click', function(e) {
                        document.querySelectorAll('.job-category').forEach(element => {
                            element.classList.remove('active');
                        });
                        this.classList.add('active');
                        getJobsByCategories(this.getAttribute('data-category'));
                    })
                })
            }

            async function getCategories() {
                showLoader()
                const res = await axios.get('/home/categories')
                dispalyJobCategories(res.data['data']);
                getJobsByCategories(res.data?.data[0]?.name);


                selcetCategory()

                hideLoader()
            }



            getCategories()
            getTopCompanies()
        })
    </script>
@endsection
