<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['room_images'];

$room_id = $nv_Request->get_int('room_id', 'get', 0);

// Kiểm tra nếu room_id hợp lệ
if ($room_id <= 0) {
    die('Invalid room');
}

// Lấy thông tin phòng
$room_id = $nv_Request->get_int('room_id', 'get', 0);
echo "Room ID: " . $room_id; // Để kiểm tra giá trị room_id
$room = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_room_rooms WHERE id=" . $room_id)->fetch();
if (empty($room)) {
    echo 'Room not found'; // Để kiểm tra nếu phòng không được tìm thấy
    die();
}


// Xử lý xóa ảnh
if ($nv_Request->isset_request("action", "post,get")) {
    $id = $nv_Request->get_int("id", "post,get", 0);
    $checksess = $nv_Request->get_title("checksess", "post,get", 0);
    if ($id > 0 && $checksess == md5($id . NV_CHECK_SESSION)) {
        $db->query("DELETE FROM " . NV_PREFIXLANG . "_room_images WHERE id=" . $id);
    }
}

// Xử lý thay đổi trạng thái kích hoạt
if ($nv_Request->isset_request("change_active", "post,get")) {
    $id = $nv_Request->get_int("id", "post,get", 0);
    $room_id = $nv_Request->get_int("room_id", "post,get", 0); // Đảm bảo nhận được room_id nếu cần
    $sql = "SELECT id, active FROM nv4_vi_room_images WHERE id=" . $id;
    $result = $db->query($sql);
    if ($image = $result->fetch()) {
        $active = $image['active'] == 1 ? 0 : 1;
        $exe = $db->query("UPDATE nv4_vi_room_images SET active=" . $active . " WHERE id=" . $id);
        if ($exe) {
            die("OK");
        }
    }
    die("ERR");
}

// Xử lý thêm ảnh mới
$post['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($nv_Request->isset_request('submit', 'post') && isset($_FILES['image'], $_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    // Khởi tạo Class upload
    $upload = new NukeViet\Files\Upload($admin_info['allow_files_type'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);

    // Thiết lập ngôn ngữ
    $upload->setLanguage($lang_global);

    // Đường dẫn thư mục lưu ảnh
    $upload_dir = NV_UPLOADS_REAL_DIR . '/room/images'; // Thư mục lưu ảnh
    $upload_info = $upload->save_file($_FILES['image'], $upload_dir, false, $global_config['nv_auto_resize']);

    if ($upload_info['error'] == '') {
        // Chỉ lưu tên file ảnh (không bao gồm đường dẫn) vào cơ sở dữ liệu
        $post['image'] = basename($upload_info['name']); // basename chỉ lấy tên file, ví dụ: img.jpg
    } else {
        $err[] = $upload_info['error']; // Nếu có lỗi, thêm vào danh sách lỗi
    }
}


if ($nv_Request->isset_request("submit", "post")) {
    $post["image"] = isset($post['image']) ? $post['image'] : '';
    $post["room_id"] = $nv_Request->get_int('room_id', "post", 0);
    $post["active"] = $nv_Request->get_int('active', "post", 1);

    if (empty($err)) {
        if ($post['id'] > 0) {
            // Cập nhật
            $sql = "UPDATE " . NV_PREFIXLANG . "_room_images SET image=:image, room_id=:room_id, active=:active WHERE id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $post['id']);
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
                $err[] = "Update successful";
            } else {
                $err[] = "Insert successful";
            }
        } else {
            $err[] = "Error occurred";
        }
    }
} else if ($post['id'] > 0) {
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_room_images WHERE id=" . $post['id'];
    $post = $db->query($sql)->fetch();
} else {
    $post['image'] = '';
    $post['active'] = 0;
    $post['room_id'] = 0;
}

// Lấy danh sách ảnh của phòng
$array_images = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_room_images WHERE room_id=" . $room_id)->fetchAll();

$xtpl = new XTemplate('room_images.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('ROOM', $room);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROOM_ID', $room_id);

// Hiển thị danh sách ảnh
if (!empty($array_images)) {
    foreach ($array_images as $index => $image) {
        $image['stt'] = $index + 1;
        $image['url'] = NV_BASE_SITEURL . 'uploads/room/images/' . $image['image']; // Tạo URL đầy đủ để hiển thị ảnh
        $image['url_delete'] = NV_BASE_ADMINURL . 'index.php?'
            . NV_LANG_VARIABLE . '=' . NV_LANG_DATA
            . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name
            . '&amp;' . NV_OP_VARIABLE . '=room_images'
            . '&amp;room_id=' . $room_id
            . '&amp;id=' . $image['id']
            . '&amp;action=delete'
            . '&amp;checksess=' . md5($image['id'] . NV_CHECK_SESSION);
        $image['active'] = $image['active'] == 1 ? 'checked="checked"' : '';
        $xtpl->assign('IMAGE', $image);
        $xtpl->parse('main.image');
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
