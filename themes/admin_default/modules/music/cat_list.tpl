<!-- BEGIN: main -->

<div class="table-reponsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr >
                <th class="text-nowrap text-center">STT</th>
                <th class="text-nowrap text-center">Cat name</th>
                <th class="text-nowrap text-center">Add time</th>
                <th class="text-nowrap text-center">Update time</th>
                <th class="text-nowrap text-center">Function</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">{ROW.stt}</td>
                    <td>{ROW.cat_name}</td>
                    <td>{ROW.add_time}</td>
                    <td>{ROW.update_time}</td>
                    <td class="text-center">
                        <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>EDIT</a>
                        <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><<i class="fa fa-trash-o"></i>></i>DELETE</a></td>
                </tr>
            <!-- END: loop -->
        </tbody>
    </table>
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
</script>
<!-- END: main -->



