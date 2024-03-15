<div class="container-fluid dashboard-companies-info">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>COMPANIES</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center">No</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Status</th>
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
    getCompanies();

    async function getCompanies() {


        showLoader();
        const res = await axios.get("/admin/getCompanies", HeaderToken());
        const companies = res.data.data;
        hideLoader();

        const tableList = $("#tableList");
        const tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        companies.forEach(function(company, index) {
            const row = `<tr data-id="${company['id']}">
                    <td class='text-center'>${index+1}</td>
                    <td class='text-center'>${company['name']}</td>
                    <td class='text-center'>${company['status']}</td>
                    <td class='text-center'>
                        <button class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button class="btn d-none saveBtn btn-sm btn-outline-success">Save</button>
                        <button class="btn deleteBtn btn-sm btn-outline-danger">delete</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.editBtn').on('click', function() {
            const row = $(this).closest('tr');
            const thirdTd = row.find('td:eq(2)');
            const currentStatus = thirdTd.text();

            const editBtn = row.find('.editBtn').addClass('d-none');
            const saveBtn = row.find('.saveBtn').removeClass('d-none');

            thirdTd.html(`<input class='admin-company-status' value='${currentStatus}' type='text' />`);



        })

        $('.saveBtn').on('click', async function() {
            const row = $(this).closest('tr');
            const editBtn = row.find('.editBtn').removeClass('d-none');
            const saveBtn = row.find('.saveBtn').addClass('d-none');
            const thirdTd = row.find('td:eq(2)');
            const companyStatus = row.find('input').val();
            const selectedCompanyId = row.data('id');


            const res = await axios.post('/admin/update-company-status', {
                companyId: selectedCompanyId,
                companyStatus
            }, HeaderToken())

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
            } else {
                errorToast(res.data['message']);
            }

            getCompanies();

        })

        $('.deleteBtn').on('click', async function() {
            const row = $(this).closest('tr');
            const selectedCompanyId = row.data('id');

            const res = await axios.post('/admin/delete-job', {
                companyId: selectedCompanyId
            }, HeaderToken());


            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
            } else {
                errorToast(res.data['message']);
            }

            getCompanies();

        })

        const table = new DataTable('#tableData', {
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20, 30]
        });

    }
</script>
