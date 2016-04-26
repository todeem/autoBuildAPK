<?php
$url_query="http://12313.com/index.php?page=2&page=2&page=2";
$page=2;
echo $url_query=preg_replace("/([^|&]page=$page)/","",$url_query); 


