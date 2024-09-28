<!-- BEGIN: main -->
    <!-- BEGIN: error -->
    <div class="alert alert-danger">
        {ERROR}
    </div>
    <!-- END: error -->
    <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" class="confirm-reload">
        <input type="hidden" name="id" value="{POST.id}">
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>Song name: </strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.song_name}" name="song_name">
            </div>
        </div>
        <div class="form-group row  ">
            <div class="col-md-4 ">
                <label><strong>Path: </strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.path}" name="path" >
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>Singer: </strong></label>
            </div>
            <div class="col-md-20 form-inline">
                <!-- <input class="form-control" type="text" value="{POST.singer_id}" name="singer_id" >  -->
                <select name="singer_id" class="form-control">
                    <option value="0">Chon ca si</option>
                     <!-- BEGIN: singer -->
                    <option value="{SINGER.key}" {SINGER.selected}>{SINGER.title}</option>
                    <!-- END: singer -->
                </select>
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>Cat id: </strong></label>
            </div>
            <div class="col-md-20 ">
                <!-- BEGIN: cat -->
                <!-- <input class="form-control" type="text" value="{POST.cat_id}" name="cat_id" > -->
                <input class="form-control" type="radio" name="cat_id" value="{CAT.key}" {CAT.checked}/>{CAT.title}
                <!-- END: cat -->
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>Add time: </strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.add_time}" name="add_time" >
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>Update time: </strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.update_time}" name="update_time" >
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-4 ">
                <label><strong>Active: </strong></label>
            </div>
            <div class="col-md-20 ">
                <input class="form-control" type="text" value="{POST.active}" name="active" >
            </div>
        </div>
        <div class="form-group row text-center ">
            <button type="submit" class="btn btn-primary" value="1" name="submit">SAVE</button>
        </div>
    </form>

<!-- END: main -->
