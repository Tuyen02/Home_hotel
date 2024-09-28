<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_contact')) {
    /**
     * nv_block_contact()
     *
     * @param array $block_config
     * @return string
     */

    function nv_contact_config($module, $data_block, $lang_block)
    {

        global $lang_global, $selectthemes;
        $html = '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">Địa chỉ: </label>';
        $html .= '<div class="col-sm-18" style="margin-bottom: 15px;"><input type="text" class="form-control" name="link_map" value="' . $data_block['link_map'] . '"></div>';
        $html .= '<label class="control-label col-sm-6">Số hot-line: </label>';
        $html .= '<div class="col-sm-18" style="margin-bottom: 15px;"><input type="text" class="form-control" name="hotline" value="' . $data_block['hotline'] . '"></div>';
        $html .= '<label class="control-label col-sm-6">Số cố định: </label>';
        $html .= '<div class="col-sm-18" style="margin-bottom: 15px;"><input type="text" class="form-control" name="telephone_number" value="' . $data_block['telephone_number'] . '"></div>';
        $html .= '<label class="control-label col-sm-6">Youtube: </label>';
        $html .= '<div class="col-sm-18" style="margin-bottom: 15px;"><input type="text" class="form-control" name="youtube" value="' . $data_block['youtube'] . '"></div>';
        $html .= '<label class="control-label col-sm-6">Facebook: </label>';
        $html .= '<div class="col-sm-18" style="margin-bottom: 15px;"><input type="text" class="form-control" name="link_fb" value="' . $data_block['link_fb'] . '"></div>';
        $html .= '<label class="control-label col-sm-6">Instagram: </label>';
        $html .= '<div class="col-sm-18" ><input type="text" class="form-control" name="link_ins" value="' . $data_block['link_ins'] . '"></div>';
        $html .= '</div>';

 
        return $html;
    }

    function nv_contact_submit()
    {
        global $nv_Request;

        $return = [];
        $return['error'] = [];
        $return['config']['link_map'] = $nv_Request->get_title('link_map', 'post');
        $return['config']['hotline'] = $nv_Request->get_title('hotline', 'post');
        $return['config']['telephone_number'] = $nv_Request->get_title('telephone_number', 'post');
        $return['config']['youtube'] = $nv_Request->get_title('youtube', 'post');
        $return['config']['link_fb'] = $nv_Request->get_title('link_fb', 'post');
        $return['config']['link_ins'] = $nv_Request->get_title('link_ins', 'post');

        // Trả về dữ liệu để hiển thị
        return $return;
    }

    
    function nv_block_contact($block_config)
    {
        global $global_config, $lang_global, $site_mods;
        $module = $block_config['module'];
        $module_data = $site_mods[$module]['module_data'];
        $module_file = $site_mods[$module]['module_file'];

        // Lấy theme hiện tại
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file . '/global.contact.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $module_file . '/global.contact.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        // Khởi tạo XTemplate
        //C:\xampp\htdocs\Home_hotel\themes\home\modules\contact\global.contact.tpl
        $xtpl = new XTemplate('global.contact.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $module_file );
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);

        // Truyền dữ liệu từ block_config sang template
        $xtpl->assign('LINK_MAP', $block_config['link_map']);
        $xtpl->assign('HOTLINE', $block_config['hotline']);
        $xtpl->assign('TELEPHONE_NUMBER', $block_config['telephone_number']);
        $xtpl->assign('YOUTUBE', $block_config['youtube']);
        $xtpl->assign('LINK_FB', $block_config['link_fb']);
        $xtpl->assign('LINK_INS', $block_config['link_ins']);

        // Parse dữ liệu vào template
        $xtpl->parse('main');

        // Trả về nội dung đã render
        return $xtpl->text('main');
    }

}

if (defined('NV_SYSTEM')) {
    $content = nv_block_contact($block_config);
}
