<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>APPLIED JOBS</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center">No</th>
                                <th class="text-center">Job Title</th>
                                <th class="text-center">Applied Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getJobs();


    async function getJobs() {
        const currentUser = JSON.parse(getToken('user'))

        showLoader();

        const res = await axios.get("/candidate/appliedJobs/" + currentUser.id, HeaderToken());
        const jobs = res.data['data']

        console.log(jobs);

        hideLoader();

        const tableList = $("#tableList");
        const tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        jobs.forEach(function(job, index) {
            const row = `<tr data-id="${job['id']}">
                    <td class='text-center'>${index+1}</td>
                    <td class='text-center'>${job.title}</td>
                    <td class='text-center'>${getFormattedDate(job.created_at)}</td>
                    <td class='text-center'>
                        <button class="btn viewBtn btn-sm btn-outline-success">View</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })


        const table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20, 30]
        });

    }
</script>
