<?php
/**
 * 連線方式 http://localhost/voc4fun/voc4fun-server/
 */

include_once 'config.php';
include_once 'helper/javascript_helper.php';
include_once 'lib/redbeanphp/rb.config.php';

//$log = R::dispense('log');
//$log->timestamp = time() * 1000;
//$log->file_name = "index.php";
//$log->function_name = null;
//$log->qualifier = null;
//$log->data = json_encode(array("key" => "value2"));
//
//R::store($log);

//$logs = R::dispense('log');
//$logs->import(array(
//    array(
//        'timestamp' => time() * 1000,
//        'file_name' => "index.php",
//        'function_name' => "1"
//    ),
//    array(
//        'timestamp' => time() * 1000,
//        'file_name' => "index.php",
//        'function_name' => "2"
//    )
//));
//$logs->import(array(
//        'timestamp' => time() * 1000,
//        'file_name' => "index.php",
//        'function_name' => "1"
//));
//R::store($logs);
//R::dispense('log');

echo time() * 1000;
