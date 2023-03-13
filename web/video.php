<?php
set_time_limit ( 0 );
ini_set("memory_limit","-1");
header("Content-Type: video/mp4");
if (!empty($_GET["url"])) {
    $url = $_GET["url"];
    $arr = get_headers($url, true);
    header("content-length:" . $arr["Content-Length"]);
    readfile($url);
}
?>