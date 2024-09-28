<!-- BEGIN: main -->
<!-- BEGIN: error -->
 <div class="container">
<div class="alert alert-danger">
    {ERROR}
</div>
<!-- END: error -->

<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" class="confirm-reload" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{POST.id}">

    <!-- Hiển thị ảnh hiện tại nếu có -->
    <!-- BEGIN: current_image -->
    <div class="form-group row">
        <div class="col-md-4">
            <label><strong>Current Image:</strong></label>
        </div>
        <div class="col-md-20">
            <img src="{NV_BASE_SITEURL}/uploads/room/images/{POST.image}" alt="Room Image" class="img-thumbnail" style="max-width: 200px;">
        </div>
    </div>
    <!-- END: current_image -->

    <div class="form-group row">
        <div class="col-md-4">
            <label><strong>Image: </strong></label>
        </div>
        <div class="col-md-20">
            <input class="form-control" type="file" accept=".svg,.png,.jpg" name="image">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <label><strong>Active: </strong></label>
        </div>
        <div class="col-md-20">
            <input type="checkbox" name="active" value="1" {POST.active_checked}>
        </div>
    </div>

    <div class="form-group row text-center">
        <button type="submit" class="btn btn-primary" value="1" name="submit" value="{LANG.save}">SAVE</button>
    </div>
</form>
</div>
<!-- END: main -->
