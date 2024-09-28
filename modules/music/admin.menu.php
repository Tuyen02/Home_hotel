<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}

//$submenu['content'] = $lang_module['add'];

if (defined('NV_IS_SPADMIN')) {
    $submenu['song-content'] = $lang_module['song_add'];
    $submenu['singer-content'] = $lang_module['singer_add'];
    $submenu['singer_list'] = $lang_module['singer_list'];
    $submenu['cat_content'] = $lang_module['cat_content'];
    $submenu['cat_list'] = $lang_module['cat_list'];

    
}
