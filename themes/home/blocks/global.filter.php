<?php
if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

if (!nv_function_exists('nv_block_filter')) {
    function nv_block_filter($block_config)
    {
        global $global_config, $lang_global, $nv_Cache, $module_name, $module_data, $nv_Request;

        // URL for filtering action
        $filter_url = NV_BASE_SITEURL . NV_LANG_DATA . '/room';

        // Fetching facilities from the database
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_facilities';
        $facilities_list = $nv_Cache->db($sql, 'id', $module_name);

        // Get filter values from request
        $checkin = $nv_Request->get_title('checkin', 'get', '');
        $checkout = $nv_Request->get_title('checkout', 'get', '');
        $adult = $nv_Request->get_int('adult', 'get', 0);
        $children = $nv_Request->get_int('children', 'get', 0);
        $facilities = $nv_Request->get_array('facilities', 'get', []);

        // Create the XTemplate instance
        $xtpl = new XTemplate('global.filter.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/blocks');

        // Assigning variables to template
        $xtpl->assign('FILTER_URL', $filter_url);
        $xtpl->assign('CHECKIN', $checkin);
        $xtpl->assign('CHECKOUT', $checkout);
        $xtpl->assign('ADULT', $adult);
        $xtpl->assign('CHILDREN', $children);

        // Processing facilities
        foreach ($facilities_list as $facility) {
            $xtpl->assign('FACILITY_FILTER', $facility);
            $xtpl->assign('CHECKED', in_array($facility['id'], $facilities) ? 'checked' : '');
            $xtpl->parse('main.facility_filter');
        }

        // Finalizing the template
        $xtpl->parse('main');

        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_filter($block_config);
}
?>
