<?php
require_once ("../library/libuser.php");
require_once ("../library/libui.php");

if (!auth_cookie()) header("location:/user/login.html");

$uid = cookie_uid();

if (isset($_POST["nname"])){
    //Modify Username
    set_user_name($uid,$_POST["nname"]);
    header("location:dashboard.html");
}elseif (isset($_POST["npasswd"])){
    //Modify Passwd
    set_user_passwd($uid,$_POST["npasswd"]);
    header("location:dashboard.html");
}elseif (isset($_POST["nintr"])){
    //Modify Introduction
    set_user_intr($uid,$_POST["nintr"]);
    header("location:show.php");
}else{
    echo html_head("Settings");
    echo html_navbar();
    echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-4 column">
			<h3>Reset Username</h3>
			<form role="form" action="dashboard.php" method="post">
				<div class="form-group">
					 <label for="nname">New Username</label>
					<input type="text" class="form-control" name="nname" />
				</div>
				<button type="submit" class="btn btn-primary">Done</button>
			</form>
		</div>
		<div class="col-md-4 column">
			<h3>Reset Password</h3>
			<form role="form" action="dashboard.php" method="post">
				<div class="form-group">
					 <label for="npasswd">New Password</label>
					<input type="password" class="form-control" name="npasswd" />
				</div>
				<button type="submit" class="btn btn-primary">Done</button>
			</form> 
		</div>
		<div class="col-md-4 column">
			<h3>Reset Introduction</h3>
			<form role="form" action="dashboard.php" method="post">
				<div class="form-group">
					 <label for="nintr">New Introduction</label>
					<textarea class="form-control" rows="5" name="nintr"></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Done</button>
			</form>
		</div>
	</div>
</div>';
echo html_tail();
}

