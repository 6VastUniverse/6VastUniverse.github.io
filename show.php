<?php
require_once ("./library/prbinfo.php");
require_once ("./library/liblog.php");
require_once ("./library/libui.php");

$probid = $_GET["pid"];
echo html_head("ProblemShow - " . get_prb_name($probid));
echo html_navbar();

if (isset($_GET["wiki"])){
    $arr = get_prb_wiki($probid);
    foreach ($arr as $cur){
        echo blog_frame($cur); 
    }
}else{
$cover = "./problems/" . $probid . "/cover.html";

if (!is_file($cover)) exit("Bad Problem ID!");

$file = fopen($cover,"r") or exit("Bad Cover!");

echo '<div class="container"><div class="row clearfix"><div class="col-md-9 column">';
while (!feof($file)){
  echo fgets($file);
}
fclose($file);
echo '</div><div class="col-md-3 column">';
echo "<h5>Problem id: " . (string)$probid . " </h5>";
echo "<h4>Name: " . get_prb_name($probid) . " </h4>";
echo "<h4>Time Limit: " . get_prb_time_limit($probid) . " seconds</h4>";
echo "<a href=\"submit.php?pid=" . $probid . "\"><button class=\"btn btn-primary\">Submit</button></a>      ";
echo "<a href=\"show.php?pid=" . $probid . "&wiki=true\"><button class=\"btn btn-primary\">Solution</button></a>";
echo '</div></div></div>';





echo "</div></div></div>";
}
echo html_tail();
?>