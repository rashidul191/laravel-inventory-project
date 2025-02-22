<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control" type="email" />
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
                                <input id="password" placeholder="User Password" class="form-control" type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();
    async function getProfile() {

        try {
            showLoader();
            const res = await axios.get('/user-profile');
            hideLoader();
            if (res.status === 200 && res.data.status === 'success') {
                const userData = res.data.data;
                document.getElementById('email').value = userData.email;
                document.getElementById('firstName').value = userData.firstName;
                document.getElementById('lastName').value = userData.lastName;
                document.getElementById('mobile').value = userData.mobile;
                document.getElementById('password').value = userData.password;
            } else {
                errorToast(res.data.message);
            }

        } catch (error) {
            hideLoader();
            errorToast("something went wrong !!");
        }
    }


    async function onUpdate() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const mobile = document.getElementById('mobile').value;
        const password = document.getElementById('password').value;

        if (!firstName) {
            errorToast('First Name is required');
        } else if (!lastName) {
            errorToast('Last Name is required');
        } else if (!mobile) {
            errorToast('Mobile is required');

        } else if (!password) {
            errorToast('Password is required');
        } else {

            try {
                showLoader();
                const res = await axios.post('/update-profile', {
                    firstName: firstName,
                    lastName: lastName,
                    mobile: mobile,
                    password: password
                });
                hideLoader();
                if (res.status === 200 && res.data.status === 'success') {
                    setTimeout(function() {
                        successToast(res.data.message)
                    }, 1000);
                    await getProfile();
                } else {
                    errorToast(res.data.message)
                }
            } catch (error) {
                hideLoader();
                errorToast('something went wrong!!');
            }
        }
    }
</script>