<!-- BEGIN: main -->
<div class="container">
<div class="table-reponsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr >
                <th class="text-nowrap text-center">{LANG.stt}</th>
                <th class="text-nowrap text-center">{LANG.img}</th>
                <th class="text-nowrap text-center">{LANG.active}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">{ROW.stt}</td>
                    <td class="text-center"><img width="50" src="/uploads/room/images/{ROW.image}" alt=""></td>
                    <td class="text-center"><input type="checkbox" name="active" {ROW.active} onchange="nv_change_active({ROW.id})"></td>
                    <td class="text-center">
                        <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i> DELETE</a>
                    </td>
                </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
</div>
<script>
    $(document).ready(function () {
        $('.delete').click(function () {
            if(confirm("Xóa?")){
                return true;
            }else{
                return false;
            }
          });
      });
    
      function nv_change_active(id){
        $.ajax({
            url : script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" 
            + nv_fc_variable + "=main&change_active=1&id=" + id,success : function(result){
                if(result == 'ERR'){
                    alert("Error!");
                    location.reload();
                }
            }
        })
    }
</script>
<!-- END: main -->



