<?php
function Do_judge($time_limit){
  unlink ("judge");
  unlink ("data.out");
  system("g++ judge.cpp -O2 -o judge");
  if (!file_exists("judge")){
    return -1;
  }else{
    $return_var = 0;
    system("timeout " . (string)($time_limit) . " ./judge < data.in > data.out",$return_var);
    if ($return_var == 124) return 0; else return 1;
  }

}
?>