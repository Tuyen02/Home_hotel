<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

    if (!defined('NV_IS_FILE_ADMIN')) {
        exit('Stop!!!');
    }

    $page_title = $lang_module['singer_add'];

    $post= $err = [];

    $post['id'] = $nv_Request ->get_int('id','post,get',0);

    if($nv_Request->isset_request("submit","post")){
        $post["singer_name"] = $nv_Request->get_title('singer_name',"post",'');
        $post["add_time"] = $nv_Request->get_int('add_time',"post",0);
        $post["update_time"] = $nv_Request->get_int('update_time',"post",0);

        if($post['singer_name'] == ''){
            $err[] = "Chua nhap";
        }

        if(empty($err)){
            if($post['id'] > 0){
                //them
                $sql = "UPDATE ". NV_PREFIXLANG."_music_singers SET singer_name=:singer_name,update_time=:update_time WHERE id= ".$post['id'];
                    $stmt = $db ->prepare($sql);
                    $stmt ->bindValue("update_time",NV_CURRENTTIME);
            }else{
                //chen
                $sql = "INSERT INTO nv4_vi_music_singers(singer_name,add_time) 
                    VALUES (:singer_name,:add_time)";
                    $stmt = $db->prepare($sql);
                    $stmt ->bindValue("add_time",NV_CURRENTTIME);
            }    
            $stmt ->bindParam("singer_name",$post['singer_name']);
            $exe = $stmt ->execute();
            if ($exe) {
                    if($post['id'] > 0){
                        $err[] = "Update oke";
                    }else{
                        $err[] = "Insert oke";
                    }
                } else {
                    $err[] = "Error";
                } 
            }
    }else if($post['id'] > 0){
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_music_singers WHERE id = ". $post['id'];
        $post = $db ->query($sql) ->fetch();
        }else {
        $post['singer_name']='';
        $post['add_time']=0;
        $post['update_time']=0;
    }    


    $xtpl = new XTemplate('singer_content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl ->assign('LANG',$lang_module);
    $xtpl ->assign('NV_LANG_VARIABLE',NV_LANG_VARIABLE);
    $xtpl ->assign('NV_LANG_DATA',NV_LANG_DATA);
    $xtpl ->assign('NV_BASE_ADMINURL',NV_BASE_ADMINURL);
    $xtpl ->assign('NV_NAME_VARIABLE',NV_NAME_VARIABLE);
    $xtpl ->assign('NV_OP_VARIABLE',NV_OP_VARIABLE);
    $xtpl ->assign('MODULE_NAME',$module_name);
    $xtpl ->assign('OP',$op);
    $xtpl ->assign('POST',$post);

    if(!empty($err)){
        $xtpl ->assign('ERROR',implode(',', $err));
        $xtpl ->parse('main.error');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
