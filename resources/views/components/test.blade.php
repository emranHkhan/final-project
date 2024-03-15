<section class="">
    <div class="banner">
        <div class="banner-overlay">
            <img src="https://images.unsplash.com/photo-1653669487003-7d89b2020f3c?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Banner Image">
        </div>
        <div class="banner-text">
            <h1>FIND YOUR DREAM JOB</h1>
            <p>Thousands of jobs availabe</p>
        </div>
    </div>



    <div class="card p-4 m-5">
        <h5 class="text-center text-primary">TOP COMPANIES</h5>
        <div class="card-body d-flex mt-2">
            <div class="border-2 w-20 text-center">COMPANY A</div>
            <div class="border-2 w-20 text-center">COMPANY A</div>
            <div class="border-2 w-20 text-center">COMPANY A</div>
            <div class="border-2 w-20 text-center">COMPANY A</div>
            <div class="border-2 w-20 text-center">COMPANY A</div>
        </div>
    </div>


</section>
<script>
    (async function() {
        showLoader();
        try {
            const response = await axios.get('/');
            console.log(response.data['data']);
        } catch (error) {
            console.error(error);
        } finally {
            hideLoader();
        }
    })();
</script>
