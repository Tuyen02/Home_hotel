<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['images_content'];

$post = $err = [];

$post['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($nv_Request->isset_request('submit', 'post') and isset($_FILES['image'], $_FILES['image']['tmp_name']) and is_uploaded_file($_FILES['image']['tmp_name'])) {
    // Khởi tạo Class upload
    $upload = new NukeViet\Files\Upload($admin_info['allow_files_type'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);

    // Thiết lập ngôn ngữ
    $upload->setLanguage($lang_global);

    // Tải file lên server
    $upload_info = $upload->save_file($_FILES['image'], NV_UPLOADS_REAL_DIR . '/room_images', false, $global_config['nv_auto_resize']);

    if ($upload_info['error'] == '') {
        $post['image'] = $upload_info['name']; // Lưu đường dẫn ảnh
    } else {
        $err[] = $upload_info['error']; // Nếu có lỗi, thêm vào danh sách lỗi
    }
}

if ($nv_Request->isset_request("submit", "post")) {
    $post["image"] = $nv_Request->get_title('image', "post", '');
    $post["room_id"] = $nv_Request->get_int('room_id', "post", 0);
    $post["active"] = $nv_Request->get_int('active', "post", 0);

    if (empty($err)) {
        if ($post['id'] > 0) {
            // Cập nhật
            $sql = "UPDATE " . NV_PREFIXLANG . "_room_images SET image=:image, room_id=:room_id, active=:active WHERE id= " . $post['id'];
            $stmt = $db->prepare($sql);
        } else {
            // Thêm mới
            $sql = "INSERT INTO " . NV_PREFIXLANG . "_room_images (image, room_id, active) VALUES (:image, :room_id, :active)";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindParam("image", $post['image']);
        $stmt->bindParam("room_id", $post['room_id']);
        $stmt->bindParam("active", $post['active']);

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
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_room_images WHERE id = " . $post['id'];
    $post = $db->query($sql)->fetch();
} else {
    $post['image'] = '';
    $post['active'] = 1;
    $post['room_id'] = 0;
}

$xtpl = new XTemplate('images_content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
