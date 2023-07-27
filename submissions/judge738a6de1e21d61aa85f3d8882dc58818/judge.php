<?php
require ("../../library/prbinfo.php");

function judge($code,$path,$t_l){
  unlink ("data.in");
  if (!is_file($path)) exit("Bad Problem ID!");
  copy($path,"./data.in");
  unlink ("data.out");
  
  $return_var = 0;
  system("timeout " . (string)($t_l) . " ./judge < data.in > data.out",$return_var);
  if ($return_var == 124) return 0; else return 1;
}

function Result($code,$pid){
	$fsub=fopen("result.html","w+") or exit("Unable to open result.html!");
	
	unlink ("judge.cpp");unlink("judge");
	fwrite($fsub,"Time limit is " . get_prb_time_limit($pid));
	//fwrite($fsub,"<h3>Compiling...</h3>");
	
	$file = fopen("judge.cpp","w+") or exit("Unable to Open CPP.");
	fwrite($file,$code);
    fclose($file);
    
	exec("g++ judge.cpp -O2 -o judge",$cot);
	//fwrite($fsub,"<h3>Compile information:</h3>");
	//foreach ($cot as $cur){
	  //  fwrite($fsub,$cur . "<br>");
	//}
	if (!file_exists("judge")){
	    fwrite($fsub,"<h3 style=\"background-color:#FF4500\">CE</h3>");
	    return;
	}
	
    $curj = 1;
    $p_fnt = "../../problems/" . $pid . "/";
    while (is_file($p_fnt . "data" . (string)($curj) . ".in")){
        fwrite($fsub,"<h3>Test Case #" . (string)($curj) . ":</h3>");
        $j_stat = judge($code,$p_fnt . "data" . (string)($curj) . ".in",(int)(get_prb_time_limit($pid)));
        if ($j_stat == 0){
            fwrite($fsub,"<h3 style=\"background-color:#4169E1\">TLE</h3>");
        }elseif ($j_stat == 1){
            $file1 = md5_file("./data.out");
            $file2 = md5_file($p_fnt . "data" . (string)($curj) . ".out");
  
            if ($file1 == $file2)
                fwrite($fsub,"<h3 style=\"background-color:#00FF00\">AC</h3>");
            else
                fwrite($fsub,"<h3 style=\"background-color:#FF4500\">WA</h3>");
        }
        $curj = $curj + 1;
    }
    
    fclose($fsub);
    //unlink ("judge");
    //unlink ("data.in");
    //unlink ("data.out");
    //unlink ("judge.php");
}
?>