<!-- BEGIN: main -->
<div class="table-reponsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr >
                <th class="text-nowrap text-center">STT</th>
                <th class="text-nowrap text-center">Name</th>
                <th class="text-nowrap text-center">Area</th>
                <th class="text-nowrap text-center">Guest</th>
                <th class="text-nowrap text-center">Price</th>
                <th class="text-nowrap text-center">Quantity</th>
                <th class="text-nowrap text-center">Status</th>
                <th class="text-nowrap text-center">Func</th>
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
                    <td class="text-center">{ROW.name}</td>
                    <td class="text-center">{ROW.area}m<sup>2</sup></td>
                    <td class="text-center">
                        <span class="badge rounded-pill bg-light text-dark">Adult: {ROW.adult}</span>
                        </br>
                        <span class="badge rounded-pill bg-light text-dark">Children: {ROW.children}</span>
                    </td>
                    <td class="text-center text-danger">{ROW.price} đ</td>
                    <td class="text-center">{ROW.quantity}</td>
                    <td class="text-center"><input type="checkbox" name="active" {ROW.active} onchange="nv_change_active({ROW.id})"></td>
                    <td class="text-center w-50">
                        <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> EDIT</a>
                        <a href="{ROW.url_image}" class="btn btn-primary btn-sm"><i class="fa fa-picture-o"></i></i> IMAGE</a>
                        <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></i> DELETE</a>
                    </td>
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
</script>

<!-- END: main -->



