<?php
include('../conf/config.php');
include_once('../admin/class/class.action.admin.php');
include_once('../class/class.mysql.php');
?>
<?php
$db = new mysql(DB_HOST, DB_USER, DB_PASSWORD, DB_DATA, '', MYDBCHARSET);
$t=time();
$dt=date("Y-m-d H:i:s",$t);
if(isset($_POST)){
	/*提交页面jquery请求数据*/
	if($_POST[b]=='3'){
		$sql=mysql_query("select p_name,p_venv from platform  order by p_venv asc");
		echo "<option value=\"-1\">请选此包对应环境</option>";
		while ($prow=mysql_fetch_array($sql)){

			echo "<option value=\"$prow[p_venv]\">$prow[p_name]</option>";
		}
	}
	if($_POST[p]=='1'){
		$sql=mysql_query("select p_name,p_venv from platform  order by p_venv asc");
		echo "<option value=\"-1\">请选此包对应环境</option>";
		while ($prow=mysql_fetch_array($sql)){

			echo "<option value=\"$prow[p_venv]\">$prow[p_name]</option>";
		}
	}
	if($_POST[t]=='2'){
		$sqlt=mysql_query("select f_name,f_venv from function order by f_venv asc");
		echo "<option value=\"-1\">请选此包对应功能</option>";
		while ($frow=mysql_fetch_array($sqlt)){
			echo "<option value=\"$frow[f_venv]\">$frow[f_name]</option>";
		}
	}
	/*提交页面jquery请求数据,结束*/
	if(isset($_POST[SID])){
		if($classuser_m->characterJudge($_POST[SID],0)){
			$_sid=trim($_POST[SID]);
			$_progress_file_path="../progress/".$_sid.".progress";
			$_progress_directory="../progressDirectory/";
			$_progress_directory_path="$_progress_directory/$_sid";
			if(!is_writable(dirname($_progress_file_path)) || !is_writable($_progress_directory)){
				file_put_contents("error/running.button.error",$dt." - error | ".dirname($_progress_file_path)."或者".$_progress_directory."文件夹不可写或不存在\r\n",FILE_APPEND);
				exit(112);
			}else{
				if(file_exists($_progress_file_path) && (file_exists($_progress_directory_path))){
					file_put_contents("error/running.button.error",$dt." - warn | ".$_progress_file_path."文件已存在，请查看程序逻辑\r\n",FILE_APPEND);
					exit(114);
				}else{
					$sql="select * from source where s_id='$_sid'";
					$query=mysql_query($sql);
					$yn = is_array($row=mysql_fetch_array($query));
					$tf = $yn ? TRUE :FALSE;
					if($tf){
						$vsql=mysql_query("select v_packname,client_platform from version where v_id='$row[v_id]'");
						$vRow=mysql_fetch_array($vsql);
						if($rt[0]==0){
							include('class/class.ftp.php');
							$ftp=new ftp(FTP_HOST,FTP_PORT,FTP_USER,FTP_PASSWD);
							if($b=$ftp->ftp_createdir($_sid)){
								$ftpadds='ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/'.$_sid;
								$ftphref='<a href='.$ftpadds.' target=_blank>'.$ftpadds.'</a>';
								$mailbody=$G_head.$ftphref.$G_foot;
								file_put_contents($_progress_file_path, "如果一直可以看到此提示信息，说明打包程序在排队或出现错误！");
								$rt=$classfile->mkdirFile("$_progress_directory","$_sid","755");
								file_put_contents("$_progress_directory_path/$_sid.source", $row[s_value]);
								exec("../shell/makeRun.sh $_sid $vRow[v_packname] $vRow[client_platform] $row[mail] & ",$results,$ret);
								include("../class/class.phpmailer.php");
								$address="$row[mail]";
								$addresscc="$row[u_mailcc]";
								$subject="渠道通知";
								//$ftpupdate=$ftpadds."<br>".$aount."如有问题，请email联系：".$administrator[mail];
								$ftpupdate="$mailbody";
								mysql_query("update source set ftp='$ftpupdate' where s_id='$_sid'");
								$err=mysql_error();
								if($err){
									file_put_contents("error/running.button.error", $dt." - error | ".$err." 提交信息 \r\n".$mailbody."\r\n",FILE_APPEND);
								}
								$mail = new PHPMailer();     //得到一个PHPMailer实例
								$mail->CharSet = $administrator[charset]; //'设置采用gb2312中文编码
								$mail->IsSMTP();                    //设置采用SMTP方式发送邮件
								$mail->Host = $administrator[smtphost];    //设置邮件服务器的地址
								$mail->Port = $administrator[port];                           //设置邮件服务器的端口，默认为25
								$mail->From     = $administrator[fromadds]; //设置发件人的邮箱地址
								$mail->FromName = $administrator[fromname];                       //设置发件人的姓名
								$mail->SMTPAuth = false;                                    //设置SMTP是否需要密码验证，true表示需要
								$mail->Username=$administrator[name];
								$mail->Password = $administrator[password];
								$mail->Subject = $subject;                                 //设置邮件的标题
								$mail->AltBody = "text/html";                                // optional, comment out and test
								$mail->Body = $mailbody;
								$mail->IsHTML(true);                                        //设置内容是否为html类型
								//$mail->WordWrap = 50;                                 //设置每行的字符数
								$mail->AddReplyTo(" $address","");     //设置回复的收件人的地址
								$mail->AddAddress(" $address","");     //设置收件的地址
								if(!$mail->Send()) {                    //发送邮件
									file_put_contents("error/running.mail.error", $dt." - error | 发送给失败".$address."\r\n",FILE_APPEND);
								}
//								$mail->AddAddress(" $addresscc","");     //设置收件的地址
//								if(!$mail->Send()) {                    //发送邮件
//									file_put_contents("error/running.mail.error", $dt." - error | 发送给失败 ".$addresscc."\r\n",FILE_APPEND);
//								}
							}else{
								file_put_contents("error/running.button.error", $dt." - error | FTP文件夹创建出错 \r\n",FILE_APPEND);
							}
						}else{

						}


					}else{
						file_put_contents("error/running.button.error", $dt." - error | SID=".$_sid.",未查到数据,返回一个非数组 \r\n",FILE_APPEND);
					}

				}
			}
		}else{
			file_put_contents("error/running.button.error", $dt." - warn | 有恶意传输数据\r\n",FILE_APPEND);
			exit(114);
		}
	}
	if($_POST[y]=='2983'){
		if($classuser_m->characterJudge($_POST[yy],0)){
			$_sid=trim($_POST[yy]);
			$ysql=mysql_query("select s_status from source where s_id='$_sid'");
			$yRow=mysql_fetch_array($ysql);
			if($yRow[s_status]==0){
				echo "0";
			}else{
				echo "1";
			}
		}
	}
	if($_POST[add]=='adduser'){
		if($classuser_m->characterJudge($_POST[user],3)){
			$addusersql=mysql_query("select * from user_admin where username='$_POST[user]'");
			$adduseryn = is_array($adduserRow=mysql_fetch_array($addusersql));
			$addusertf = $adduseryn ? TRUE :FALSE;
			if($addusertf){
				echo "<font color=red>注：对不起，此用户已存在！</font>";
			}
		}
	}
	if($_POST[add]=="addmail"){
		if($classuser_m->characterJudge($_POST[mail],5)){
			$addmailsql=mysql_query("select * from user_admin where email='$_POST[mail]'");
			$addmailyn = is_array($addmailRow=mysql_fetch_array($addmailsql));
			$addmailtf = $addmailyn ? TRUE :FALSE;
			if($addmailtf){
				echo "<font color=red>注：对不起，此邮箱已存在！</font>";
			}
		}
	}
}
?>
