<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['room_content'];
$post = $err = [];

// Lấy ID từ yêu cầu
$post['id'] = $nv_Request->get_int('id', 'post,get', 0);

$xtpl = new XTemplate('room_content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

// Lấy danh sách features
try {
    $sql = "SELECT id, name FROM nv4_vi_room_features";
    $result = $db->query($sql);
    $array_features = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    print($e);
    die();
}

// Hiển thị checkbox features
foreach ($array_features as $feature) {
    $xtpl->assign('FEATURES', array(
        'key' => $feature['id'],
        'title' => $feature['name'],
        'checked' => ''
    ));
    $xtpl->parse('main.features');
}

// Lấy danh sách facilities
try {
    $sql = "SELECT id, name FROM nv4_vi_room_facilities";
    $result = $db->query($sql);
    $array_facilities = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    print($e);
    die();
}

// Hiển thị checkbox facilities
foreach ($array_facilities as $facility) {
    $xtpl->assign('FACILITIES', array(
        'key' => $facility['id'],
        'title' => $facility['name'],
        'checked' => ''
    ));
    $xtpl->parse('main.facilities');
}

if ($nv_Request->isset_request("submit", "post")) {
    // Lấy thông tin từ form
    $post["name"] = $nv_Request->get_title('name', "post", '');
    $post["area"] = $nv_Request->get_int('area', "post", 0);
    $post["price"] = $nv_Request->get_int('price', "post", 0);
    $post["quantity"] = $nv_Request->get_int('quantity', "post", 0);
    $post["adult"] = $nv_Request->get_int('adult', "post", 1);
    $post["children"] = $nv_Request->get_int('children', "post", 1);
    $post["description"] = $nv_Request->get_title('description', "post", '');
    $post["removed"] = $nv_Request->get_int('removed', "post", 0);
    $post["active"] = $nv_Request->get_int('active', "post", 0);
    $post["weight"] = $nv_Request->get_int('weight', "post", 0);
    $post['features'] = $nv_Request->get_array('features', 'post', []);
    $post['facilities'] = $nv_Request->get_array('facilities', 'post', []);

    if (empty($err)) {
        try {
            // Nếu có ID, thực hiện cập nhật, nếu không thì thêm mới
            if ($post['id'] > 0) {
                // Xóa các mối quan hệ cũ trước khi cập nhật
                $sql = "DELETE FROM nv4_vi_room_roomxfeatures WHERE room_id=:room_id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":room_id", $post['id'], PDO::PARAM_INT);
                $stmt->execute();

                $sql = "DELETE FROM nv4_vi_room_roomxfacilities WHERE room_id=:room_id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":room_id", $post['id'], PDO::PARAM_INT);
                $stmt->execute();

                $sql = "UPDATE " . NV_PREFIXLANG . "_room_rooms SET 
                    name=:name, area=:area, price=:price, quantity=:quantity, adult=:adult, children=:children, 
                    description=:description, removed=:removed, active=:active, weight=:weight 
                    WHERE id=:id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $post['id'], PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO " . NV_PREFIXLANG . "_room_rooms 
                    (name, area, price, quantity, adult, children, description, status, removed, active, weight) 
                    VALUES (:name, :area, :price, :quantity, :adult, :children, :description, 1, :removed, :active, :weight)";
                $stmt = $db->prepare($sql);
            }

            // Bind các tham số
            $stmt->bindParam(":name", $post['name']);
            $stmt->bindParam(":area", $post['area']);
            $stmt->bindParam(":price", $post['price']);
            $stmt->bindParam(":quantity", $post['quantity']);
            $stmt->bindParam(":adult", $post['adult']);
            $stmt->bindParam(":children", $post['children']);
            $stmt->bindParam(":description", $post['description']);
            $stmt->bindParam(":removed", $post['removed']);
            $stmt->bindParam(":active", $post['active']);
            $stmt->bindParam(":weight", $post['weight']);

            if ($stmt->execute()) {
                // Lấy id của phòng mới thêm
                if ($post['id'] == 0) {
                    $post['id'] = $db->lastInsertId();
                }

                // Xóa features cũ
                $sql = "DELETE FROM nv4_vi_room_roomxfeatures WHERE room_id=:room_id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":room_id", $post['id'], PDO::PARAM_INT);
                $stmt->execute();

                // Lưu features mới
                if (!empty($post['features'])) {
                    foreach ($post['features'] as $features_id) {
                        $sql = "INSERT INTO nv4_vi_room_roomxfeatures (room_id, features_id) VALUES (:room_id, :features_id)";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':room_id', $post['id'], PDO::PARAM_INT);
                        $stmt->bindParam(':features_id', $features_id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }

                // Xóa facilities cũ
                $sql = "DELETE FROM nv4_vi_room_roomxfacilities WHERE room_id=:room_id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":room_id", $post['id'], PDO::PARAM_INT);
                $stmt->execute();

                // Lưu facilities mới
                if (!empty($post['facilities'])) {
                    foreach ($post['facilities'] as $facilities_id) {
                        $sql = "INSERT INTO nv4_vi_room_roomxfacilities (room_id, facilities_id) VALUES (:room_id, :facilities_id)";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':room_id', $post['id'], PDO::PARAM_INT);
                        $stmt->bindParam(':facilities_id', $facilities_id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }

                $err[] = $post['id'] > 0 ? "Update thành công" : "Insert thành công";
            } else {
                $err[] = "Lỗi khi lưu dữ liệu!";
            }
        } catch (PDOException $e) {
            $err[] = "Lỗi cơ sở dữ liệu: " . $e->getMessage();
        }
    }
} else if ($post['id'] > 0) {
    // Lấy thông tin phòng khi có ID
    try {
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_room_rooms WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $post['id'], PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch();
    } catch (PDOException $e) {
        $err[] = "Lỗi cơ sở dữ liệu: " . $e->getMessage();
    }
}

// Load template và hiển thị
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
    $xtpl->assign('ERROR', implode(', ', $err));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
