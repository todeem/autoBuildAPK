<?php 
session_start();
include('../conf/config.php');
include_once('../admin/class/class.action.admin.php');
include_once('../class/class.mysql.php');
include_once("../class/class.phpmailer.php");
$db = new mysql(DB_HOST, DB_USER, DB_PASSWORD, DB_DATA, '', MYDBCHARSET);
$arr=$classuser_m->user_shell($_SESSION[uid], $_SESSION[user_shell],3,$_SESSION[times],$_SESSION[mail]);
if(!isset($_POST[submit])){
	$username=trim($_POST[addname]);

	$mail=trim($_POST[addmail]);
	$permission=trim($_POST[permission]);
	if($classuser_m->add_user($username,$mail,$permission)){
		$classaction_m->get_show_msg("adduser.php","1","添加用户".$username."成功");
	}
}else{
	$classaction_m->get_show_msg("adduser.php","0","添加用户".$username."失败");
	exit(0);
}
?>