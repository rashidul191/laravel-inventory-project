<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    async function Save() {

        const catName = document.getElementById('categoryName').value;


        console.log(catName);
        if (!catName) {
            errorToast("Category is required!");
        } else {
            // try {
            // showLoad1er();
            const res = await axios.post('/create-category', {
                name: catName
            });
            // hideLoader() ;
            // console.log(res);
            // if (res.status === 200 && res.data.status === 'success') {
            //     setTimeout(() => {
            //         successToast(res.data.message);
            //     }, 1000);
            // } else {
            //     errorToast(res.data.message);
            // }
            // } catch (error) {
            //     hideLoader();
            //     errorToast('Something went wrong!!');
            // }
        }


    }
</script>