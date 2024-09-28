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


if (defined('NV_IS_SPADMIN')) {
    $submenu['room_content'] = $lang_module['room_content'];
    $submenu['features_content']=$lang_module['features_content'];
    $submenu['features_list'] = $lang_module['features_list'];
    $submenu['facilities_content']=$lang_module['facilities_content'];
    $submenu['facilities_list'] = $lang_module['facilities_list'];
    // $submenu['images_content'] = $lang_module['images_content'];
    // $submenu['images_list'] = $lang_module['images_list'];
    // $submenu['room_images'] = $lang_module['room_images'];
    $submenu['booking_content'] = $lang_module['booking_content'];
}
