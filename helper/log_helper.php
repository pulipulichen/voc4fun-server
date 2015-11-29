<?php
if (function_exists("add_log") === false) {
    function add_log($opt) {
        if (is_array($opt) === FALSE || isset($opt["uuid"]) === FALSE) {
            return;
        } 
        
        $log = R::dispense("log");
        $log->uuid = $opt["uuid"];
        $log->timestamp = get_javascript_time();
        
        if (isset($opt["file_name"])) {
            $log->file_name = $opt["file_name"];
        }
        if (isset($opt["function_name"])) {
            $log->function_name = $opt["function_name"];
        }
        if (isset($opt["qualifier"])) {
            $log->qualifier = $opt["qualifier"];
        }
        if (isset($opt["data"])) {
            $log->data = json_encode($opt["data"], JSON_UNESCAPED_UNICODE);
        }
        
        R::store($log);
    }
}
