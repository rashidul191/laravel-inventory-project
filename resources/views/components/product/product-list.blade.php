<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Product</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0  bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>SN</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    getList();
    const tableData = $('#tableData');
    const tableList = $('#tableList');

    tableData.DataTable().destroy();
    tableList.empty();
    async function getList() {
        showLoader();
        const res = await axios.get('/productList');
        hideLoader();
        res?.data?.forEach((item, index) => {
            // console.log(item);

            const row = `
            <tr>     
            <td>${index+1}</td>      
            <td><img src="${item.img_url}" alt="product image" /></td>
            <td>${item.name}</td>
            <td>TK ${item.price}</td>
            <td>${item.unit}</td>   
            <td>
            <button data-id="${item.id}" class="btn btn-outline btn-outline-info edit-btn">Edit</button>
            <button data-id="${item.id}" class="btn btn-outline btn-outline-danger delete-btn">Delete</button>
            </td>         
            </tr>
            `;
            tableList.append(row);

        });

        $('.delete-btn').on('click', function() {
            const productId = $(this).data('id');
            $('#delete-modal').modal('show');
            $('#deleteID').val(productId);
        })


        new DataTable(tableData);
    }
</script>