<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="w-100 d-flex justify-content-between">
                        <h4>ALL JOBS</h4>
                        <div class="btn btn-outline-primary d-none" id="job-desc-close">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center">No</th>
                                <th class="text-center">Job Title</th>
                                <th class="text-center">Published Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList"></tbody>
                    </table>

                </div>
                <div class="job-description d-none">
                    <p class="text-2xl font-weight-bold">Applied: <span class="candidate-count"></span></p>
                    <p>Title: <span class="job-title"></span></p>
                    <p>Location: <span class="job-location"></span></p>
                    <p>Salary: <span class="job-salary"></span></p>
                    <hr>
                    <div class="table-responsive2">
                        <table class="table" id="tableData2">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Candidate Name</th>
                                    <th class="text-center">Applied Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList2">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    getJobs();


    async function getJobs() {

        showLoader();

        const res = await axios.get("/company/allJobs", HeaderToken());
        const jobs = res.data['data']


        hideLoader();

        const tableList = $("#tableList");
        const tableList2 = $("#tableList2");
        const tableData = $("#tableData");
        const tableData2 = $("#tableData2");

        tableData.DataTable().destroy();
        tableData2.DataTable().destroy();
        tableList.empty();
        tableList2.empty();

        jobs.forEach(function(job, index) {
            const row = `<tr data-id="${job['id']}">
                    <td class='text-center'>${index+1}</td>
                    <td class='text-center'>${job.title}</td>
                    <td class='text-center'>${getFormattedDate(job.created_at)}</td>
                    <td class='text-center'>
                        <button class="btn view-btn btn-sm btn-outline-success">View</button>
                        <button class="btn delete-btn btn-sm btn-outline-danger">Delete</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })


        $('.view-btn').on('click', async function() {
            const row = $(this).closest('tr');
            const selectedJobId = row.data('id');

            const editBtn = row.find('.edit-btn').addClass('d-none');
            const saveBtn = row.find('.saveBtn').removeClass('d-none');

            $('#job-desc-close').removeClass('d-none');
            $('.table-responsive').addClass('d-none');
            $('.job-description').removeClass('d-none');

            const res1 = await axios.get('/admin/getCandidateCount/' + selectedJobId, HeaderToken())
            const res2 = await axios.get('/admin/getJob/' + selectedJobId, HeaderToken())
            const res3 = await axios.get('/admin/getCandidateForJob/' + selectedJobId, HeaderToken())

            const candidates = res3.data['data']

            candidates.forEach(function(candidate, index) {
                const row = `<tr data-id="${candidate.id}">
                    <td class='text-center'>${index+1}</td>
                    <td class='text-center'>${candidate.candidate_info.fullName}</td>
                    <td class='text-center'>${getFormattedDate(candidate.created_at)}</td>
                    <td class='text-center'>
                        <button class="btn view-btn btn-sm btn-outline-success">View</button>
                        <button class="btn reject-btn btn-sm btn-outline-danger">Reject</button>
                    </td>
                 </tr>`
                tableList2.append(row)
            })

            $('.candidate-count').text(res1.data['data'])

            $('.job-title').text(res2.data['data'].title)
            $('.job-location').text(res2.data['data'].location)
            $('.job-salary').text(res2.data['data'].salary)

        })

        $('#job-desc-close').on('click', function() {
            $(this).addClass('d-none');
            $('.job-description').addClass('d-none');
            $('.table-responsive').removeClass('d-none');
            tableList2.empty();
        })


        const table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20, 30]
        });

    }
</script>
