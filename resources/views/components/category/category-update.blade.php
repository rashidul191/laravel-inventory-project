<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryNameUpdate">
                                <input class="d-none" id="updateID">
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
        const res = await axios.get(`/category-by-id/${id}`);
        hideLoader();
        if (res.status === 200) {
            // console.log(res.data.name);
            $('#categoryNameUpdate').val(res.data.name);
        } else {
            errorToast('something went wrong!');
        }
    }

    async function Update() {

        const updateCat = $('#categoryNameUpdate').val();
        const catId = $('#updateID').val();
        showLoader();
        const res = await axios.post('/update-category', {
            id: catId,
            name: updateCat
        });

        $('#update-modal-close').click();
        hideLoader();
        // console.log(res);
        if (res.status === 200) {
            successToast('Category Updated');
            const tableData = $('#tableData');
            const tableList = $('#tableList');
            tableData.DataTable().destroy();
            tableList.empty();
            await getList();
        } else {
            errorToast('something went wrong!');
        }
    }
</script>