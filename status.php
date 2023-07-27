<?php
require_once ("./library/libui.php");
require_once ("./library/filesys.php");

echo html_head("Online Status");
echo html_navbar();

echo "<table class=\"table\"><caption>Status</caption>";
echo "<thead><tr><th>Run ID</th><th>Status</th><th>Detail</th></tr></thead><tbody>";
exec("ls ./record",$stl);
//"<tr class=\"warning\"><td>All</td><td>CE</td></tr>"
foreach ($stl as $cur){
    $cr = strtok($cur,'.');
    //echo $cur . "<br>";
    //if (file_exists("./submissions/" . $cur . "/unused"))
        //echo "<tr class=\"warning\"><td>" . $cur . "</td><td>Submitting/Judgement Failed</td>" . "<td><a href=\"submissions/" . $cur . "/result.html\">More</a></td></tr>";
    /*else*/if (!(strpos(dmp_file("./record/" . $cur),"<td>CE</td>") === false)){
        echo "<tr class=\"warning\"><td>" . $cr . "</td><td>CE</td>" . "<td><a href=\"record/" . $cur . "\">More</a></td></tr>";
    }elseif (!(strpos(dmp_file("./record/" . $cur),"<td>WA</td>") === false)){
        echo "<tr class=\"danger\"><td>" . $cr . "</td><td>WA</td>" . "<td><a href=\"record/" . $cur . "\">More</a></td></tr>";
    }elseif (!(strpos(dmp_file("./record/" . $cur),"<td>TLE</td>") === false)){
        echo "<tr class=\"info\"><td>" . $cr . "</td><td>TLE</td>" . "<td><a href=\"record/" . $cur . "\">More</a></td></tr>";
    }else
        echo "<tr class=\"success\"><td>" . $cr . "</td><td>AC</td>" . "<td><a href=\"record/" . $cur . "\">More</a></td></tr>";
}

echo "</tbody></table>";
echo html_tail();
