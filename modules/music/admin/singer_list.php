<?php

    /**
     * NukeViet Content Management System
     * @version 4.x
     * @author VINADES.,JSC <contact@vinades.vn>
     * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
     * @license GNU/GPL version 2 or any later version
     * @see https://github.com/nukeviet The NukeViet CMS GitHub project
     */
    if (! defined('NV_IS_FILE_ADMIN')) {
        exit('Stop!!!');
    }
    
    if($nv_Request->isset_request("action","post,get")){
        $id = $nv_Request ->get_int("id","post,get",0);
        $checksess = $nv_Request ->get_title("checksess","post,get",0);
        if($id > 0 and $checksess == md5($id.NV_CHECK_SESSION)){
            $db ->query("DELETE FROM ".NV_PREFIXLANG."_music_singers WHERE id=".$id);
        }
    }

    $page_title = $lang_module['singer_list'];


    $post = $err = [];


    $db->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . "_" . $module_data . "_singers");
    $result = $db->query($db->sql());
    $array_row = $result->fetchAll();
    
    
    $xtpl = new XTemplate('singer_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl ->assign('LANG',$lang_module);
    $xtpl ->assign('NV_LANG_VARIABLE',NV_LANG_VARIABLE);
    $xtpl ->assign('NV_LANG_DATA',NV_LANG_DATA);
    $xtpl ->assign('NV_BASE_ADMINURL',NV_BASE_ADMINURL);
    $xtpl ->assign('NV_NAME_VARIABLE',NV_NAME_VARIABLE);
    $xtpl ->assign('NV_OP_VARIABLE',NV_OP_VARIABLE);
    $xtpl ->assign('MODULE_NAME',$module_name);
    $xtpl ->assign('OP',$op);

    if (!empty($array_row)) {
        $i=1;
        foreach($array_row as $row){
            $row['stt']=$i;
            $row['url_edit'] = NV_BASE_ADMINURL .'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' 
            . NV_OP_VARIABLE . '=singer-content&amp;id=' . $row['id'];
            $row['url_delete'] = NV_BASE_ADMINURL .'index.php?' . NV_LANG_VARIABLE . '=' 
            . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=singer_list&amp;id=' . $row['id']."&action=delete&checksess=" . md5($row['id'].NV_CHECK_SESSION);
            $xtpl->assign('ROW',$row);
            $xtpl->parse('main.loop');
            $i++;
        }
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
?>