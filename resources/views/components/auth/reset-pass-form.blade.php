<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br />
                    <label>New Password</label>
                    <input id="password" name="password" placeholder="New Password" class="form-control" type="password" />
                    <br />
                    <label>Confirm Password</label>
                    <input id="cpassword" name="cpassword" placeholder="Confirm Password" class="form-control" type="password" />
                    <br />
                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function ResetPass() {
        const password = document.getElementById('password').value;
        const cpassword = document.getElementById('cpassword').value;

        if (!password) {
            errorToast("Password is required!");
        } else if (!cpassword) {
            errorToast("Confirm Password is required!");
        } else if (password !== cpassword) {
            errorToast("New Password and Confirm Password Not Match!");
        } else {

            try {
                showLoader();
                const res = await axios.post('/reset-password', {
                    password: password
                })
                hideLoader();
                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = "/userLogin";
                    }, 2000);
                } else {
                    errorToast(res.data.message);
                }
            } catch (error) {
                hideLoader();
                errorToast('something wrong!');
            }
        }
    }
</script>