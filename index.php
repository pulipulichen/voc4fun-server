<?php
/**
 * 連線方式 http://localhost/voc4fun/voc4fun-server/
 */

include_once 'config.php';
include_once 'helper/javascript_helper.php';

include_once 'lib/redbeanphp/rb.config.php';

$log = R::dispense('log');
$log->timestamp = time() * 1000;
$log->file_name = "index.php";
$log->function_name = null;
$log->qualifier = null;
$log->data = json_encode(array("key" => "value2"));

R::store($log);

echo time() * 1000;
