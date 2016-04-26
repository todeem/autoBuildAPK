<?php

class action {
	public function get_show_msg($url,$img='0',$show = '操作已成功！', $msgtime='3',$http='') { //跳转url，图片样式，显示文字，页面默认跳转时间
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
	//	public function get_user_login($_POST){
	//		global $classActionInfo,$classaction;
	//		if($_POST[submit]){
	//			$_POST['code']=strtoupper($_POST['code']);
	//			if($_SESSION['code']==$_POST['code']){
	//				$username= str_replace(" ", "", $_POST[username]);
	//				$sql="SELECT * FROM user_admin WHERE `username` = '$username'";
	//				$query=mysql_query($sql);
	//				$us = is_array($row=mysql_fetch_array($query));
	//				//				print_r($row);
	//				$uus = $us ? TRUE : FALSE;
	//				if($uus){
	//					$username=$row[username];
	//					$password=$_POST[password];
	//					if($this->user_ldapAuth($username, $password)){
	//						$_SESSION[username]=$row[username];
	//						$_SESSION[uid]=$row[uid];
	//						$_SESSION[mail]=$classActionInfo;
	//						$_SESSION[user_shell]=md5($row[username].$_SESSION[mail].ALL_PS);
	//						$_SESSION[times]=mktime();
	//						$classaction->get_show_msg("source_list_id.php","1","登陆成功");
	//					}else
	//					$classaction->get_show_msg("index.php","0","登陆失败(用户名,密码错误)");
	//					session_destroy();
	//					exit ();
	//				}else{
	//					$classaction->get_show_msg("index.php","0","<font color=red><b>".$username."</b></font> - 不存在于登陆列表)");
	//					session_destroy();
	//					exit ();
	//				}
	//			}else{
	//				$classaction->get_show_msg("index.php","0","验证码错误");
	//				session_destroy();
	//				exit ();
	//			}
	//		}
	//	}
	//	public function user_ldapAuth($username,$password){ //ldap验证
	//		global $ldaphost,$ldapport,$ldapbase,$classActionInfo;
	//		$ds=ldap_connect($ldaphost, $ldapport);
	//		$dn="cn=".$username.",ou=user,".$ldapbase;
	//		$sr = ldap_search( $ds , $ldapbase ,"cn=".$username);
	//		if($sr){
	//			$info = ldap_get_entries( $ds , $sr );
	//			//$info[0][mail][0] -- 是邮件地址
	//			if ($bind=@ldap_bind($ds, "$dn", "$password"))  {
	//				$classActionInfo = $info[0][mail][0];
	//				return true;
	//				ldap_close( $ds );
	//			} else {
	//				//		return false;
	//				return false;
	//				session_destroy();
	//				ldap_close( $ds );
	//			}
	//		}else{
	//			return false;
	//			session_destroy();
	//			ldap_close( $ds );
	//			exit(0);
	//		}
	//	}
	//	public function user_ldapAuth($username,$password){ //数据库验证
	//		global $classActionInfo;
	//		$password=md5($password);
	//		$sql=mysql_query("SELECT * FROM user_admin WHERE `username` = '$username' AND `password` = '$password'");
	//		$us = is_array($row=mysql_fetch_array($sql));
	//		$uus = $us ? TRUE : FALSE;
	//		if($uus){
	//				return true;
	//			} else {
	//				//		return false;
	//				return false;
	//				session_destroy();
	//			}
	//	}

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
		global  $classaction_m;
		$row[ugid]=99999;

		$sql="SELECT * FROM `user_admin` WHERE `uid` = '$uid'";

		$query=mysql_query($sql);

		$us = is_array($row=mysql_fetch_array($query));
		$shell=$us ? $shell==md5($row['username'].$mail.ALL_PS):FALSE;
		if($shell){

			if($row['ugid']<=$gid){
				$new_time = mktime();
				//echo $new_time-$onlinetime ;
				if($new_time-$onlinetime > OVERTIME){
					session_destroy();
					$classaction_m->get_show_msg("../index.php?action=logout","0","<font color=red><b>恭喜，登陆超时啦！</b></font>");
				} else {
					$_SESSION[times]=mktime();
					return $row;
				}
			}else {
				$classaction_m->get_show_msg("adminindex.php","0","<font color=red><b>对不起，您的权限不具备访问此页面！</b></font>");
				exit();
			}
		}else{

			$classaction_m->get_show_msg("../index.php","0","<font color=red><b>如果我没计算错，你应该还没登陆吧</b></font>......");
			session_destroy();
			exit();
		}

	}

	public function get_user_out(){
		global $classaction_m;
		session_destroy();
		$classaction_m->get_show_msg("../index.php","1","已退出，请重新登陆！");
	}


	public function get_user_ontime($long = OVERTIME) {
		global $classaction_m;
		$new_time = mktime();
		$onlinetime = $_SESSION[times];
		//		echo $new_time - $onlinetime;
		if ($new_time - $onlinetime > $long) {
			$classaction_m->get_show_msg("../index.php?action=logout","0","<font color=red><b>恭喜，登陆超时啦！</b></font>");
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
	public  function add_user($username,$mail,$permission){
		global $administrator;
		$passwd = substr(md5(time()), 0, 8);
		$password=md5($username.ALL_PS.$passwd);
		$query=@mysql_query("INSERT INTO `user_admin` (`uid` ,`password` ,`username` ,`email` ,`ugid`)
		VALUES (NULL ,  '$password',  '$username',  '$mail',  '$permission' ) ");
		if(!mysql_error()){
			$this->sendMail("$administrator[mail]", "渠道新用户添加成功提醒", "User added successfully ~ <br>User:".$username."<br>Mail:".$mail."<br>Permission:".$permission);
			if (USELDAP){
			    $body='您好，'.$username.':<br />您的渠道帐号已经开通，请使用您的Jira帐号密码登陆到此服务。<br >';
			    $body.='访问地址：'.$administrator[site].'<br /><i>如未开通过Jira帐号，请申请<br>';
			    $body.= $administrator[site].$administrator[apply].'</i><br />如有其他问题，请email联系：'.$administrator[mail];
			}else{
                $body= '您好，'.$username.':<br />您的渠道帐号已经开通：<br >';
                $body.= '访问地址：'.$administrator[site].'<br />';
                $body.= '<i>帐号：'.$username.'<br>随机密码：'.$passwd.'</i><br />';
                $body.= '如有其他问题，请email联系：'.$administrator[mail];
                @file_put_contents("../error/mima", $username.':'.$passwd,FILE_APPEND);
			}
			$this->sendMail("$mail", "渠道打包帐号已开通", "$body");
			return true;
		}
		return false;
	}
	public function sendMail($address,$subject,$body){
		/*$address:地址
		 *$subject:标题
		 *$body:内容
		 */
		global $administrator;
		$mmail = new PHPMailer();     //得到一个PHPMailer实例
		$mmail->CharSet = $administrator[charset]; //'设置采用gb2312中文编码
		$mmail->IsSMTP();                    //设置采用SMTP方式发送邮件
		$mmail->Host = $administrator[smtphost];    //设置邮件服务器的地址
		$mmail->Port = $administrator[port];                           //设置邮件服务器的端口，默认为25
		$mmail->From     = $administrator[fromadds]; //设置发件人的邮箱地址
		$mmail->FromName = $administrator[fromname];                       //设置发件人的姓名
		$mmail->SMTPAuth = false;                                    //设置SMTP是否需要密码验证，true表示需要
		$mmail->Username= $administrator[name];
		$mmail->Password = $administrator[password];
		$mmail->Subject = $subject;                                 //设置邮件的标题
		$mmail->AltBody = "text/html";                                // optional, comment out and test
		$mmail->Body = $body;
		$mmail->IsHTML(true);                                        //设置内容是否为html类型
		//$mail->WordWrap = 50;                                 //设置每行的字符数
		$mmail->AddReplyTo(" $address","$name");     //设置回复的收件人的地址
		$mmail->AddAddress(" $address","$name");     //设置收件的地址
		if(!$mmail->Send()) {                    //发送邮件
			@file_put_contents("../error/running.mail.error", $dt." - error | 发送到".$address."失败 \r\n",FILE_APPEND);
		}


	}
	public function del_auth($table,$uid,$gid){
		global  $classaction_m;
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
	public function characterJudge($character,$judge='0'){
		/* @judge - default:0数字,1:字母,2:字母加数字
		 * 		  - 3:数字字母+点,4:字母+点,5:字母数字+@+点
		 */

		$character = trim($character);
		if($judge=='0'){
			$_regular="/^[\d]+$/i";
		}
		if($judge=='1'){
			$_regular="/^[a-z]+$/i";
		}
		if($judge=='2'){
			$_regular="/^[a-zA-Z0-9]+$/i";
		}
		if($judge=='3'){
			$_regular="/^[a-zA-Z0-9\.]+$/i";
		}
		if($judge=='4'){
			$_regular="/^[a-zA-Z\.]+$/i";
		}
		if($judge=='5'){
			$_regular="/^[a-zA-Z0-9@\.]+$/i";
		}
		if(!preg_match($_regular, $character,$arr)){
			return FALSE;
		}else {
			return true;
		}
	}
	}
	class file {
		public function mkdirFile($filepath,$id,$umask){
			$t=time();
			$dt=date("Y-m-d H:i:s",$t);
			if(!file_exists("$filepath/$id")){
				if(is_writable("$filepath")){
					mkdir("$filepath/$id",octdec($umask));//octdec处理0777此类
					$r=array("0","成功创建文件夹".$filepath.$id);
					return $r;
				}else{
					$r=array("1","文件夹路径不可写");
					file_put_contents("../error/running.button.error", $dt." - error | 运行时class.file->mkdirFile ".$r[1]."\r\n",FILE_APPEND);
					return  $r;
				}
			}else{
				$r=array("1","文件夹已存在");
				file_put_contents("../error/running.button.error", $dt." - error | 运行时class.file->mkdirFile ".$r[1]."\r\n",FILE_APPEND);
				return  $r;
			}

		}

	}
	class upload {
		private $percentage;//上传进度
		public function uploadFile($name,$tempName,$size,$type,$error){
			/* $_count:统计个数
			 *
			 *
			 *
			 */
			global $classaction_m;

			$uploadfile=UPFILEPATH; //上传apk及写入source id 的路径
			if (is_writable($uploadfile)) {
				switch ($error){
					case "0": $errormsg="上传成功";
					break;
					case "1": $errormsg="不超过服务器端文件大小限制";
					break;
					case "2": $errormsg="不超过客户端文件大小限制";
					break;
					case "3": $errormsg="全部上传了";
					break;
					case "4": $errormsg="有文件上传";
					break;
					case "6": $errormsg="找不到临时文件夹";
					break;
					case "7": $errormsg="文件写入临时文件夹失败 ";
					break;
					case "10": $errormsg="不允许上传该类型文件";
					break;
				}
				if (is_uploaded_file($tempName)){
					$nameExtension=substr(strrchr($name,"."),1);//获取文件扩展名
					$nameExtension=strtolower($nameExtension);
					if ( stristr(UPFILETYPE,$nameExtension) && $error=="0" && $size <= UPFILESIZE){
						if (!file_exists($uploadfile)){
							mkdir($uploadfile);
						}
						if (!file_exists($uploadfile.$name)){
							move_uploaded_file($tempName,"$uploadfile$name");
							$msg=array("0","已成功提交！".$name);
							return $msg;
						}else{
							$msg=array("1",$errormsg."/服务器已存在相同数据！");
							return $msg;
						}
					}else{
						$msg=array("1",$errormsg."/上传错误错误码".$errormsg."或文件大小不符合！");
						return $msg;
					}
				}else{
					$msg=array("1",$errormsg."/临时文件".$tempName."不存在！");
					return $msg;
				}
			}else {
				$msg=array("1",$errormsg."/目录".$uploadfile."不可写!");
				return $msg;
			}
		}
		function progressBar($percentage) {
			$data = "<div id=\"progress-bar\" class=\"all-rounded\">\n";
			$data .= "<div id=\"progress-bar-percentage\" class=\"all-rounded\" style=\"width: $percentage%\">";
			$data .= "$percentage%";
			$data .= "</div></div>";
			return $data;
		}

	}
	?>
<?php 
$classuser_m = new user();
$classaction_m = new action();
$classuploadfile=new upload();
$classfile = new file();
?>