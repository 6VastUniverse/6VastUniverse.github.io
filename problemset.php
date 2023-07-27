<?php
require_once ("./library/prbinfo.php");
require_once ("./library/libui.php");

exec("ls ./problems",$prbs);
$cur = "";

echo html_head("Problemset");
echo html_navbar();

echo "<table class=\"table\"><caption>ProblemSet</caption>";
echo "<thead><tr><th>Problem ID</th><th>Name</th></tr></thead><tbody>";

foreach ($prbs as $cur){
  echo "<tr class=\"active\"><td>" . $cur . "</td><td><a href=\"show.php?pid=" . $cur . "\">" . get_prb_name((int)($cur)) . "</a></td></tr>";
}

echo "</tbody></table>";
echo html_tail();