<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr />
                    <div class="row m-0 p-0">
                        <label class="text-lg text-decoration-underline">Sign up as: </label>
                        <div class="form-check">
                            <div>
                                <input class="form-check-input" type="radio" name="user_type" id="candidate_radio"
                                    value="candidate" checked>
                                <label class="form-check-label" for="candidate">
                                    Candidate
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="user_type" id="company_radio"
                                    value="company">
                                <label class="form-check-label" for="company">
                                    Company
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control"
                                    type="password" />
                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2 d-none" id="company_name_input">
                                    <label>Company Name</label>
                                    <input id="company_name" placeholder="Company Name" class="form-control"
                                        type="text" />
                                </div>
                                <div class="col-md-4 p-2 d-none" id="company_location_input">
                                    <label>Location</label>
                                    <input id="company_location" placeholder="Company Location" class="form-control"
                                        type="text" />
                                </div>
                                <div class="col-md-4 p-2 d-none" id="company_description_input">
                                    <label>Description</label>
                                    <input id="company_description" placeholder="Company Description"
                                        class="form-control" type="text" />
                                </div>
                            </div>
                        </div>


                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()"
                                    class="btn mt-3 w-100 bg-primary text-light">Complete</button>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <p>
                                Already have an account? <a href="{{ route('login') }}"
                                    class="text-center text-decoration-underline h6">Log
                                    In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function onRegistration() {

        let postBody = {
            "firstName": document.getElementById('firstName').value,
            "lastName": document.getElementById('lastName').value,
            "email": document.getElementById('email').value,
            "password": document.getElementById('password').value,
            "mobile": document.getElementById('mobile').value,
            "role": document.querySelector('input[name="user_type"]:checked').value,
            "company_name": document.getElementById('company_name').value,
            "company_location": document.getElementById('company_location').value,
            "company_description": document.getElementById('company_description').value
        }
        showLoader();
        let res = await axios.post("/user-registration", postBody);
        hideLoader()
        if (res.status === 200 && res.data['status'] === 'success') {
            window.location.href = "/userLogin";
        } else {
            errorToast(res.data['message']);
            console.log(res.data['message'])
        }

    }

    const candidateRadio = document.getElementById('candidate_radio')
    const companyRadio = document.getElementById('company_radio')
    const companyNameInput = document.getElementById('company_name_input')
    const companyLocationInput = document.getElementById('company_location_input')
    const companyDescriptionInput = document.getElementById('company_description_input')

    candidateRadio.addEventListener("change", function() {
        if (this.checked) {
            companyNameInput.classList.add('d-none')
            companyDescriptionInput.classList.add('d-none')
            companyLocationInput.classList.add('d-none')
        }
    });

    companyRadio.addEventListener("change", function() {
        if (this.checked) {
            companyNameInput.classList.remove('d-none')
            companyDescriptionInput.classList.remove('d-none')
            companyLocationInput.classList.remove('d-none')
        }
    });
</script>
