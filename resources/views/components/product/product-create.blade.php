<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category *</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="" disabled selected>Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name *</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">Price *</label>
                                <input type="text" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Unit *</label>
                                <input type="text" class="form-control" id="productUnit">

                                <br />
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}" />
                                <br />

                                <label class="form-label">Image *</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">
                                <!-- <input type="file" class="form-control" id="productImg"> -->

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    FillCategoryDropDown();

    async function FillCategoryDropDown() {
        const catList = $('#productCategory');
        const res = await axios.get('/list-category');
        res.data.forEach(item => {
            const option = `
            <option value='${item.id}'>${item.name}</option>
            `;
            catList.append(option);
        });
        // console.log(res);
    }

    async function Save() {

        const categoryId = $('#productCategory').val();
        const productName = $('#productName').val();
        const productPrice = $('#productPrice').val();
        const productUnit = $('#productUnit').val();
        // const productImg = $('#productImg').val();
        const productImg = $('#productImg')[0].files[0];

        if (!categoryId) {
            errorToast("Category is required!");
        } else if (!productName) {
            errorToast("Product name is required!");
        } else if (!productPrice) {
            errorToast("Product price is required!");

        } else if (!productUnit) {
            errorToast("Product unit is required!");

        } else if (!productImg) {
            errorToast("Product img is required!");

        } else {
            // console.log("catID :", categoryId, "name :", productName, "price: ", productPrice, "unit :", productUnit, "img :", productImg);
            $('#modal-close').click();
            const formData = new FormData();
            formData.append('img_url', productImg);
            formData.append('name', productName);
            formData.append('price', productPrice);
            formData.append('unit', productUnit);
            formData.append('category_id', categoryId);


            const config = {
                headers: {

                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            const res = await axios.post('/productCreate', formData, config);
            hideLoader();
            console.log(res);

            if (res.status === 201) {
                successToast("Product Create Successfully");
                $("#save-form")[0].reset();                
                tableData.DataTable().destroy();
                tableList.empty();
                await getList();
            } else {
                errorToast("something went wrong!");
            }
        }
        // console.log("catID :", categoryId, "name :", productName, "price: ", productPrice, "unit :", productUnit, "img :", productImg);



    }
</script>