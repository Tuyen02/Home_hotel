<!-- BEGIN: main -->
<div class="container">
<div class="table-reponsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr >
                <th class="text-nowrap text-center">{LANG.stt}</th>
                <th class="text-nowrap text-center">{LANG.name}</th>
                <th class="text-nowrap text-center">{LANG.icon}</th>
                <th class="text-nowrap text-center">{LANG.description}</th>
                <th class="text-nowrap text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">{ROW.stt}</td>
                    <td>{ROW.name}</td>
                    <td class="text-center"><img width="50" src="/uploads/room/facilities/{ROW.icon}" alt=""></td>
                    <td>{ROW.description}</td>
                    <td class="text-center">
                        <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>{LANG.btn_save}</a>
                        <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><<i class="fa fa-trash-o"></i>></i>{LANG.btn_delete}</a></td>
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
</script>
<!-- END: main -->



