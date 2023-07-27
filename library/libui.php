<?php
define('UIR',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
require_once(UIR . "/liboj.php");
require_once(UIR . "/libuser.php");

function username_colored($uid){
    $rank = get_user_rank($uid);
    if (get_user_priv($uid) == "admin")
        return "<font color=\"#660099\"><strong>" .get_user_name($uid) ."</strong></font><span>[Admin]</span>";
    elseif ($rank <= 1600)
        return "<font color=\"#3399FF\"><strong>" .get_user_name($uid) ."</strong></font>";
    elseif ($rank >1600 && $rank <= 1700)
        return "<font color=\"#33CC66\"><strong>" .get_user_name($uid) ."</strong></font>";
    elseif ($rank >1700 && $rank <= 1800)
        return "<font color=\"#FF9933\"><strong>" .get_user_name($uid) ."</strong></font>";
    else
        return "<font color=\"#FF0000\"><strong>" .get_user_name($uid) ."</strong></font>";
}

function pick_navright(){
    if (auth_cookie())
        return username_colored(cookie_uid());
    else
        return "User";
}

function html_head($title){
    return  '<html><head>
	<meta charset="utf-8"> 
	<title>' . $title  . '</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head><body>';
}

function html_navbar(){
    return '<nav class="navbar navbar-default" role="navigation">
   <div class="container-fluid">
    <div class="navbar-header">
     <a class="navbar-brand" href="/index.php">' . get_oj_name() . '</a>
    </div>
    <div>
     <ul class="nav navbar-nav">
      <li><a href="/problemset.php">Problemset</a></li>
      <li><a href="/submit.php">Submit</a></li>
      <li><a href="/status.php">Status</a></li>
     </ul>
    </div>
    <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
			 <a href="#" class="dropdown-toggle" data-toggle="dropdown">' . pick_navright() . '<strong class="caret"></strong></a>
				<ul class="dropdown-menu">
				        <li>
							 <a href="/blog/edit.php">Blog</a>
						</li>
					   <li>
						  <a href="/user/dashboard.php">Dashboard</a>
					   </li>
						<li>
							<a href="/user/login.php">Login</a>
						</li>
						<li>
							 <a href="/user/register.php">Register</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="/user/login.php?logout=true">Logout</a>
						</li>
					</ul>
		</li>
	</ul>
   </div>
  </nav>';
}

function html_tail(){
    return '</body></html>';
}
