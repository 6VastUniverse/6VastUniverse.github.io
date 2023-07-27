<?php
require_once ("../library/libuser.php");
require_once ("../library/libui.php");
require_once ("../library/liboj.php");

if (!get_oj_regstat()) exit("Register Disabled!");
elseif (!isset($_POST["name"]) || !isset($_POST["passwd"])){
    echo html_head("Registration");
    echo html_navbar();
    echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3>User Register</h3>
			<form role="form" action="register.php" method="post">
				<div class="form-group">
					 <label for="uid">User Name</label>
					<input type="text" class="form-control" name="name" />
				</div>
				<div class="form-group">
					 <label for="passwd">Password</label>
					<input type="password" class="form-control" name="passwd" />
				</div>
				<button type="submit" class="btn btn-primary">Register</button>
			</form>
			<a href="login.php">
				<button type="button" class="btn">Have an account?</button>
			</a>
		</div>
	</div>
</div>';
    echo html_tail();
}else{

$name = $_POST["name"];
$passwd = $_POST["passwd"];

echo "Your UID is " . create_user($name,$passwd);
echo "<br><a href-\"login.php\">Login</a>";
}