<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" name="email" placeholder="User Email" class="form-control" type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" name="firstName" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" name="lastName" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" name="mobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" name="password" placeholder="User Password" class="form-control" type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-100  bg-gradient-primary">Complete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function onRegistration() {

        const email = document.getElementById('email').value;
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const mobile = document.getElementById('mobile').value;
        const password = document.getElementById('password').value;
        if (!email) {
            errorToast("Email is required!");
        } else if (!firstName) {
            errorToast("First Name is required!");
        } else if (!lastName) {
            errorToast("Last Name is required!");
        } else if (!mobile) {
            errorToast("Mobile is required!");
        } else if (!password) {
            errorToast("Password is required!");
        } else {
            try {
                showLoader();
                const res = await axios.post('/user-registration', {
                    email: email,
                    firstName: firstName,
                    lastName: lastName,
                    mobile: mobile,
                    password: password
                })
                hideLoader();
                if (res.status === 200 && res.data.status === "success") {
                    successToast(res.data.message);
                    window.location.href = "/userLogin";
                } else {
                    errorToast(res.data.message);
                }

            } catch (error) {
                hideLoader();
                errorToast("Something is wrong !!!");
            }
        }

    }
</script>