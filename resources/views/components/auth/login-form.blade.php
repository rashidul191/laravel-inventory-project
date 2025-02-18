<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br />
                    <input id="email" placeholder="User Email" class="form-control" type="email" />
                    <br />
                    <input id="password" placeholder="User Password" class="form-control" type="password" />
                    <br />
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr />
                    <div class="float-end mt-3">
                        <span>
                            <!-- <a class="text-center ms-3 h6" href="{{url('/userRegistration')}}">Sign Up </a> -->
                            <a class="text-center ms-3 h6" href="{{route('userRegistration.registrationPage')}}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <!-- <a class="text-center ms-3 h6" href="{{url('/sendOtp')}}">Forget Password</a> -->
                            <a class="text-center ms-3 h6" href="{{route('sendOTP.sendOTPPage')}}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function SubmitLogin() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Validate email and password input
        if (email.length === 0) {
            errorToast("Email is required!");
            return; // Return early to prevent further code execution
        } else if (!password) {
            errorToast("Password is required!");
            return; // Return early to prevent further code execution
        }

        try {
            // Show loading spinner
            showLoader();

            // Make the POST request
            const res = await axios.post('/user-login', {
                email: email,
                password: password
            });

            // Hide loading spinner
            hideLoader();

            // Check if the response is successful
            if (res.status === 200 && res.data.status === 'success') {
                successToast(res.data.message); // Show success toast
                window.location.href = "/dashboard"; // Redirect to the dashboard
            } else {
                errorToast(res.data.message); // Show error toast if response is not success
            }
        } catch (error) {
            hideLoader(); // Ensure to hide loader in case of error
            // console.error("Login error:", error); // Log the error for debugging
            errorToast("Unauthorized");
        }
    }
</script>