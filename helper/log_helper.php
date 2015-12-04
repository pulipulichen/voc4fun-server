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

if (function_exists("find_name") === FALSE) {
    function find_name($uuid) {
        
    }
}

// ----------------------------------------------

// 先建立必要的表格
// CREATE VIEW uuid_name AS SELECT l1.uuid, l1.data AS name FROM log AS l1, (SELECT uuid, max(timestamp) AS timestamp FROM log WHERE file_name = 'controller_profile.js' AND function_name = 'change_user_name()' GROUP BY uuid) AS l2 WHERE l1.uuid = l2.uuid AND l1.timestamp = l2.timestamp

$views = array(
    "uuid_name" => "CREATE VIEW uuid_name AS 
SELECT l1.uuid, trim(both '\"' from l1.data) AS name 
FROM log AS l1, (SELECT uuid, max(timestamp) AS timestamp FROM log WHERE file_name = 'controller_profile.js' AND function_name = 'change_user_name()' 
GROUP BY uuid) AS l2 
WHERE l1.uuid = l2.uuid AND l1.timestamp = l2.timestamp",
    "note" => "CREATE VIEW note AS 
SELECT l1.uuid, name, l1.qualifier AS q, l1.data::JSON->>'note' AS note, l1.timestamp 
FROM log AS l1 JOIN uuid_name USING(uuid), (SELECT uuid, max(timestamp) AS timestamp, qualifier FROM log WHERE file_name = 'controller_note.js' AND function_name = 'submit()' GROUP BY uuid, qualifier) AS l2
WHERE l1.uuid = l2.uuid AND l1.timestamp = l2.timestamp ORDER BY l1.timestamp DESC"
);

$exists = R::getRow("
SELECT EXISTS(
    SELECT * 
    FROM information_schema.tables 
    WHERE 
      table_schema = 'public' AND 
      table_name = 'uuid_name'
);");

if ($exists["exists"] === false) {
    //echo "1";
    foreach ($views AS $sql) {
        //echo $sql;
        R::exec($sql);
    }
}