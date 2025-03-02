<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">
                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>
        </div>
    </div>
</div>


<script>
    async function FillUpUpdateForm(id) {
        $('#updateID').val(id);
        showLoader();
        const res = await axios.get(`/customer-by-id/${id}`);
        hideLoader();
        if (res.status === 200) {
            // console.log(res.data.name);
            $('#customerNameUpdate').val(res.data.name);
            $('#customerEmailUpdate').val(res.data.email);
            $('#customerMobileUpdate').val(res.data.mobile);
        } else {
            errorToast('something went wrong!');
        }

    }


    async function Update() {

        const customerId = $('#updateID').val();
        const customerName = $('#customerNameUpdate').val();
        const customerEmail = $('#customerEmailUpdate').val();
        const customerMobile = $('#customerMobileUpdate').val();
        if (!customerName) {
            errorToast('Customer Name is required!');
        } else if (!customerEmail) {
            errorToast('Customer Email is required!');
        } else if (!customerMobile) {
            errorToast('Customer Mobile is required!');
        } else {

            $('#update-modal-close').click();
            const res = await axios.put(`/customerUpdate/${customerId}`, {
                name: customerName, // New name
                email: customerEmail, // New email
                mobile: customerMobile, // New mobile                
            });

            if (res.status === 200) {
                successToast('Customer Updated Successfully');
                const tableData = $('#tableData');
                const tableList = $('#tableList');
                tableData.DataTable().destroy();
                tableList.empty();
                await getList();

            } else {
                errorToast('something went wrong!');
            }

        }


    }
</script>