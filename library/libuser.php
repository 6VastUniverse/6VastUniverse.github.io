<?php
define('WWWROOT',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
function pass_enc($pass){
    $eps = $pass;
    $times = 10;$i=1;
    while ($i <= $times){
        $i = $i+1;
        $eps = crypt($eps,$eps);
    }
    
    return $eps;
}

function get_user_info($uid){
    //echo BASE_PATH . "problems/" . (string)($pid) . "/attrib.json";
    $file = fopen(WWWROOT . "../user/database/" . (string)($uid) . ".json","r");
    $attr = fgets($file);
    fclose($file);
    return json_decode($attr,true);
}

function set_user_info($uid,$pinfo){
    //echo BASE_PATH . "problems/" . (string)($pid) . "/attrib.json";
    $file = fopen(WWWROOT . "../user/database/" . (string)($uid) . ".json","w+");
    fwrite($file,json_encode($pinfo));
    fclose($file);
}

function get_user_name($uid){
    $pinfo = get_user_info($uid);
    //echo $pinfo["name"];
    return $pinfo["name"];
}

function get_user_passwd($uid){
    $pinfo = get_user_info($uid);
    return $pinfo["passwd"];
}

function get_user_intr($uid){
    $pinfo = get_user_info($uid);
    return $pinfo["intr"];
}

function get_user_record($uid){
    $pinfo = get_user_info($uid);
    return json_decode($pinfo["record"],true);
}

function get_user_priv($uid){
    $pinfo = get_user_info($uid);
    return $pinfo["priv"];
}

function get_user_rank($uid){
    $pinfo = get_user_info($uid);
    return $pinfo["intr"];
}

function set_user_name($uid,$name){
    $pinfo = get_user_info($uid);
    $pinfo["name"] = $name;
    set_user_info($uid,$pinfo);
}

function set_user_passwd($uid,$passwd){
    $pinfo = get_user_info($uid);
    $pinfo["passwd"] = pass_enc($passwd);
    set_user_info($uid,$pinfo);
}

function set_user_intr($uid,$intr){
    $pinfo = get_user_info($uid);
    $pinfo["intr"] = $intr;
    set_user_info($uid,$pinfo);
}

function set_user_priv($uid,$priv){
    $pinfo = get_user_info($uid);
    $pinfo["priv"] = $priv;
    set_user_info($uid,$pinfo);
}

function set_user_record($uid,$record){
    $pinfo = get_user_info($uid);
    $arr = json_decode($pinfo["record"],true);
    array_push($arr,$record);
    $arr = array_unique($arr);
    $pinfo["record"] = json_encode($arr);
    set_user_info($uid,$pinfo);
}

function set_user_rank($uid,$rank){
    $pinfo = get_user_info($uid);
    $pinfo["rank"] = (string)((int)($pinfo["rank"]) + $rank);
    set_user_info($uid,$pinfo);
}

function auth_user($uid,$passwd){
    if ($uid == 0) return false;
    if (get_user_passwd($uid) == pass_enc($passwd))
        return true;
    else
        return false;
}

function create_user($name,$passwd){
    $cuid = 1;
    while (file_exists(WWWROOT . "../user/database/" . (string)($cuid) . ".json"))
        $cuid = $cuid + 1;
    
    if ($cuid == 1) $priv = "admin"; else $priv="user";
    $file = fopen(WWWROOT . "../user/database/" . (string)($cuid) . ".json","w+");
    $pinfo = array("name"=>$name,"passwd"=>pass_enc($passwd),"record"=>"{}","priv"=>$priv,"rank"=>"1500",intr=>"This user is very lazy so that he didn't leave anything.");
    fwrite($file,json_encode($pinfo));
    fclose($file);
    return $cuid;
}

function cookie_uid(){
    if (!isset($_COOKIE["uid"])) return -1;
    else return $_COOKIE["uid"];
}

function cookie_passwd(){
    if (!isset($_COOKIE["uid"])) return -1;
    else return $_COOKIE["passwd"];
}

function auth_cookie(){
    //echo cookie_uid() . '  ' . cookie_passwd();
    return auth_user(cookie_uid(),cookie_passwd());
    //echo $blk;
}

function auth_admin($uid){
    return (get_user_priv($uid) == "admin");
}