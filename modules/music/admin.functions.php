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
    'song-content',
    'cat_content',
    'cat_list',
    'singer_list',
    'singer-content',

];

$array_cat = [];
$array_cat [1] = 'ROCK';
$array_cat [2] = 'RAP';
$array_cat [3] = 'R&B';
$array_cat [4] = 'Country';

$sql = "SELECT id,singer_name FROM nv4_vi_music_singers";
        $result = $db ->query($sql);
        $array_singer = [];
        while($singer = $result ->fetch()){
            $array_singer[$singer['id']] = $singer;
        }

define('NV_IS_FILE_ADMIN', true);
