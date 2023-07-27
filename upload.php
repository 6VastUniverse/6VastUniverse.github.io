<?php
require_once("library/libui.php");

if (isset($_POST["pid"])){ //有数据
    $pkg_url = $_POST["pkg_url"];
    $pid = $_POST["pid"];
    $name = $_POST["name"];
    $time_limit = $_POST{"time_limit"};
    $cover = $_POST["cover"];

    $pr_dir = "problems/" . $pid;
    mkdir($pr_dir);
    mkdir($pr_dir . "/data");//建文件夹

    $attr = fopen($pr_dir . "/attrib.json","w+");
    fwrite($attr,"{\"name\":\"" . $name . "\",\"time_limit\":" . $time_limit . ",\"cover\":\"" . $cover . "\"}");
    fclose($attr);//写入attrib.json

    system ("wget " . $pkg_url . " -O temp/" . $pid . ".zip");//下载数据
    system ("unzip temp/" . $pid . ".zip -d " . $pr_dir . "/data");//解压数据
    header("location:show.php?pid=" . $pid);
}else{
    echo html_head("Upload a problem.");
    if (!auth_cookie() || !auth_admin(cookie_uid())) exit("You aren't an admin!");//不是管理员
    else{
        echo html_navbar();
        echo '<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <h3>Upload your problem</h3>
            <form role="form" action="upload.php" method="post">
                <div class="form-group">
                     <label for="pkg_url">Data Package Url(ZIP format)</label>
                    <input type="text" class="form-control" name="pkg_url" />
                </div>
                <div class="form-group">
                     <label for="pid">Problem ID</label>
                    <input type="text" class="form-control" name="pid" />
                </div>
                <div class="form-group">
                     <label for="name">Problem Name</label>
                    <input type="text" class="form-control" name="name" />
                </div>
                <div class="form-group">
                     <label for="time_limit">Time Limit</label>
                    <input type="text" class="form-control" name="time_limit" />
                </div>
                <div class="form-group">
                     <label for="cover">Problem Cover</label>
                    <textarea class="form-control" name="cover" rows="15"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>';
    echo html_tail();
    }
}