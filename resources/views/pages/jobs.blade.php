@extends('layout.app')

@section('content')
    <section>
        <div class="banner">
            <div class="banner-overlay">
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Banner Image">
            </div>
            <div class="banner-text">
                <h1>FIND YOUR DREAM JOB</h1>
                <p>Thousands of jobs availabe</p>
            </div>
        </div>

        <div class="p-4 m-5">
            <h3 class="text-center text-primary">ALL JOBS</h3>
            <div class="w-70 card-body mx-auto">
                <div class="w-50 mx-auto mt-2 d-flex gap-2" id="categories"></div>
                <div class="" id="jobs-by-category"></div>
            </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="tags"></div>
                        <div class="location my-2"></div>
                        <div class="company"></div>
                        <div class="description my-2">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate
                            fuga vero, sapiente ratione obcaecati maiores quod placeat officia dolorum debitis delectus
                            exercitationem nam rem, sunt accusamus tempore recusandae atque perferendis.
                            Magnam nostrum dolorem saepe animi a temporibus nihil molestias? Harum libero commodi accusamus.
                            Praesentium ullam harum pariatur fugit neque odit doloremque dolore, in, consequuntur cum saepe,
                            a doloribus. Illo, nulla.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            const categories = document.getElementById('categories');
            const jobsByCategory = document.getElementById('jobs-by-category');

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
                                <p class="text-capitalize bg-primary text-white rounded px-2 py-1" id="job-title-${job.id}">${job.title}</p>
                                <p class="text-capitalize bg-secondary text-white rounded px-2 py-1" id="job-location-${job.id}">${job.location}</p>
                                <p class="text-capitalize bg-info text-white rounded px-2 py-1" id="job-company-${job.id}">${job.company.name}</p>
                            </div>
                            <div class="d-flex gap-2" id="job-tag-${job.id}">
                                ${job.tags.split(',').map(tag => `<p class="text-capitalize px-1 bg-success text-white rounded">${tag}</p>`).join('')}
                            </div>
                            <button data-btn=${job.id} type="button" class="view-job-details btn btn-info px-3 py-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                View
                            </button>
                        </div>
                        <div class="w-20 d-flex justify-content-end flex-column">
                            <p class='text-center font-weight-bold border border-2 border-success rounded-3' id="job-salary-${job.id}">$${job.salary}</p>
                            <button data-jobId=${job.id} class="btn apply-btn bg-secondary text-white">Apply</button>
                        </div>
                    </div>
                    `


                })

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

                [...document.querySelectorAll('.view-job-details')].forEach(btn => {
                    btn.addEventListener('click', function() {
                        const btnId = btn.getAttribute('data-btn');

                        const jobTitle = document.getElementById(`job-title-${btnId}`)
                            .textContent;
                        const jobLocation = document.getElementById(`job-location-${btnId}`)
                            .textContent;
                        const jobCompany = document.getElementById(`job-company-${btnId}`)
                            .textContent;
                        const jobTag = document.getElementById(`job-tag-${btnId}`).innerText
                            .replace(/\b\n+\b/g, ' ');
                        const jobSalary = document.getElementById(`job-salary-${btnId}`)
                            .textContent;


                        document.querySelector('.modal-title').textContent = jobTitle;

                        let html = '<span>Tags: </span>';
                        html += jobTag.split(' ').map(tag =>
                            `<div class="text-capitalize px-1 d-inline-block bg-success text-white rounded" style="margin-right: 5px">${tag}</div>`
                        ).join('')

                        document.querySelector('.tags').innerHTML = html

                        document.querySelector('.location').textContent = 'Location: ' +
                            jobLocation
                        document.querySelector('.company').textContent = 'Compnay: ' +
                            jobCompany

                    })
                })
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
                getJobsByCategories(res.data.data[0].name);


                selcetCategory()

                hideLoader()
            }



            getCategories()
        })
    </script>
@endsection
