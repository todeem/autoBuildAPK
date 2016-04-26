<?php
session_start();
error_reporting(E_ALL); 
//error_reporting(0); 
ini_set('display_errors', '0'); 
include('conf/config.php');
include_once('class/class.action.php');
include_once('class/class.mysql.php');
include_once('class/class.page.php');
$db = new mysql(DB_HOST, DB_USER, DB_PASSWORD, DB_DATA, '', MYDBCHARSET);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>渠道后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link type=text/css rel=stylesheet  href="common.css">
<META content="MSHTML 6.00.6000.16890" name=GENERATOR>
 <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/js/js.js" ></script>
<script type="text/javascript" src="/js/jquery.tablesorter.min.js" ></script>
</HEAD>
<body>
<div id="toolTipLayer" style="position:absolute; visibility: hidden"></div>
<!--<script>initToolTips()</script>-->

<?php 
//require_once('function.php');
$headerwhite1='<div class="headerwhite" ><b><a href="source_list_id.php" >首页</a> || <a href="submit_source.php" >提交渠道号</a> || <a href="showsourceid.php" title="每次请重新传包，仅刷新不会清空" >查看渠道号</a> || <a href="search.php" >搜索</a></b>';
if( $_SESSION['user_shell'] <> ''){
	//$msgout = '<a onClick="return confirm("提示：您确定要退出系统吗？")" href="submit_source.php?action=logout"  target=_parent>退出</a>';	
$msgout = '<a href="javascript:linkok(\'index.php?action=logout\',\'提示：您确定要退出系统吗？\')">退出</a>';
if($_SESSION['ugid'] <= 5){
	$adminMang = "<a href=\"/admin/adminindex.php\">管理面板</a>";
}else{
	$adminMang = "<a href=\"/index.php\">用户面板</a>";
}
$tuichu='<div class="tuiChu"><img  src="image/user.gif" width="15"  height="15" > 帐号：  ' . $_SESSION[displayname] . '  ，' . $adminMang . ' ' . $msgout . ' </div></div>';
}else {
	$tuichu = "";
	$headerwhite1 = "";
}
if($_GET[action]=='logout')
{
$classuser->get_user_out();
}
echo $headerwhite1.$tuichu;

?>


