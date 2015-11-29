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
include_once '../helper/javascript_helper.php';
include_once '../lib/redbeanphp/rb.config.php';

if (isset($_GET) && count($_GET) > 0) {
    // 查詢模式
    
    // http://localhost/voc4fun/voc4fun-server/model/sync.php?uuid=1&timestamp=1448797722000
    
    if (isset($_GET["uuid"]) && isset($_GET["timestamp"])) {
        $uuid = intval($_GET["uuid"]);        
        $device_timestamp = intval($_GET["timestamp"]);
    }
    else {
        exit();
    }
    
    $log = R::getRow( 'SELECT timestamp FROM log '
            . 'WHERE uuid = ? AND timestamp > ? LIMIT 1 '
            . 'AND file_name = ? AND function_name = ?', [$uuid, $device_timestamp, "sync.php", "snyc_complete()"] );
    
    if (count($log) === 0) {
        // push 模式 part 1: 送出server上最新的timestamp，等待手機回傳資料
        $log = R::getRow( 'SELECT timestamp FROM log WHERE uuid = ? ORDER BY timestamp DESC LIMIT 1', [$uuid, $device_timestamp] );
        if (count($log) > 0) {
            $timestamp = $log[0]->timestamp;
            jsonp_callback($timestamp);
        }
        else {
            jsonp_callback(0);
        }
        exit();
    }
    else {
        // pull 模式: 直接回傳所有資料
        
        $last_sync_timestamp = $log[0]->timestamp;
        $logs = R::getRow( 'SELECT * FROM log WHERE uuid = ? AND timestamp > ? ORDER BY timestamp ASC', [$uuid, $last_sync_timestamp] );
        json_callback($logs);
        exit();
    }
}
else if (isset($_POST) && count($_POST) > 0) {
    // push 模式 part 2：從手機上傳送資料給伺服器
    if (isset($_POST["logs"]) && isset($_POST["uuid"])) {
        $uuid = intval($_POST["uuid"]);
        $logs_ary = json_decode($_POST["logs"]);
    }
    else {
        exit();
    }
    
    $log_beans = R::dispense("log", count($logs_ary));
    foreach ($logs_ary AS $i => $log) {
        $log_beans[$i]->import($log);
        $log_beans[$i]->uuid = $uuid;
    }
    R::storeAll($log_beans);
}

