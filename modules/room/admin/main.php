<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}
$page_title = $lang_module['rooms'];

//thay doi vi tri stt theo weight
if ($nv_Request->isset_request("change_weight", "post,get")) {
    $id = $nv_Request->get_int("id", "post,get", 0);
    $new_weight = $nv_Request->get_int("new_weight", "post,get", 0);
    if ($id > 0 and $new_weight > 0) {
        $sql = "SELECT id, weight FROM nv4_vi_room_rooms WHERE id !=" . $id;
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight == $new_weight) {
                ++$weight;
            }
            $exe = $db->query("UPDATE nv4_vi_room_rooms SET weight =" . ($weight) . " WHERE id=" . $row['id']);
        }
        $exe = $db->query("UPDATE nv4_vi_room_rooms SET weight =" . $new_weight . " WHERE id=" . $id);
    }
}

//xoa
if ($nv_Request->isset_request("action", "post,get")) {
    $id = $nv_Request->get_int("id", "post,get", 0);
    $checksess = $nv_Request->get_title("checksess", "post,get", 0);
    if ($id > 0 and $checksess == md5($id . NV_CHECK_SESSION)) {
        $db->query("DELETE FROM " . NV_PREFIXLANG . "_room_rooms WHERE id=" . $id);
    }
}


//btn active
if ($nv_Request->isset_request("change_active", "post,get")) {
    $id = $nv_Request->get_int("id", "post,get", 0);
    $sql = "SELECT id, active FROM nv4_vi_room_rooms WHERE id=" . $id;
    $result = $db->query($sql);
    if ($row = $result->fetch()) {
        $active = $row['active'] == 1 ? 0 : 1;
        $exe = $db->query("UPDATE nv4_vi_room_rooms SET active =" . $active . " WHERE id=" . $id);
        if ($exe) {
            die("OK");
        }
    }
    die("ERR");
}

//phan trang
$perpage = 5;
$page = $nv_Request->get_int("page", "get", 1);
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . "_" . $module_data . "_rooms");
$sql = $db->sql();
$total = $db->query($sql)->fetchColumn();

$db->select('*')
    ->order("weight ASC")
    ->limit($perpage)
    ->offset(($page - 1) * $perpage);
$sql = $db->sql();
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $array_row[$row['id']] = $row;
}

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

if (!empty($array_row)) {
    $i = ($page - 1) * $perpage;
    foreach ($array_row as $row) {
        $row['stt'] = $i + 1;

        for ($j = 1; $j <= $total; $j++) {
            $xtpl->assign('J', $j);
            $xtpl->assign('J_SELECT', $j ==  $row['weight'] ? 'selected="selected"' : '');
            $xtpl->parse('main.loop.weight');
        }

        //$row['cat'] = !empty( $array_cat[$row['cat_id']]) ? $array_cat[$row['cat_id']] : '';
        //$row['singer'] = !empty( $array_singer[$row['singer_id']]) ? $array_singer[$row['singer_id']]['singer_name'] : '';
        $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=room_content&amp;id=' . $row['id'];
        $row['url_image'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=room_images&amp;room_id=' . $row['id'];
        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main&amp;id=' . $row['id'] . "&action=delete&checksess=" . md5($row['id'] . NV_CHECK_SESSION);
        $row['active'] = $row['active'] == 1 ? 'checked="checked"' : '';
        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
        $i++;
    }
}
if ($total > $perpage) {
    $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main';
    $generate_page = nv_generate_page($base_url, $total, $perpage, $page);
    $xtpl->assign('GENERATE_PAGE', $generate_page);
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
