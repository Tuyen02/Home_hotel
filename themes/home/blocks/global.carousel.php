<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_carousel')) {
    /**
     * nv_block_carousel()
     *
     * @param array $block_config
     * @return string
     */

    function nv_block_carousel($block_config)
    {
        global $global_config, $lang_global, $language_array, $db;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.carousel.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.carousel.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_room_carousel ORDER BY id ASC';
        $result = $db->query($sql);

        $xtpl = new XTemplate('global.carousel.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('BLOCK_THEME', $block_theme);
        $xtpl->assign('SELECT_LANGUAGE', $lang_global['langsite']);

        $images = [];
        while ($row = $result->fetch()) {
            $xtpl->assign('ROW', 
                ['image' => $row['image']]);
            $xtpl->parse('main.carousel');
        }
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_carousel($block_config);
}
