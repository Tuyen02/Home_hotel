<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
}

define('NV_IS_MOD_ROOM', true);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_features';
$features_list = $nv_Cache->db($sql, 'id', $module_name);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_facilities';
$facilities_list = $nv_Cache->db($sql, 'id', $module_name);

