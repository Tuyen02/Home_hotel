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

    $page_title = $lang_module['song_add'];

    $post = $err = [];
    $post['id'] = $nv_Request ->get_int('id',"post,get",0);
    if($nv_Request->isset_request("submit","post")){
        $post["song_name"] = $nv_Request->get_title('song_name',"post",'');
        $post["path"] = $nv_Request->get_title('path',"post",'');
        $post["singer_id"] = $nv_Request->get_int('singer_id',"post",0);
        $post["cat_id"] = $nv_Request->get_int('cat_id',"post",0);
        $post["add_time"] = $nv_Request->get_int('add_time',"post",0);
        $post["update_time"] = $nv_Request->get_int('update_time',"post",0);
        $post["active"] = $nv_Request->get_int('active',"post",1);

        if($post['song_name'] == ''){
            $err[] = "Chua nhap";
        }
        if($post['path'] == ''){
            $err[] = "Chua nhap";
        }

        if(empty($err)){
            if($post['id']>0){
                $sql = "UPDATE ". NV_PREFIXLANG."_music_songs SET song_name=:song_name,path=:path,singer_id=:singer_id,cat_id=:cat_id,update_time=:update_time,active=:active WHERE id= ".$post['id'];
                $stmt = $db ->prepare($sql);
                $stmt ->bindValue("update_time",NV_CURRENTTIME);
            }else{
                $sql = "INSERT INTO nv4_vi_music_songs(song_name, path, singer_id, cat_id, add_time,active) 
                VALUES (:song_name,:path,:singer_id,:cat_id,:add_time,:active)";
                $stmt = $db->prepare($sql);
                $stmt ->bindValue("add_time",NV_CURRENTTIME);
            }
            $stmt ->bindParam("song_name",$post['song_name']);
            $stmt ->bindParam("path",$post['path']);
            $stmt ->bindParam("singer_id",$post['singer_id']);
            $stmt ->bindParam("cat_id",$post['cat_id']);
            $stmt ->bindParam("active",$post['active']);

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
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_music_songs WHERE id = ". $post['id'];
        $post = $db ->query($sql) ->fetch();
    }else {
        $post['song_name']='';
        $post['path']='';
        $post['singer_id']=0;
        $post['cat_id']=1;
        $post['add_time']=0;
        $post['update_time']=0;
        $post['active']=0;

    }    

    try {
        $sql = "SELECT id,singer_name FROM nv4_vi_music_singers";
        $result = $db ->query($sql);
        $array_singer = [];
        while($singer = $result ->fetch()){
            $array_singer[$singer['id']] = $singer;
        }
    } catch (PDOException $e) {
        print($e);die();
    }

    $xtpl = new XTemplate('song-content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl ->assign('LANG',$lang_module);
    $xtpl ->assign('NV_LANG_VARIABLE',NV_LANG_VARIABLE);
    $xtpl ->assign('NV_LANG_DATA',NV_LANG_DATA);
    $xtpl ->assign('NV_BASE_ADMINURL',NV_BASE_ADMINURL);
    $xtpl ->assign('NV_NAME_VARIABLE',NV_NAME_VARIABLE);
    $xtpl ->assign('NV_OP_VARIABLE',NV_OP_VARIABLE);
    $xtpl ->assign('MODULE_NAME',$module_name);
    $xtpl ->assign('OP',$op);
    $xtpl ->assign('POST',$post);

    $array_cat = [];
    $array_cat [1] = 'ROCK';
    $array_cat [2] = 'RAP';
    $array_cat [3] = 'R&B';
    $array_cat [4] = 'Country';

    foreach($array_cat as $key => $cat_id){
        $xtpl ->assign('CAT', array(
            'key' => $key,
            'title' => $cat_id,
            'checked' => $key == $post['cat_id'] ? 'checked = "checked"' :''
        ));
        $xtpl ->parse('main.cat');
    }

    foreach($array_singer as $key => $singer){
        $xtpl ->assign('SINGER', array(
            'key' => $key,
            'title' => $singer['singer_name'],
            'selected' => $key == $post['singer_id'] ? 'selected = "selected"' :''
        ));
        $xtpl ->parse('main.singer');
    }

    if(!empty($err)){
        $xtpl ->assign('ERROR',implode(',', $err));
        $xtpl ->parse('main.error');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
