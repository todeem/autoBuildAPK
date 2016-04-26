<?php

class action {
	public function get_show_msg($url,$img='0',$show = '操作已成功！', $msgtime='3') {
		//跳转url，图片样式，显示文字，页面默认跳转时间
		/*
	 * url：跳转页面
	 * img：图片显示类型，1：succeed，0:failed，default:0
	 * show：提示信息
	 */
		$img ? $img='smiley.png' : $img='weep.png';
		$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml"><head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="stylesheet" href="Public/common.css" type="text/css" />
				<meta http-equiv="refresh" content="' . $msgtime . '; url=' . $url . '" />
				<title>消息提示</title>
				</head>
				<body>
				<div id="man_zone">
				  <table width="36%" border="1" align="center"  cellpadding="3" cellspacing="0" class="table" style="margin-top:100px;">
				    <tr>
				     <th align="left" style="background:#cef"><img src="image/'.$img.'"  align="left" width="25" height="25"><font color="#FF0000"><b>  信息提示</b></font></th>
				    </tr>
				    <tr>
				      <td><p><font color="#006633" style="font-size:14px"><li>' . $show . '</li></font><br />
				      
				      <font color="#FF9900" style="font-size:14px">' . $msgtime . '秒后返回指定页面！<br />
				      如果浏览器无法跳转，</font><font style="font-size:14px"><a href="' . $url . '">请点击此处</a></font>。</p></td>
				    </tr>
				  </table>
				</div>
				</body>
				</html>';
		echo $msg;
		exit ();
	}
	//end class action
}

class user{
	public function get_user_login($posts){
		global $classActionInfo,$classaction;
		if($posts[submit]){
			$posts['code']=strtoupper($posts['code']);
			if($_SESSION['code']==$posts['code']){
				$username= str_replace(" ", "", $posts['username']);
				$sql="SELECT * FROM user_admin WHERE `username` = '$username'";
				$query=mysql_query($sql);
				$us = is_array($row=mysql_fetch_array($query));
				$uus = $us ? TRUE : FALSE;
				if($uus){
					$username=$row[username];
					$password=$posts[password];
					if(USELDAP){
						$Auth=$this->user_ldapAuth($username, $password);
					}else{
						$Auth=$this->user_mysqlAuth($username, $password);
					}
					if($Auth){
						$_SESSION[username]=$row[username];
						$_SESSION[uid]=$row[uid];
						$_SESSION[ugid]=$row[ugid];
						$_SESSION[mail]=$classActionInfo[mail];
						$_SESSION[displayname]=$classActionInfo[displayname];
						$_SESSION[user_shell]=md5($row[username].$_SESSION[mail].ALL_PS);
						$_SESSION[times]=mktime();
						$classaction->get_show_msg("source_list_id.php","1","登陆成功");
					}else
					$classaction->get_show_msg("index.php","0","登陆失败(用户名,密码错误)");
						
					exit ();
				}else{
					session_destroy();
					$classaction->get_show_msg("index.php","0","<font color=red><b>".$username."</b></font> - 不存在于登陆列表".print_r($row,true));
					exit ();
				}
			}else{
				session_destroy();
				$classaction->get_show_msg("index.php","0","验证码错误");

				exit ();
			}
		}
	}
	public function user_ldapAuth($username,$password){ //ldap验证
		global $ldaphost,$ldapport,$ldapbase,$classActionInfo;
		$ds=ldap_connect($ldaphost, $ldapport);
		$dn="cn=".$username.",ou=user,".$ldapbase;
		$sr = ldap_search( $ds , $ldapbase ,"cn=".$username);
		if($sr){
			$info = ldap_get_entries( $ds , $sr );
			//$info[0][mail][0] -- 是邮件地址
			if ($bind=@ldap_bind($ds, "$dn", "$password"))  {
				$classActionInfo[mail] = $info[0][mail][0];
				$classActionInfo[displayname] =  $info[0][displayname][0];
				return true;
				ldap_close( $ds );
			} else {
				//		return false;
				return false;
				session_destroy();
				ldap_close( $ds );
			}
		}else{
			return false;
			session_destroy();
			ldap_close( $ds );
			exit(0);
		}
	}
	public function user_mysqlAuth($username,$password){ //数据库验证
		global $classActionInfo;
		$password=md5($username.ALL_PS.$password);
		//		$password=md5($password);
		$sql=mysql_query("SELECT * FROM user_admin WHERE `username` = '$username' AND `password` = '$password'");
		$us = is_array($row=mysql_fetch_array($sql));
		$uus = $us ? TRUE : FALSE;
		if($uus){
			$classActionInfo[mail]=$row[email];
			$classActionInfo[displayname] =  $username;
			return true;
		} else {
			//		return false;
			session_destroy();
			return false;

		}
	}

	public function user_shell($uid,$shell,$gid,$onlinetime,$mail){
		/* 0：超级管理员权限
		 * 1：
		 * 2：提交文件
		 * 3：可以添加用户
		 * 4：可运行打包功能
		 * 5：可以切换到管理员界面查看
		 * 6：
		 * 7：
		 * 8：提交渠道号
		 * 9：仅仅查看
		 */
		global  $classaction;
		$row[ugid]=99999;

		$sql="SELECT * FROM `user_admin` WHERE `uid` = '$uid'";

		$query=mysql_query($sql);

		$us = is_array($row=mysql_fetch_array($query));
		$shell=$us ? $shell==md5($row[username].$mail.ALL_PS):FALSE;
		if($shell){

			if($row[ugid]<=$gid){
				$new_time = mktime();
				//echo $new_time-$onlinetime ;
				if($new_time-$onlinetime > OVERTIME){
					session_destroy();
					$classaction->get_show_msg("index.php?action=logout","0","<font color=red><b>恭喜，登陆超时啦！</b></font>");
				} else {
					$_SESSION[times]=mktime();
					return $row;
				}
			}else {
				$classaction->get_show_msg("adminindex.php","0","<font color=red><b>对不起，您的权限不具备访问此页面！</b></font>");
				exit();
			}
		}else{

			$classaction->get_show_msg("index.php","0","<font color=red><b>如果我没计算错，你应该还没登陆吧</b></font>......");
			session_destroy();
			exit();
		}

	}

	public function get_user_out(){
		global $classaction;
		session_destroy();
		$classaction->get_show_msg("index.php","1","已退出，请重新登陆！");
	}


	public function get_user_ontime($long = OVERTIME) {
		global $classaction;
		$new_time = mktime();
		$onlinetime = $_SESSION[times];
		//		echo $new_time - $onlinetime;
		if ($new_time - $onlinetime > $long) {
			session_destroy();
			$classaction->get_show_msg("index.php?action=logout","0","<font color=red><b>恭喜，登陆超时啦！</b></font>");
				
		} else {
			$_SESSION[times]=mktime();
			return $row;
		}
	}

	//	public function del_submit_msg($table,$s_id){ //根据序列号及自己相关信息才能 删除
	//		if($s_id=preg_match('/^\d*$/', $s_id)){
	//			$sql="DELETE FROM `$table` WHERE `source`.`s_id` = '$s_id' LIMIT 1";
	//			$query=mysql_query($sql);
	//			$query=mysql_fetch_array($query);
	//			return true;
	//		}else {
	//			return false;
	//		}
	//	}
	public function del_auth($table,$uid,$gid){
		global  $classaction;
		$rowd[ugid]=99999;
		$query=mysql_query("SELECT * FROM `user_admin` WHERE `uid` = '$uid'");
		$us = is_array($rowd=mysql_fetch_array($query));
		$shell=$us ? 1 : 0;
		if($shell){
			if($rowd[ugid]<$gid){
				return true;
			}else{
				return false;
			}
		}
	}
	}

	?>
	<?php
	$classuser=new user();
	$classaction=new action();

	?>
