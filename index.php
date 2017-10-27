<?php

define("APP_DIR", dirname(__FILE__));
require_once(APP_DIR.'/config.php');

try {
     $db = new PDO("mysql:dbname=".$CONFIG['db']['name'].";host=".$CONFIG['db']['host']."", $CONFIG['db']['username'], $CONFIG['db']['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    error_log($e->getMessage());
}


function db_query($sql, $params=array()) {
    global $db;

    $results = array();

    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage().', SQL '.$sql);
    }
    return $results;
}


function db_get_by($table_name, $by_field, $field_value) {
    return db_query("SELECT * FROM $table_name WHERE $by_field = '$field_value'");
}


function db_get($table_name, $id) {
    return db_get_by($table_name, 'id', $id);
}


function db_execute($sql, $params=array()) {
    global $db;
    
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
    } catch (PDOException $e){
        error_log($e->getMessage().', SQL '.$sql);
    }
}


function db_insert($table_name, $data) {
    global $db;

    $placeholders = array();
    $columns = array();
    $values = array();
    $param_pos = 1;

    foreach($data as $col=>$val) {
        $placeholders[] = '?';
        $columns[] = $col;
        $values[] = $val;
    }

    $cols = implode(', ', $columns);
    $params = implode(', ', $placeholders);

    try {
        $sql = "INSERT INTO $table_name ($cols) VALUES ($params)";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
    } catch (PDOException $e){
        error_log($e->getMessage().', SQL '.$sql);
    }

    return $db->lastInsertId();
}


function db_update($table_name, $record_id, $data, $id_col = 'id') {
    global $db;

    $set_values = array();

    foreach($data as $col=>$val) {
        $set_values[] = " $col = '$val' ";
    }

    $set_val_str = implode(', ', $set_values);

    db_execute("UPDATE $table_name SET $set_val_str WHERE $id_col = '$record_id'");

    return $db->lastInsertId();
}


function guid(){
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);// "}"
        return $uuid;
    }
}


if(!isset($_GET['a'])) {
    $_GET['a'] = 'find_bus_times';
}

$page_name = $_GET['a'];
$uses_template = $_GET['a'].'.php';

require_once(APP_DIR.'/actions/'.$_GET['a'].'.php');

if($uses_template) {
    require_once(APP_DIR.'/templates/'.$uses_template);
}