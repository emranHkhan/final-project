<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div>
                        <h4>JOB</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center">No</th>
                                <th class="text-center">Job Title</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Published Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getJobs();

    async function getJobs() {
        showLoader();
        const res = await axios.get("/admin/getJobs", HeaderToken());
        const jobs = res.data.data;
        hideLoader();

        const tableList = $("#tableList");
        const tableList2 = $("#tableList2");
        const tableData = $("#tableData");
        const tableData2 = $("#tableData2");

        tableData.DataTable().destroy();
        tableList.empty();

        jobs.forEach(function(job, index) {
            const row = `<tr data-id="${job['id']}">
                    <td class='text-center'>${index+1}</td>
                    <td class='text-center'>${job.title}</td>
                    <td class='text-center'>${job.status}</td>
                    <td class='text-center'>${getFormattedDate(job.created_at)}</td>
                    <td class='text-center'>
                        <button class="btn edit-btn btn-sm btn-outline-success">Edit</button>
                        <button class="btn d-none saveBtn btn-sm btn-outline-success">Save</button>
                        <button class="btn delete-btn btn-sm btn-outline-danger">delete</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.edit-btn').on('click', function() {
            const row = $(this).closest('tr');
            const thirdTd = row.find('td:eq(2)');
            const currentStatus = thirdTd.text();

            const editBtn = row.find('.edit-btn').addClass('d-none');
            const saveBtn = row.find('.saveBtn').removeClass('d-none');

            thirdTd.html(`<input value='${currentStatus}' type='text' />`);

        })

        $('.saveBtn').on('click', async function() {
            const row = $(this).closest('tr');
            const editBtn = row.find('.edit-btn').removeClass('d-none');
            const saveBtn = row.find('.saveBtn').addClass('d-none');
            const thirdTd = row.find('td:eq(2)');
            const jobStatus = row.find('input').val();
            const selectedJobId = row.data('id');


            const res = await axios.post('/admin/update-job-status', {
                jobId: selectedJobId,
                jobStatus
            }, HeaderToken())

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
            } else {
                errorToast(res.data['message']);
            }

            getJobs();

        })

        $('.delete-btn').on('click', async function() {
            const row = $(this).closest('tr');
            const selectedJobId = row.data('id');

            const res = await axios.post('/admin/delete-job', {
                jobId: selectedJobId
            }, HeaderToken());


            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
            } else {
                errorToast(res.data['message']);
            }

            getJobs();

        })

        const table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20, 30]
        });

    }
</script>
