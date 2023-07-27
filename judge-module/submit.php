<?php
require ("./judge.php");
$code = $_POST["code"];
$pid = $_POST["pid"];

unlink("./submit.html");
unlink("./unused");
Result($code,$pid);

set_user_record(cookie_uid(),$pid);

unlink("./submit.php");
header('location:' . dirname($_SERVER["PHP_SELF"]) . "/result.html");
?>
