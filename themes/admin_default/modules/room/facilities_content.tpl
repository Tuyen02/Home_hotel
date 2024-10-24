<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="container">
    <div class="alert alert-danger">
        {ERROR}
    </div>
    <!-- END: error -->
    <form
        action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}"
        method="post" class="confirm-reload" enctype=“multipart/form-data”>
        <input type="hidden" name="id" value="{POST.id}">
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>{LANG.fac_name}</strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.name}" name="name">
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>{LANG.icon} </strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="file" accept=".svg" name="icon">
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>{LANG.description}</strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.description}" name="description">
            </div>
        </div>
        <div class="form-group row text-center ">
            <button type="submit" class="btn btn-primary" value="1" name="submit" value="{LANG.save}">{LANG.btn_save}</button>
        </div>
</div>
</form>
<!-- END: main -->