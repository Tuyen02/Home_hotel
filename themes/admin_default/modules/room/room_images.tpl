<!-- BEGIN: main -->
<div class="container">
    <h1>Quản lý ảnh cho phòng {ROOM.name}</h1>
    
    <!-- BEGIN: error -->
    <!-- Error block for displaying error messages -->
    {ERROR}
    <!-- END: error -->

    <!-- Form to upload new image -->
    <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=room_images&amp;room_id={ROOM_ID}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="room_id" value="{ROOM_ID}">
        <div class="form-group row">
            <div class="col-md-4">
                <label><strong>Thêm ảnh: </strong></label>
            </div>
            <div class="col-md-8">
                <input class="form-control" type="file" accept=".jpg, .jpeg, .png" name="image">
            </div>
        </div>
        <div class="form-group row text-center">
            <button type="submit" class="btn btn-primary" name="submit" value="Lưu">LƯU</button>
        </div>
    </form>
    <hr class="border border-primary border-3 opacity-75">
    
    <!-- Table to display existing images -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-nowrap text-center">STT</th>
                    <th class="text-nowrap text-center">Ảnh</th>
                    <th class="text-nowrap text-center">Trạng thái</th> -->
                    <th class="text-nowrap text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: image -->
                {IMAGE.loop}
                <tr class="text-nowrap text-center">
                    <td>{IMAGE.stt}</td>
                    <td><img src="{IMAGE.url}" width="100" /></td>
                    <td>
                        <input type="checkbox" {IMAGE.active} onclick="nv_change_active({IMAGE.id})" />
                    </td>
                    <td>
                        <a href="{IMAGE.url_delete}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa ảnh này?');">Xóa</a>
                    </td>
                </tr>
                <!-- END: image -->
            </tbody>
        </table>
    </div>
</div>
<script>
    function nv_change_active(id) {
        var room_id = {ROOM_ID}; // Đảm bảo ROOM_ID được cung cấp đúng
        $.ajax({
            url: 'index.php?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=room_images&change_active=1&id=' + id + '&room_id=' + room_id,
            success: function(result) {
                if (result == 'ERR') {
                    alert("Có lỗi xảy ra!");
                } else {
                    console.log("Status updated successfully.");
                }
            }
        });
    }
    $(document).ready(function () {
        $('.delete').click(function () {
            if(confirm("Xóa?")){
                return true;
            }else{
                return false;
            }
          });
      });
</script>
    
<!-- END: main -->
