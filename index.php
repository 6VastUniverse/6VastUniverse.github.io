<?php
require_once("library/libui.php");
require_once("library/liboj.php");
require_once("library/liblog.php");

if (isset($_GET["sentence"])){
    launch_benben($_GET["sentence"]);
    header("location:index.php");
    exit("");
}

if (isset($_GET["cben"])){
    if (!auth_cookie() || !auth_admin(cookie_uid())) {
        header("location:/user/login.php");
        exit("");
    }

    clear_benben();
    header("location:index.php");
    exit("");
}

echo html_head("Welcome!");
echo '<script>
        function launch_benben(){
            document.location="index.php?sentence=" + document.getElementById("sentence").value;
        }
        </script>';
echo html_navbar();

echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="carousel slide" id="carousel-530998">
				<ol class="carousel-indicators">
					<li data-slide-to="0" data-target="#carousel-530998">
					</li>
					<li data-slide-to="1" data-target="#carousel-530998" class="active">
					</li>
					<li data-slide-to="2" data-target="#carousel-530998">
					</li>
				</ol>
				<div class="carousel-inner">
					<div class="item">
						<img alt="" src="https://i.loli.net/2019/02/13/5c6405686ae3a.jpg" />
						<div class="carousel-caption">
						</div>
					</div>
					<div class="item active">
						<img alt="" src="https://i.loli.net/2019/02/13/5c6405686ae3a.jpg" />
						<div class="carousel-caption">
						</div>
					</div>
					<div class="item">
						<img alt="" src="https://i.loli.net/2019/02/13/5c640568ac6f2.jpeg" />
						<div class="carousel-caption">
						</div>
					</div>
				</div> <a class="left carousel-control" href="#carousel-530998" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-530998" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
			<div class="panel-group" id="panel-173516">
				<div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title" data-toggle="collapse" data-parent="#panel-173516" href="#panel-element-633412">About FreeOJ</a>
					</div>
					<div id="panel-element-633412" class="panel-collapse in">
						<div class="panel-body">
							' . get_oj_intr() . '
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-173516" href="#panel-element-469779">Official Website</a>
					</div>
					<div id="panel-element-469779" class="panel-collapse collapse">
						<div class="panel-body">
							<a href="' . $_SERVER['SERVER_NAME'] . '">' . $_SERVER['SERVER_NAME'] . '</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';
echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column"><h1>BenBen</h1>';
echo get_blog_content("benben");
echo 'Launch Benben<input id="sentence" />';
echo '<button type="button" class="btn btn-primary" onclick="launch_benben()">Launch BenBen!</button>';
if (auth_cookie() && auth_admin(cookie_uid())) echo '<a href="index.php?cben=true"><button type="button" class="btn btn-danger">Clear BenBen</button></a>';
echo html_tail();