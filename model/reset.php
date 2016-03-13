<?php
/**
 * 用來支援同步的功能
 * 
 * 傳送參數
 * [$_GET]
 * uuid: FingerPint
 * timestamp: Device Timestamp
 * 
 * [$_POST]
 * logs
 */
include_once '../config.php';
include_once '../lib/redbeanphp/rb.config.php';
include_once '../helper/javascript_helper.php';
include_once '../helper/log_helper.php';


$views = array(
    "note",
    "uuid_name"
);
foreach ($views AS $view_name) {
    $sql = "DROP VIEW IF EXISTS " . $view_name;
    R::exec($sql);
}


$tables = array(
    "log"
);
foreach ($tables AS $table_name) {
    $sql = "DROP TABLE IF EXISTS " . $table_name;
    R::exec($sql);
}
