<?php
if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}
if (!nv_function_exists('nv_block_room_by_id')) {

    function nv_room_config($module, $data_block, $lang_block)
    {
        global $db;

        // Truy vấn để lấy danh sách các phòng từ cơ sở dữ liệu
        $sql = 'SELECT id, name FROM nv4_vi_room_rooms';
        $result = $db->query($sql);

        // Bắt đầu tạo mã HTML cho form
        $html = '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">Chọn phòng:</label>';
        $html .= '<div class="col-sm-18">';
        $html .= '<select class="form-control" name="room_id">';

        // Thêm các tùy chọn vào danh sách thả xuống
        while ($row = $result->fetch()) {
            $selected = ($row['id'] == $data_block['room_id']) ? ' selected="selected"' : '';
            $html .= '<option value="' . $row['id'] . '"' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    function nv_room_submit()
    {
        global $nv_Request;

        $return = [];
        $return['error'] = [];
        $return['config']['room_id'] = $nv_Request->get_title('room_id', 'post'); // Lấy room_id từ yêu cầu POST

        return $return;
    }

    function nv_block_room_by_id($block_config)
    {
        global $global_config, $db, $module_name, $lang_module, $module_file;

        // Kiểm tra xem file template tồn tại hay không
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.room.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.room.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        // Tạo đối tượng XTemplate
        $xtpl = new XTemplate('global.room.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');

        $room_id = $block_config['room_id'];

        if ($room_id > 0) {
            // Truy vấn lấy thông tin phòng theo room_id
            $sql = "SELECT 
                r.id AS room_id,
                r.name AS room_name,
                r.price,
                r.adult,
                r.children,
                r.description AS room_description,
                GROUP_CONCAT(DISTINCT f.name ORDER BY f.name ASC SEPARATOR ', ') AS features,
                GROUP_CONCAT(DISTINCT fa.name ORDER BY fa.name ASC SEPARATOR ', ') AS facilities,
                GROUP_CONCAT(DISTINCT ri.image ORDER BY ri.active DESC SEPARATOR ', ') AS images
            FROM nv4_vi_room_rooms r
            LEFT JOIN nv4_vi_room_roomxfeatures rf ON r.id = rf.room_id
            LEFT JOIN nv4_vi_room_features f ON rf.features_id = f.id
            LEFT JOIN nv4_vi_room_roomxfacilities rfa ON r.id = rfa.room_id
            LEFT JOIN nv4_vi_room_facilities fa ON rfa.facilities_id = fa.id
            LEFT JOIN nv4_vi_room_images ri ON r.id = ri.room_id AND ri.active = 1
            WHERE r.id = :room_id
            GROUP BY r.id;";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->execute();
            $room = $stmt->fetch();

            if ($room) {
                $room['price'] = number_format($room['price'], 0, ',', '.') . '₫';
                $room['images'] = array_map(function($image) {
                    return NV_BASE_SITEURL . 'uploads/room/images/' . $image;
                }, explode(',', $room['images']));
                
                $room['features'] = explode(',', $room['features']);
                $room['facilities'] = explode(',', $room['facilities']);
                $room['booking_url'] = NV_BASE_SITEURL . 'vi/room/booking';
                $room['view_url'] = NV_BASE_SITEURL . NV_LANG_DATA . '/room/view?id=' . $room['room_id'];

                $xtpl->assign('ROOM', $room);

                // Lặp qua danh sách tiện nghi và đặc điểm để hiển thị
                foreach ($room['features'] as $feature) {
                    $xtpl->assign('FEATURE', trim($feature)); // Sửa thành trim() để loại bỏ khoảng trắng
                    $xtpl->parse('main.room.feature');
                }

                foreach ($room['facilities'] as $facility) {
                    $xtpl->assign('FACILITY', trim($facility)); // Sửa thành trim() để loại bỏ khoảng trắng
                    $xtpl->parse('main.room.facility');
                }

                foreach ($room['images'] as $image) {
                    $xtpl->assign('IMAGE', $image);
                    $xtpl->parse('main.room.image');
                }

                // Parse các khối chính
                $xtpl->parse('main.room');
                $xtpl->parse('main');

                // Trả về nội dung đã render
                return $xtpl->text('main');
            } else {
                return 'Phòng không tồn tại hoặc ID không hợp lệ';
            }
        } else {
            return 'Không có ID phòng được cung cấp';
        }
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_room_by_id($block_config);
}
