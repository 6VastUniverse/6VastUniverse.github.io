<?php
require_once ("../library/libuser.php");
require_once ("../library/libui.php");

if (isset($_GET["uid"])){
    $uid = $_GET["uid"];

}else if (auth_cookie()){
    $uid = cookie_uid();
}else{
    header('location:' . "login.html");
}

echo html_head("User Information - " . username_colored($uid));
echo html_navbar();

echo "<div class=\"container\"><div class=\"row clearfix\"><div class=\"col-md-12 column\"><div class=\"jumbotron\">";
echo "<h1>Hello,". get_user_name($uid)  ."</h1>";
echo "<p>" . get_user_intr($uid) . "</p>";
if (auth_admin($uid))
    echo '<a href="admin.php" class="btn btn-primary btn-lg" role="button">Administration</a>';
echo "</div><table class=\"table table-hover\"><caption>Submitting Record</caption><thead>";
echo "<tr><th>ID</th><th>Problem ID</th></tr></thead><tbody>";
$cj = 0;
foreach (get_user_record($uid) as $cur){
    $cj = $cj + 1;
    echo "<tr class=\"active\"><td>" . (string)($cj) . "</td><td>" . $cur . "</td></tr>";
    //echo $cur . "     ";
}

echo "</tbody></table></div></div></div>";

echo html_tail();
