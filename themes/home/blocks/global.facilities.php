<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_facilities')) {

    function nv_facilities_config($module, $data_block, $lang_block)
    {
        global $lang_global, $db;

        // Truy vấn để lấy danh sách các tiện nghi từ cơ sở dữ liệu
        $sql = 'SELECT id, name FROM nv4_vi_room_facilities';
        $result = $db->query($sql);

        // Bắt đầu tạo mã HTML cho form
        $html = '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">Chọn tiện nghi:</label>';
        $html .= '<div class="col-sm-18">';
        $html .= '<select class="form-control" name="config_id">';

        // Thêm các tùy chọn vào danh sách thả xuống
        while ($row = $result->fetch()) {
            $selected = ($row['id'] == $data_block['config_id']) ? ' selected="selected"' : '';
            $html .= '<option value="' . $row['id'] . '"' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    function nv_facilities_submit()
    {
        global $nv_Request;

        $return = [];
        $return['error'] = [];
        $return['config']['config_id'] = $nv_Request->get_title('config_id', 'post'); // Lấy config_id từ yêu cầu POST

        if (empty($return['config']['config_id'])) {
            $return['error'][] = 'ID của tiện nghi không được để trống!';
        }

        return $return;
    }

    function nv_block_facilities($block_config)
    {
        global $global_config, $lang_global, $db;

        // Lựa chọn theme của block
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.facilities.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.facilities.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.facilities.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('BLOCK_THEME', $block_theme);
        $xtpl->assign('LANG', $lang_module);
        
        // Kiểm tra config_id hợp lệ
        if (isset($block_config['config_id']) && $block_config['config_id'] > 0) {
            $stmt = $db->prepare('SELECT * FROM `nv4_vi_room_facilities` WHERE id = :config_id');
            $stmt->bindParam(':config_id', $block_config['config_id'], PDO::PARAM_INT);
            $stmt->execute();

            if ($row = $stmt->fetch()) {
                $xtpl->assign('ROW', [
                    'name' => htmlspecialchars($row['name']),
                    'icon' => htmlspecialchars($row['icon'])
                ]); // Gán dữ liệu cho template
            } else {
                return 'Không tìm thấy tiện nghi với ID này';
            }
        } else {
            return 'ID của tiện nghi không hợp lệ';
        }

        $xtpl->parse('main');
        return $xtpl->text('main'); // Trả về nội dung đã được parse
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_facilities($block_config);
}
