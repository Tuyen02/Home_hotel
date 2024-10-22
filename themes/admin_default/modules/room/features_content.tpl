<!-- BEGIN: main -->
<!-- BEGIN: error -->
 <div class="container">
<div class="alert alert-danger">
    {ERROR}
</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" class="confirm-reload">
    <input type="hidden" name="id" value="{POST.id}">
    <div class="form-group row ">
        <div class="col-md-4 ">
            <label><strong>{LANG.fe_name}</strong></label>
        </div>
        <div class="col-md-20 ">
            <input class="form-control" type="text" value="{POST.name}" name="name">
        </div>
    </div>
    <div class="form-group row text-center ">
        <button type="submit" class="btn btn-primary" value="1" name="submit">{LANG.btn_save}</button>
    </div>
</form>
</div>
<!-- END: main -->
