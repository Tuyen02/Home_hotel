<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_search')) {
    /**
     * nv_block_search()
     *
     * @param array $block_config
     * @return string
     */
    function nv_block_search($block_config)
    {
        global $global_config, $lang_global, $db, $module_name, $module_info;

        // Sử dụng module_theme làm theme hiện tại
        $block_theme = $global_config['module_theme'];

        // Tạo URL cho action của form tìm kiếm
        // Thay 'news' bằng 'room' để đảm bảo đường dẫn chính xác
        $search_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=room'; 

        // Tạo template
        $xtpl = new XTemplate('global.search.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        
        // Gán các biến vào template
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('BLOCK_THEME', $block_theme);
        $xtpl->assign('SEARCH_URL', $search_url); // Gán URL tìm kiếm với module 'room'
        $xtpl->assign('SELECT_LANGUAGE', $lang_global['langsite']);

        // Xử lý các phần tử của template
        $xtpl->parse('main');

        // Trả về nội dung sau khi parse
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_search($block_config);
}
