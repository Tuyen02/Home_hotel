<!-- BEGIN: main -->
<div class="table-reponsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th class="text-nowrap">STT</th>
                <th class="text-nowrap">Song name</th>
                <th class="text-nowrap">Path</th>
                <th class="text-nowrap">Singer id</th>
                <th class="text-nowrap">Cat id</th>
                <th class="text-nowrap">Add time</th>
                <th class="text-nowrap">Update time</th>
                <th class="text-nowrap">Active </th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">
                        <select name="weight" class="form-control weight_{ROW.id}" onchange="nv_change_weight({ROW.id})">
                             <!-- BEGIN: weight -->
                            <option value="{J}" {J_SELECT}>{J}</option>
                             <!-- END: weight -->
                        </select>
                    </td>
                    <td>{ROW.song_name}</td>
                    <td>{ROW.path}</td>
                    <td>{ROW.singer}</td>
                    <td>{ROW.cat}</td>
                    <td>{ROW.add_time}</td>
                    <td>{ROW.update_time}</td>
                    <td class="text-center">
                        <input type="checkbox" name="active" {ROW.active} onchange="nv_change_active({ROW.id})">
                    </td>
                    <td class="text-center">
                        <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><<i class="fa fa-trash-o"></i>></i>DELETE</a></td>
                </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    {GENERATE_PAGE}
</div>
<script>

    function nv_change_weight(id){
        var new_weight = $('.weight_'+id).val();
        $.ajax({
            url : script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" 
            + nv_fc_variable + "=main&change_weight=1&id=" + id+'&new_weight='+new_weight,
            success : function(result){
                if(result != 'ERR'){
                    location.reload();
                }
            }
        })
    }

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



