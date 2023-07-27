<?php
require_once ("../library/liblog.php");
require_once ("../library/libui.php");
require_once ("../library/libuser.php");

echo html_head("Edit your blog!");
if (!auth_cookie()){
    header("location:/user/login.html");
}else 
    $uid = cookie_uid();

if (isset($_POST["bid"])){
    $bid = $_POST["bid"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    if (blog_exists($bid) && get_blog_uid($bid) != cookie_uid()){
        //echo (string)(get_blog_uid($bid)) . '&&' . (string)(cookie_uid());
        echo '<div class="alert alert-danger">Permission Denied.</div>';
        exit("");
    }
    
    alloc_blog($bid);
    set_blog_time($bid,date("Y-m-d H:i:s"));
    set_blog_title($bid,$title);
    set_blog_content($bid,$content);
    header("location:show.php?bid=" . $bid);
}elseif (isset($_GET["bid"])){
    if (isset($_GET["pid"])){
        //exit($_GET["pid"] . "****** " .$_GET["bid"]);
        set_prb_wiki($_GET["pid"],$_GET["bid"]);
        header("location:edit.php");
    }if ($_GET["bid"] == "NEW"){
        $bid = find_idle_bid();
    }elseif (isset($_GET["delete"])){
        delete_blog($_GET["bid"]);
        header("location:edit.php");
    }else{
        $bid = $_GET["bid"];
    }

    echo html_navbar();
    echo '<div class="container" >
           <div class="row clearfix">
	         <div class="col-md-12 column">
		         <form role="form" action="edit.php" method="post">
			        <div class="form-group">
				       <label for="bid">Blog ID</label>
				       <input type="text" class="form-control" name="bid" value = "' . $bid . '">
			        </div>
			         <div class="form-group">
				       <label for="title">Title</label>
				       <input type="text" class="form-control" name="title" value = "' . htmlentities(get_blog_title($bid)) . '">
			        </div>
			        <div class="form-group">
				       <label for="content">Content(In HTML):</label>
				       <textarea class="form-control" rows="15" name="content">'. htmlentities(get_blog_content($bid)) .'</textarea>
			        </div>
			        <button type="submit" class="btn btn-default">Publish</button>
		         </form>
	          </div>
	        </div>
          </div>';
}else{
    echo html_navbar();
    echo '<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
		  <a class="btn btn-block btn-primary btn-lg" href="edit.php?bid=NEW" role="button">New Blog</a>
			<div class="panel-group" id="panel-260817">';
	
	exec("ls -tr content/",$arr);
	foreach ($arr as $cur){
	    $cu = strtok($cur,".");
	    if (get_blog_uid($cu) == cookie_uid()){
	        echo '				<div class="panel panel-default">
					<div class="panel-heading">
						 <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-260817" href="#panel-element-' . $cu . '">Blog #' . $cu  . ':' . get_blog_title($cu) . '</a>
					</div>
					<div id="panel-element-' . $cu . '" class="panel-collapse collapse">
						<div class="panel-body"> 
						     <script>
                                function Subwiki(){
	                                   document.location="edit.php?bid=' . $cu . '&pid=" + document.getElementById("pid").value;
                                }
                             </script>
						     <a href="show.php?bid=' . $cu .'">Preview</a><br />
							 <a href="edit.php?bid=' . $cu .'">Edit</a><br />
							 ProblemID:<input id="pid" />
							 <button type="button" class="btn btn-primary" onclick="Subwiki()">Submit to Wiki</button><br / >
							 <a href="edit.php?bid=' . $cu .'&delete=true">Delete</a><br />
						</div>
					</div>
				</div>';
	    }
	}
}


