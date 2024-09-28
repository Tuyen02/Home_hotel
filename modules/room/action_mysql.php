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

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_carousel;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rooms;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_facilities;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_features;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_images;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_roomxfeatures;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_roomxfacilities;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_booking;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_booking_details;';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_carousel (
  id int(11) NOT NULL,
  image varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rooms (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(150) NOT NULL,
  area int(11) NOT NULL,
  price int(11) NOT NULL,
  quantity int(11) NOT NULL,
  adult int(11) NOT NULL,
  children int(11) NOT NULL,
  description varchar(350) NOT NULL,
  status tinyint(4) NOT NULL DEFAULT 1,
  removed int(11) NOT NULL DEFAULT 0,
  active tinyint(4) NOT NULL DEFAULT 1,
  weight tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_facilities (
  id int(11) NOT NULL AUTO_INCREMENT,
  icon varchar(100) NOT NULL,
  name varchar(50) NOT NULL,
  description varchar(250) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_features (
  id int(11) NOT NULL AUTO_INCREMENT,
  icon varchar(100) NOT NULL,
  name varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';


$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_images (
  id int(11) NOT NULL AUTO_INCREMENT,
  room_id int(11) NOT NULL,
  image varchar(150) NOT NULL,
  thumb tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY (room_id) REFERENCES nv4_vi_room_rooms (id)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_roomxfacilities (
  id int(11) NOT NULL AUTO_INCREMENT,
  room_id int(11) NOT NULL,
  facilities_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY nv4_vi_room_facilities id (facilities_id),
  KEY nv4_vi_room_room id (room_id),
  CONSTRAINT nv4_vi_room_facilities id FOREIGN KEY (facilities_id) REFERENCES nv4_vi_room_facilities (id) ON UPDATE NO ACTION,
  CONSTRAINT nv4_vi_room_room id FOREIGN KEY (room_id) REFERENCES nv4_vi_room_rooms (id) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_roomxfeatures (
  id int(11) NOT NULL AUTO_INCREMENT,
  room_id int(11) NOT NULL,
  features_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY nv4_vi_room_features id (features_id),
  KEY nv4_vi_room_room id (room_id),
  CONSTRAINT nv4_vi_room_features id FOREIGN KEY (features_id) REFERENCES nv4_vi_room_features (id) ON UPDATE NO ACTION,
  CONSTRAINT nv4_vi_room_room id FOREIGN KEY (room_id) REFERENCES nv4_vi_room_rooms (id) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_booking (
  booking_id int(11) NOT NULL AUTO_INCREMENT,
  room_id int(11) NOT NULL,
  userid int(11) NOT NULL ,
  check_in int(11) NOT NULL,
  check_out int(11) NOT NULL,
  arrival int(11) NOT NULL DEFAULT 0,
  refund int(11) DEFAULT NULL,
  booking_status tinyint(3) NOT NULL DEFAULT 0,
  order_id varchar(150) NOT NULL,
  trans_id varchar(200) DEFAULT NULL,
  trans_amt int(11) NOT NULL,
  trans_status tinyint(3) NOT NULL DEFAULT 0,
  trans_resp_msg varchar(200) DEFAULT NULL,
  rate_review int(11) DEFAULT NULL,
  datentime int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (booking_id),
  FOREIGN KEY (room_id) REFERENCES nv4_vi_room_rooms (id)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$sql_create_module[] = 'CREATE TABLE IF NOT EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_booking_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  booking_id int(11) NOT NULL,
  room_name varchar(100) NOT NULL,
  price int(11) NOT NULL,
  total_pay int(11) NOT NULL,
  room_no varchar(100) DEFAULT NULL,
  user_name varchar(100) NOT NULL,
  phonenum varchar(100) NOT NULL,
  address varchar(150) NOT NULL,
  PRIMARY KEY (id),
  KEY booking_id (booking_id)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

