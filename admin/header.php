<?php
session_start();
include('../conf/config.php');
include_once('../admin/class/class.action.admin.php');
include_once('../class/class.mysql.php');
include_once('../class/class.page.php');
$db = new mysql(DB_HOST, DB_USER, DB_PASSWORD, DB_DATA, '', MYDBCHARSET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>渠道后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<!--<link type=text/css rel=stylesheet  href="../common.css">-->
<link type=text/css rel=stylesheet  href="admin.css">
<META content="MSHTML 6.00.6000.16890" name=GENERATOR>
 <script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/admin.js" ></script>
<script type="text/javascript" src="../js/jquery.tablesorter.min.js" ></script>
</HEAD>
<body>
<!--<div id="toolTipLayer" style="position:absolute; visibility: hidden"></div>-->
<!--<script>initToolTips()</script>-->

<?php 

//require_once('function.php');
$headerwhite1='<div class="headdivline" ><div style="clear:both;"></div><b><a href="adminindex.php" >首页</a> || <a href="upfile.php" >上传渠道包</a> || <a href="adduser.php" >添加用户</a></b>';
if($_SESSION[user_shell]<>''){
	//$msgout = '<a onClick="return confirm("提示：您确定要退出系统吗？")" href="submit_source.php?action=logout"  target=_parent>退出</a>';	
$msgout = '<a href="javascript:linkok(\'../index.php?action=logout\',\'提示：您确定要退出系统吗？\')">退出</a>';
	$adminMang = "<a href=\"../index.php\">用户面板</a>";
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

