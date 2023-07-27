<?php
function dmp_file($path){
    //exit($path);
    $file = fopen($path,"r");
    $rt = "";
    while (!feof($file)) $rt = $rt .  fgets($file);
    fclose($file);
    //exit($rt);
    return $rt;
}

?>
