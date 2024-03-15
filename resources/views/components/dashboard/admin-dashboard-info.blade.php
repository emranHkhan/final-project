<div class="container">
    <div class="row" id="dashboard-info">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-warning p-2 w-70 rounded-3 shadow-xl" style="">
                                    <h5 class="text-center text-white text-uppercase">Active Companies</h5>
                                    <p id="active-companies" class="text-center text-2xl text-white font-weight-bold">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-success p-2 w-70 rounded-3 shadow-xl" style="">
                                    <h5 class="text-center text-white text-uppercase">Pending Companies</h5>
                                    <p id="pending-companies" class="text-center text-2xl text-white font-weight-bold">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-info p-2 w-70 rounded-3 shadow-xl" style="">
                                    <h5 class="text-center text-white text-uppercase">Job Posted</h5>
                                    <p id="posted-jobs" class="text-center text-2xl text-white font-weight-bold"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function fetchData() {
        const activeCompanies = document.getElementById('active-companies');
        const pendingCompanies = document.getElementById('pending-companies');
        const postedJobs = document.getElementById('posted-jobs');

        showLoader();
        const res = await axios.get('/admin/jobAndCompanyData', HeaderToken());
        hideLoader();

        pendingCompanies.textContent = res.data['data'][0]
        activeCompanies.textContent = res.data['data'][1]
        postedJobs.textContent = res.data['data'][2]
    }

    fetchData();
</script>
