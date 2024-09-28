<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_welcome')) {
    /**
     * nv_block_welcome()
     *
     * @param array $block_config
     * @return string
     */

    function nv_welcome_config($module, $data_block, $lang_block)
    {
        global $lang_global, $selectthemes;
        $html = '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">Title welcome:</label>';
        $html .= '<div class="col-sm-18"><input type="text" class="form-control" name="config_id" value="' . $data_block['id'] . '"></div>';
        $html .= '</div>';
 
        return $html;
    }

    function nv_welcome_submit()
    {
        global $nv_Request;

        $return = [];
        $return['erro'] = [];
        $return['config']['id'] = $nv_Request->get_title('config_id', 'post');

        return $return;
    }

    
    function nv_block_welcome($block_config)
    {
        global $global_config, $lang_global, $language_array, $db;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks/global.welcome.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/blocks/global.welcome.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.welcome.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/blocks');
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('BLOCK_THEME', $block_theme);
        $xtpl->assign('SELECT_LANGUAGE', $lang_global['langsite']);
        $xtpl->assign('BLOCK_CONFIG', $block_config);
        if($block_config['id'] > 0){
            $result = $db ->query('SELECT * FROM `nv4_vi_news_1` WHERE id ='.$block_config['id']);
            if($row = $result->fetch()){
                $xtpl->assign('ROW',$row);
            }
        }

        $xtpl->parse('main');

        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_welcome($block_config);
}
