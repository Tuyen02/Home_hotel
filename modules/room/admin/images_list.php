<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['images_list'];

if ($nv_Request->isset_request("action", "post,get")) {
    $id = $nv_Request->get_int("id", "post,get", 0);
    $checksess = $nv_Request->get_title("checksess", "post,get", 0);

    if ($id > 0 and $checksess == md5($id . NV_CHECK_SESSION)) {
        // Kiểm tra nếu ảnh tồn tại trước khi xóa
        $row = $db->query("SELECT image FROM " . NV_PREFIXLANG . "_room_images WHERE id = " . $id)->fetch();
        if ($row) {
            // Xóa ảnh vật lý nếu cần
            @unlink(NV_UPLOADS_REAL_DIR . '/room_images/' . $row['image']);

            // Xóa dữ liệu trong CSDL
            $db->query("DELETE FROM " . NV_PREFIXLANG . "_room_images WHERE id = " . $id);
        }
    }
}
if($nv_Request->isset_request("change_active","post,get")){
    $id = $nv_Request ->get_int("id","post,get",0);
    $sql = "SELECT id, active FROM nv4_vi_room_images WHERE id=" .$id;
    $result = $db ->query($sql);
    if($row = $result ->fetch()){
        $active = $row['active'] == 1 ? 0 : 1;
        $exe = $db ->query("UPDATE nv4_vi_room_images SET active =". $active . " WHERE id=" .$id);
        if($exe){
            die("OK");
        }
    }
    die("ERR");
}

$db->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . "_" . $module_data . "_images")
    ->order('id DESC'); // Sắp xếp theo id giảm dần

$result = $db->query($db->sql());

if ($result === false) {
    trigger_error($db->errorInfo(), E_USER_WARNING); // Hiển thị lỗi nếu truy vấn gặp vấn đề
} else {
    $array_row = $result->fetchAll();
}

$xtpl = new XTemplate('images_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

if (!empty($array_row)) {
    $i = 1;
    foreach ($array_row as $row) {
        $row['stt'] = $i;
        $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=images_content&amp;id=' . $row['id'];
        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=images_list&amp;id=' . $row['id'] . "&action=delete&checksess=" . md5($row['id'] . NV_CHECK_SESSION);
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
        $i++;
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
