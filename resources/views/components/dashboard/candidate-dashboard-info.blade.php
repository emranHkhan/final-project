<div class="container">
    <button class="btn mt-3 btn btn-outline-primary d-none" id="job-post-btn">Post A Job</button>

    <div class="row" id="dashboard-info">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-6 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-success p-2 w-70 rounded-3 shadow-xl" style="">
                                    <h5 class="text-center text-white text-uppercase">Jobs Applied</h5>
                                    <p id="applied-jobs" class="text-center text-2xl text-white font-weight-bold">
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 p-2 d-flex justify-content-center align-items-center">
                                <div class="bg-info p-2 w-70 rounded-3 shadow-xl" style="">
                                    <h5 class="text-center text-white text-uppercase">Jobs Saved</h5>
                                    <p id="saved-jobs" class="text-center text-2xl text-white font-weight-bold">
                                        0
                                    </p>
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
    async function getAppliedJobs() {
        const currentUser = JSON.parse(getToken('user'))

        showLoader()

        const res = await axios.get('/candidate/jobs/' + currentUser.id, HeaderToken())

        hideLoader()

        document.getElementById('applied-jobs').textContent = res.data['data']

    }

    getAppliedJobs()
</script>
