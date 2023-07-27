<?php
define('BLROOT',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
require_once(BLROOT . "/libuser.php");

function blog_exists($bid){
    return file_exists(BLROOT . "../blog/content/" . $bid . ".json");
}
function find_idle_bid(){
    $bid = 1;
    while (file_exists(BLROOT . "../blog/content/" . $bid . ".json"))
        $bid = $bid + 1;
    
    return $bid;
}

function delete_blog($bid){
    system("rm " . BLROOT . "../blog/content/" . $bid . ".json");
}
function alloc_blog($bid){
    if (blog_exists($bid)) return;
    $file = fopen(BLROOT . "../blog/content/" . $bid . ".json","w+");
    fwrite($file,'{"uid":"' . cookie_uid() . '","time":"' . date("Y-m-d H:i:s") . '","title":"QAQ","content":"Enter your content here..."}');
    fclose($file);
    return $bid;
}
function get_blog_info($bid){
    if (!blog_exists($bid)) return;
    $file = fopen(BLROOT . "../blog/content/" . $bid . ".json","r");
    $attr = fgets($file);
    fclose($file);
    return json_decode($attr,true);
}

function set_blog_info($bid,$arr){
    $file = fopen(BLROOT . "../blog/content/" . $bid . ".json","w+");
    fwrite($file,json_encode($arr));
    fclose($file);
}

function get_blog_uid($bid){
    $pinfo = get_blog_info($bid);
    return $pinfo["uid"];
}

function get_blog_title($bid){
    $pinfo = get_blog_info($bid);
    return $pinfo["title"];
}

function get_blog_time($bid){
    $pinfo = get_blog_info($bid);
    return $pinfo["time"];
}

function get_blog_content($bid){
    $pinfo = get_blog_info($bid);
    return $pinfo["content"];
}

function set_blog_uid($bid,$uid){
    $pinfo = get_blog_info($bid);
    $pinfo["uid"] = $uid;
    set_blog_info($bid,$pinfo);
}

function set_blog_title($bid,$title){
    $pinfo = get_blog_info($bid);
    $pinfo["title"] = $title;
    set_blog_info($bid,$pinfo);
}

function set_blog_time($bid,$time){
    $pinfo = get_blog_info($bid);
    $pinfo["time"] = $time;
    set_blog_info($bid,$pinfo);
}

function set_blog_content($bid,$cont){
    $pinfo = get_blog_info($bid);
    $pinfo["content"] = $cont;
    set_blog_info($bid,$pinfo);
}

function get_wiki_info(){
    $file = fopen(BLROOT . "../blog/wiki.json","r");
    $attr = fgets($file);
    fclose($file);
    return json_decode($attr,true);
}

function set_wiki_info($arr){
    $file = fopen(BLROOT . "../blog/wiki.json","w+");
    fwrite($file,json_encode($arr));
    fclose($file);
}

function get_prb_wiki($pid){
    $pinfo = get_wiki_info();
    return json_decode($pinfo[$pid]);
}

function set_prb_wiki($pid,$bid){
    $pinfo = get_wiki_info();
    $arr = json_decode($pinfo[$pid]);
    if ($arr === NULL) $arr=array();
    
    array_push($arr,$bid);
    $arr = array_unique($arr);
    $pinfo[$pid] = json_encode($arr);
    set_wiki_info($pinfo);
}

function blog_frame($bid){
    echo '<div class="panel panel-default">
	<div class="panel-body">
		'. get_blog_content($bid) . '
	</div>
	<div class="panel-footer">' . username_colored(get_blog_uid($bid)) . ',' . get_blog_time($bid) . '</div>
    </div>';
}

function benben_frame($sentence){
    //if (!auth_cookie()) return;
    return '<div class="panel panel-default">
	<div class="panel-body">
		'. $sentence . '
	</div>
	<div class="panel-footer">' . username_colored(cookie_uid()) . ',' . date("Y-m-d H:i:s") . '</div>
    </div>';
}

function launch_benben($sentence){
    if (!auth_cookie()) return;
    $rst = get_blog_content("benben") . benben_frame(htmlentities($sentence));
    //exit($rst); 
    set_blog_content("benben", $rst);
}

function clear_benben(){
    set_blog_content("benben", benben_frame(htmlentities("Welcome to BenBen!")));
}