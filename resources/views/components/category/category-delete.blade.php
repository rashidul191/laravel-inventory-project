<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID" />
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete() {

        const catId = document.getElementById('deleteID').value;
        document.getElementById('delete-modal-close').click();

        showLoader();
        const res = await axios.post("/delete-category", {
            id: catId
        });
        hideLoader();

        if (res.data === 1) {
            successToast('Category Deleted');
            const tableData = $('#tableData');
            const tableList = $('#tableList');
            tableData.DataTable().destroy();
            tableList.empty();
            await getList();
        } else {
            errorToast('Failed!!');
        }

    }
</script>