<?php
//be called like 'require ("./library/prbinfo.php");'
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
function get_prb_info($pid){
    //echo BASE_PATH . "problems/" . (string)($pid) . "/attrib.json";
    $file = fopen(BASE_PATH . "../problems/" . (string)($pid) . "/attrib.json","r");
    $attr = fgets($file);
    return json_decode($attr,true);
}

function get_prb_name($pid){
    $pinfo = get_prb_info($pid);
    //echo $pinfo["name"];
    return $pinfo["name"];
}

function get_prb_time_limit($pid){
    $pinfo = get_prb_info($pid);
    return $pinfo["time_limit"];
}

?>