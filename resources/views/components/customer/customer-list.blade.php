<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Customer</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
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
        const res = await axios.get('/customerList');
        hideLoader();
        res.data.data.forEach((item, index) => {
            const row = `
           <tr>
    <td>${index + 1}</td>
    <td>${item?.name}</td>
    <td>${item?.email}</td>
    <td>${item?.mobile}</td>
    <td>
       <button data-id=${item?.id} class="edit_btn btn btn-sm btn-outline-info">Edit</button>
       <button data-id=${item?.id} class="delete_btn btn btn-sm btn-outline-danger">Delete</button>
    </td>    
</tr>
           `;

            tableList.append(row);
        });
        new DataTable(tableData);

        $('.delete_btn').on('click', function() {
            const customerId = $(this).data('id');
            // console.log(customerId);
            $('#delete-modal').modal('show');
            $('#deleteID').val(customerId);
        })

    }
</script>