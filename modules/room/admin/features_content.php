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
$page_title = $lang_module['features_content'];

$post = $err = [];

$post['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($nv_Request->isset_request("submit", "post")) {
    $post["name"] = $nv_Request->get_title('name', "post", '');

    if ($post['name'] == '') {
        $err[] = "Chua nhap";
    }

    if (empty($err)) {
        if ($post['id'] > 0) {
            //them
            $sql = "UPDATE " . NV_PREFIXLANG . "_room_features SET name=:name WHERE id= " . $post['id'];
            $stmt = $db->prepare($sql);
        } else {
            //chen
            $sql = "INSERT INTO nv4_vi_room_features(name) 
                    VALUES (:name)";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindParam("name", $post['name']);
        $exe = $stmt->execute();
        if ($exe) {
            if ($post['id'] > 0) {
                $err[] = "Update oke";
            } else {
                $err[] = "Insert oke";
            }
        } else {
            $err[] = "Error";
        }
    }
} else if ($post['id'] > 0) {
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_room_features WHERE id = " . $post['id'];
    $post = $db->query($sql)->fetch();
} else {
    $post['name'] = '';
}


$xtpl = new XTemplate('features_content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('POST', $post);

if (!empty($err)) {
    $xtpl->assign('ERROR', implode(',', $err));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
