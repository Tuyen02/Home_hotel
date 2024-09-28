<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_ROOM')) {
    exit('Stop!!!');
}

function nv_theme_room_main($rooms)
{
    global $module_info, $lang_module, $lang_global, $op;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    foreach ($rooms as $room) {
        $xtpl->assign('ROOM', $room);
        
        foreach ($room['features'] as $feature) {
            $xtpl->assign('FEATURE', $feature);
            $xtpl->parse('main.room.feature');
        }
        
        foreach ($room['facilities'] as $facility) {
            $xtpl->assign('FACILITY', $facility);
            $xtpl->parse('main.room.facility');
        }
        
        $xtpl->parse('main.room');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
