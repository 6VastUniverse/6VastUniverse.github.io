<?php
require_once("../library/liblog.php");
require_once("../library/libui.php");

if (isset($_GET["bid"])){
    $bid = $_GET["bid"];
    echo html_head("Reading Blog - " . get_blog_title($bid));
    echo html_navbar();
    echo blog_frame($bid);
}else{
    echo html_head("All Blogs");
    echo html_navbar();
    echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="panel-group" id="panel-890604">';
			
	exec("ls -t ./content",$arr);
	
	foreach ($arr as $cur){
	   $cu = strtok($cur,"."); 
	   echo '<div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-890604" href="#panel-element-' . $cu . '">Blog #' . $cu . ':' . get_blog_title($cu) . '</a>
					</div>
					<div id="panel-element-' . $cu . '" class="panel-collapse collapse">
						<div class="panel-body"> 
							 <a href="edit.php?bid=' . $cu . '">Original Link</a>' . 
							 get_blog_content($cu) . '
						</div>
					</div>
				</div>';
			}

}

echo html_tail();
