<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

$allow_func = [
    'main',
    'room_content',
    'features_content',
    'features_list',
    'facilities_content',
    'facilities_list',
    'images_list',
    'images_content',
    'room_images',
    'booking_content',
    'booking_confirm',
    'booking_cancel',
    'print_invoice',
];

define('NV_IS_FILE_ADMIN', true);



