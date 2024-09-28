<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_cats;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_singers;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_songs;';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_cats (
  id smallint(4) NOT NULL AUTO_INCREMENT,
  cat_name varchar(255) NOT NULL,
  add_time int(11) NOT NULL DEFAULT 0,
  update_time int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_singers (
  id int(11) NOT NULL AUTO_INCREMENT,
  singer_name varchar(255) NOT NULL,
  add_time int(11) NOT NULL DEFAULT 0,
  update_time int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_songs (
  id int(11) NOT NULL AUTO_INCREMENT,
  song_name varchar(255) NOT NULL,
  path varchar(255) NOT NULL,
  singer_id int(11) NOT NULL,
  cat_id int(4) NOT NULL DEFAULT 0,
  add_time int(11) NOT NULL DEFAULT 0,
  update_time int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY cat_id (cat_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';



