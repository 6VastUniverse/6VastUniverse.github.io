<?php
require ("./library/filesys.php");
require ("./library/libuser.php");
require ("./library/prbinfo.php");
require ("./library/libui.php");

function detect_rid(){
    $crid = 1;
    while (file_exists("record/R" . $crid . ".html")) $crid  = $crid+1;
    return "R" . $crid;
}

function judge($code,$path,$t_l,$j_path){
  unlink ($j_path . "/data.in");
  if (!is_file($path)) exit("Bad Problem ID!");
  copy($path,$j_path . "/data.in");
  unlink ($j_path . "/data.out");
  
  $return_var = 0;
  system("timeout " . (string)($t_l) . " " . $j_path . "/judge < " . $j_path ."/data.in > " . $j_path . "/data.out",$return_var);
  if ($return_var == 124) return 0; else return 1;
}

function Result($code,$pid,$j_path,$rid){
	$fsub=fopen("record/" . $rid . ".html","w+") or exit("Unable to open result.html!");
	fwrite($fsub,html_head("Result of Submittion by " . get_user_name(cookie_uid())));
	fwrite($fsub,html_navbar());
	
	fwrite($fsub,'<div class="jumbotron"><pre>');
	fwrite($fsub,htmlentities($code) . "</pre></div>" );
	
	fwrite($fsub,"<table class=\"table\"><caption>Submission by ". get_user_name(cookie_uid()) ."</caption>");
	fwrite($fsub,"<thead><tr><th>Case No.</th><th>Status</th></tr></thead><tbody>");
	
	$file = fopen($j_path . "/judge.cpp","w+") or exit("Unable to Open CPP.");
	fwrite($file,$code);
    fclose($file);
    
	exec("timeout 7 g++ "  . $j_path . "/judge.cpp -O2 -o " . $j_path . "/judge",$cot);

	if (!file_exists($j_path . "/judge")){
	    fwrite($fsub,"<tr class=\"warning\"><td>All</td><td>CE</td></tr>");
	    system("rm -rf ". $j_path);
	    return;
	}
	
    $curj = 1;$accepted = true;
    $p_fnt = "./problems/" . $pid . "/";
    while (is_file($p_fnt . "data" . (string)($curj) . ".in")){
        $j_stat = judge($code,$p_fnt . "data" . (string)($curj) . ".in",(int)(get_prb_time_limit($pid)),$j_path);
        if ($j_stat == 0){
            fwrite($fsub,"<tr class=\"info\"><td>#" . (string)($curj) . "</td><td>TLE</td></tr>");
            $accepted = false;
        }elseif ($j_stat == 1){
            $file1 = md5_file($j_path . "/data.out");
            $file2 = md5_file($p_fnt . "data" . (string)($curj) . ".out");
  
            if ($file1 == $file2)
                fwrite($fsub,"<tr class=\"success\"><td>#" . (string)($curj) . "</td><td>AC</td></tr>");
            else{
                fwrite($fsub,"<tr class=\"danger\"><td>#" . (string)($curj) . "</td><td>WA</td></tr>");
                $accepted = false;
            }
        }
        $curj = $curj + 1;
    }
    fwrite($fsub,"</tbody></table>");
    fwrite($fsub,html_tail());
    fclose($fsub);
    
    system("rm -rf ". $j_path);
    return $accepted;
}

//if (!isset($_POST["code"]) || !isset($_POST["pid"])) {
//    header("location:submit.html");
//    exit("");
//}

if (isset($_POST["code"])){
$code = $_POST["code"];
$pid = $_POST["pid"];

if (!auth_cookie())
        header('location:' . "user/login.html");
else{
    $rid = detect_rid();
    $j_path = "submissions/" . $rid;
    mkdir($j_path);
    
    if (Result($code,$pid,$j_path,$rid)) {
        set_user_record(cookie_uid(),$pid,$rid);
        set_user_rank(cookie_uid(),2);
    }

    header("location:record/" . $rid . ".html");
}
}else{
    echo html_head("Submit your Code");
    echo html_navbar();
    if (isset($_GET["pid"])) $pid = $_GET["pid"]; else $pid = "";
    
    echo '<div class="container" >
	<div class="row clearfix">
		<div class="col-md-12 column">
			<form role="form" action="submit.php" method="post">
				<div class="form-group">
					 <label for="pid">Problem ID</label>
					 <input type="text" class="form-control" name="pid" value="' . $pid . '" placeholder="Problem ID to submit">
				</div>
				<div class="form-group">
					 <label for="code">Your Code</label>
					<textarea class="form-control" rows="15" name="code"></textarea>
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</div>
</div>';
}
?>
