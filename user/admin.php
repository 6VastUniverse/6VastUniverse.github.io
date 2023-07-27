<?php
require_once ("../library/libuser.php");
require_once ("../library/libui.php");
require_once ("../library/liboj.php");

function gen_opr_link($uid){
    return '<a href="admin.php?action=delete&uid='.(string)($uid) . '">Delete this User</a><br>' . 
    '<a href="admin.php?action=cpriv&uid='.(string)($uid) . '">Admin/DeAdmin</a>';
}

echo html_head("Administration");
echo html_navbar();

if (auth_cookie() && auth_admin(cookie_uid()))
    $aduid = cookie_uid();
else{
    echo '<div class="alert alert-danger">Permission Denied.</div>';
    exit("");
}

if (!isset($_GET["action"])){
echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="jumbotron">
				<h1>
					Welcome to '. get_oj_name() . '
				</h1>
				<p>
					' . get_oj_intr() . '
				</p>
				<p>
					 <a class="btn btn-primary btn-large" href="admin.php?action=ojinfo">Alter OJ Settings</a>
				</p>
			</div>
			<div class="row clearfix">
				<div class="col-md-4 column">
					<h3>
						User amount:' . get_oj_usrnum() . '
					</h3>
					<a class="btn btn-primary btn-danger" href="admin.php?action=cusr">Delete All Users</a>
				</div>
				<div class="col-md-4 column">
					<h3>
						Record amount:' . get_oj_recnum() . '
					</h3>
					<a class="btn btn-primary btn-danger" href="admin.php?action=crec">Delete All Records</a>
				</div>
				<div class="col-md-4 column">
					<h3>
						Blog amount:' . get_oj_blgnum() . '
					</h3>
					<a class="btn btn-primary btn-danger" href="admin.php?action=cblg">Delete All Blogs</a>
				</div>
			</div>
		</div>
	</div>
</div><br><br>';

echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="panel-group" id="panel-207182">';

$cu = 0;
exec("ls ./database",$arr);
foreach ($arr as $cur){
    $cu = (int)(strtok($cur,"."));
    echo '				<div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-207182" href="#panel-element-' . $cu . '">User #' . $cu . ':' . username_colored($cu) . '</a>
					</div>
					<div id="panel-element-' . $cu . '" class="panel-collapse collapse">
						<div class="panel-body">' . 
							 gen_opr_link($cu).
						'</div>
					</div>
				</div>';
				
	$cu = $cu + 1;
}

echo "</div></div></div></div>";
echo html_tail();
}else{
    if ($_GET["action"] == "delete"){
        system('rm database/' . $_GET["uid"] . '.json');
        header("location:admin.php");
    }elseif ($_GET["action"] == "cpriv"){
        if (get_user_priv((int)($_GET["uid"])) == "user")
            set_user_priv((int)($_GET["uid"]),"admin");
        else
            set_user_priv((int)($_GET["uid"]),"user");
        
        header("location:admin.php");
    }elseif ($_GET["action"] == "crec"){
        clear_record();
        header("location:admin.php");
    }elseif ($_GET["action"] == "cusr"){
        clear_users();
        header("location:admin.php");
    }elseif ($_GET["action"] == "cblg"){
        clear_blog();
        header("location:admin.php");
    }elseif ($_GET["action"] == "ojinfo"){
        echo '<form action="admin.php" method="get">';
        echo "Receipt:<input type=\"text\" name=\"action\" value=\"ojinfo_alt\" readonly=\"readonly\"><br>";
        echo 'OJ Name:<input type="text" name="name" value="' . get_oj_name() . '"><br>';
        echo 'About:<input type="text" name="about" value="' . get_oj_intr() . '"><br>';
        echo 'Registration Status(1:enable,0:disable)<br>:<input type="text" name="regstat" value="' . get_oj_regstat() . '"><br>';
        echo '<button type="submit">Alter</button></form>';
    }elseif ($_GET["action"] == "ojinfo_alt"){
        //echo $_GET["name"];echo $_GET["about"]; echo $_GET["regstat"];
        set_oj_name($_GET["name"]);
        set_oj_intr($_GET["about"]);
        set_oj_regstat($_GET["regstat"]);
        header("location:admin.php");
    }

}
