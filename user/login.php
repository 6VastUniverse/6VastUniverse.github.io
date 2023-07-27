<?php
require_once ("../library/libuser.php");
require_once ("../library/libui.php");
if (!isset($_GET["logout"]) && !isset($_POST["uid"])){
    echo html_head("User Login");
    echo html_navbar();
    echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
		    <h3>User Login</h3>
			<form role="form" action="login.php" method="post">
				<div class="form-group">
					 <label for="uid">User ID</label>
					<input type="text" class="form-control" name="uid" />
				</div>
				<div class="form-group">
					 <label for="passwd">Password</label>
					<input type="password" class="form-control" name="passwd" />
				</div>
				<button type="submit" class="btn btn-primary">Login</button>
			</form>
			<a href="register.php">
				<button type="button" class="btn">Donot have an account?</button>
			</a>
		</div>
	</div>
</div>';
    echo html_tail();
}else{
$uid = $_POST["uid"];
$passwd = $_POST["passwd"];

//echo $_SERVER["HTTP_REFERER"];
if (isset($_GET["logout"])){
    $expire=time()-2*60*60*24*30;
    setcookie("uid", "", $expire,'/');
    setcookie("passwd","",$expire,'/');
    header("Location:login.php");
}elseif (auth_user($uid,$passwd)){
    echo "<h1>Hello " . get_user_name($uid) . "</h1>";
    $expire=time()+60*60*24*30;
    setcookie("uid", $uid, $expire,'/');
    setcookie("passwd",$passwd,$expire,'/');
    header("Location:show.php");
}else{
    echo "<h1>Bad Login!</h1>";
}
}