<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br />
                    <label>6 Digit Code Here</label>
                    <input id="otp" name="otp" placeholder="Code" class="form-control" type="text" />
                    <br />
                    <button onclick="VerifyOtp()" class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function VerifyOtp() {
        const email = sessionStorage.getItem('email');
        const otp = document.getElementById('otp').value;

        if (otp.length !== 6) {
            errorToast("Invalid OTP ");
        } else {
            try {
                showLoader();
                const res = await axios.post('/verify-otp', {
                    email: email,
                    otp: otp
                })
                hideLoader();
                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    sessionStorage.clear();
                    setTimeout(() => {
                        window.location.href = "/resetPassword"
                    }, 2000);
                }

            } catch (error) {
                hideLoader();
                errorToast("Something wrong!");
            }
        }
    }
</script>