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

$page_title = $lang_module['facilities_content'];

$post = $err = [];

$post['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($nv_Request->isset_request('submit', 'post') and isset($_FILES, $_FILES['icon'], $_FILES['icon']['tmp_name']) and is_uploaded_file($_FILES['icon']['tmp_name'])) {
    // Khởi tạo Class upload
    $upload = new NukeViet\Files\Upload($admin_info['allow_files_type'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);

    // Thiết lập ngôn ngữ, nếu không có dòng này thì ngôn ngữ trả về toàn tiếng Anh
    $upload->setLanguage($lang_global);

    // Tải file lên server
    $upload_info = $upload->save_file($_FILES['icon'], NV_UPLOADS_REAL_DIR, false, $global_config['nv_auto_resize']);

    echo '<pre><code>';
    echo htmlspecialchars(print_r($upload_info, true));
    die();
}


if ($nv_Request->isset_request("submit", "post")) {
    $post["name"] = $nv_Request->get_title('name', "post", '');
    $post["icon"] = $nv_Request->get_title('icon', "post", '');
    $post["description"] = $nv_Request->get_title('description', "post", '');

    if ($post['name'] == '') {
        $err[] = "Chua nhap";
    }

    if (empty($err)) {
        if ($post['id'] > 0) {
            //them
            $sql = "UPDATE " . NV_PREFIXLANG . "_room_facilities SET name=:name,icon=:icon,description=:description WHERE id= " . $post['id'];
            $stmt = $db->prepare($sql);
        } else {
            //chen
            $sql = "INSERT INTO nv4_vi_room_facilities(name,icon,description) 
                    VALUES (:name,:icon,:description)";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindParam("name", $post['name']);
        $stmt->bindParam("icon", $post['icon']);
        $stmt->bindParam("description", $post['description']);
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
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_room_facilities WHERE id = " . $post['id'];
    $post = $db->query($sql)->fetch();
} else {
    $post['name'] = '';
    $post['icon'] = '';
    $post['description'] = '';
}


$xtpl = new XTemplate('facilities_content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
