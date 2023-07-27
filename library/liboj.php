<?php
define('OJROOT',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
function get_oj_info(){
    $file = fopen(OJROOT . "../ojcfg.json","r");
    $attr = fgets($file);
    fclose($file);
    return json_decode($attr,true);
}

function set_oj_info($arr){
    $file = fopen(OJROOT . "../ojcfg.json","w+");
    fwrite($file,json_encode($arr));
    fclose($file);
}

function get_oj_regstat(){
    $pinfo = get_oj_info();
    //exit($pinfo["enable_register"]);
    return $pinfo["enable_register"] == "true";
}

function clear_users(){
    system("rm " . OJROOT . "../user/database/*");
}

function clear_record(){
    system("rm " . OJROOT . "../record/*");
}

function clear_blog(){
    system("rm " . OJROOT . "../blog/content/[0-9]*.json");
}

function get_oj_name(){
    $pinfo = get_oj_info();
    return $pinfo["name"];
}

function get_oj_intr(){
    $pinfo = get_oj_info();
    return $pinfo["about"];
}

function get_oj_usrnum(){
    exec("ls ../user/database",$arr);
    return count($arr);
}

function get_oj_recnum(){
    exec("ls ../record",$arr);
    return count($arr);
}

function get_oj_blgnum(){
    exec("ls ../blog/content",$arr);
    return count($arr);
}

function set_oj_name($name){
    $pinfo = get_oj_info();
    $pinfo["name"] = $name;
    set_oj_info($pinfo);
}

function set_oj_intr($intr){
    $pinfo = get_oj_info();
    $pinfo["about"] = $intr;
    set_oj_info($pinfo);
}
function set_oj_regstat($name){
    $pinfo = get_oj_info();
    if ($pinfo["enable_register"] == "true")
        $pinfo["enable_register"] = "false";
    else
        $pinfo["enable_register"] = "true";
        
    set_oj_info($pinfo);
}
