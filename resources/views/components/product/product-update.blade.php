<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">
                                <br />
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}" />
                                <br />
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>

        </div>
    </div>
</div>


<script>
    UpdateFillCategoryDropDown()
    async function UpdateFillCategoryDropDown() {
        const catList = $('#productCategoryUpdate');
        const res = await axios.get('/list-category');
        res.data.forEach(item => {
            const option = `
            <option value='${item.id}'>${item.name}</option>
            `;
            catList.append(option);
        });
        // console.log(res);
    }


    async function FillUpUpdateForm(id, filePath) {
        $('#updateID').val(id);
        $('#filePath').val(filePath);
        showLoader();
        const res = await axios.get(`/productGetById/${id}`);
        hideLoader();
        if (res.status === 200) {
            // console.log(res.data);

            $('#productCategoryUpdate').val(res.data.category_id);
            $('#productNameUpdate').val(res.data.name);
            $('#productPriceUpdate').val(res.data.price);
            $('#productUnitUpdate').val(res.data.unit);
            $('#oldImg').attr('src', res.data.img_url);

        } else {
            errorToast('something went wrong!');
        }
    }

    async function update() {
        const id = $('#updateID').val();
        const oldImgUrl = $('#filePath').val();
        const newImgUrl = $('#productImgUpdate')[0].files[0];
        const name = $('#productNameUpdate').val();
        const price = $('#productPriceUpdate').val();
        const unit = $('#productUnitUpdate').val();
        const category_id = $('#productCategoryUpdate').val();
        if (!category_id) {
            errorToast('Category is required!');
        } else if (!name) {
            errorToast("Product name is required!");
        } else if (!price) {
            errorToast("Product price is required!");
        } else if (!unit) {
            errorToast("Product unit is required!");
        } else {
            $("#update-modal-close").click();
            // if (newImgUrl) {
            // console.log("id :", id, "oldImgUrl :", oldImgUrl, "newImgUrl :", newImgUrl, "name :", name, "price :", price, "unit :", unit, "catId :", category_id);


            const formData = new FormData();
            formData.append('img_url', newImgUrl);
            formData.append('old_img_url', oldImgUrl);
            formData.append('name', name);
            formData.append('price', price);
            formData.append('unit', unit);
            formData.append('category_id', category_id);


            const config = {
                headers: {

                    'content-type': 'multipart/form-data'
                }
            }
            showLoader();
            const res = await axios.post(`/productUpdate/${id}`, formData, config);
            hideLoader();
            // console.log(res);
            if (res.status === 200) {
                successToast("Product Update Successfully");
                $("#update-form")[0].reset();
                tableData.DataTable().destroy();
                tableList.empty();
                await getList();
            } else {
                errorToast("Something went wrong!");
            }

            // } else {
            // console.log("id :", id, "oldImgUrl :", oldImgUrl, "name :", name, "price :", price, "unit :", unit, "catId :", category_id);
            // showLoader();
            // const res = await axios.post(`/productUpdate/${id}`, {
            //     'name': name,
            //     'price': price,
            //     'unit': unit,
            //     'category_id': category_id,
            // });
            // hideLoader();
            // console.log(res);
            // if (res.status === 200) {
            //     successToast("Product Update Successfully");
            //     $("#update-form")[0].reset();
            //     tableData.DataTable().destroy();
            //     tableList.empty();
            //     await getList();
            // } else {
            //     errorToast("Something went wrong!");
            // }
        }
        // }

    }
</script>