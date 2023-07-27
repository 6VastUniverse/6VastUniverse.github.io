<?php
require ("judge.php");
require ("../library/prbinfo.php");

function judge($code,$path,$t_l){
  unlink ("data.in");
  unlink ("judge.cpp");

  $file = fopen("judge.cpp","w+") or exit("Unable to Open CPP.");
  fwrite($file,$code);
  fclose($file);

  if (!is_file($path)) exit("Bad Problem ID!");

  copy($path,"./data.in");

  return Do_judge($t_l);
}

$code = $_POST["code"];
$pid = $_POST["pid"];

$curj = 1;
$p_fnt = "../problems/" . $pid . "/";

while (is_file($p_fnt . "data" . (string)($curj) . ".in")){
  echo "<h3>Test Case #" . (string)($curj) . ":</h3>";
  $j_stat = judge($code,$p_fnt . "data" . (string)($curj) . ".in",(int)(get_prb_time_limit($pid)));
  if ($j_stat == 0){
    echo "<h3 style=\"background-color:#4169E1\">TLE</h3>";
  }elseif ($j_stat == -1){
    echo "<h3 style=\"background-color:#FF4500\">CE</h3>";
  }elseif ($j_stat == 1){
    $file1 = md5_file("./data.out");
    $file2 = md5_file($p_fnt . "data" . (string)($curj) . ".out");
  
    if ($file1 == $file2)
       echo "<h3 style=\"background-color:#00FF00\">AC</h3>";
    else
       echo "<h3 style=\"background-color:#FF4500\">WA</h3>";
  }
  echo "</h3>";
  $curj = $curj + 1;
}

?>
