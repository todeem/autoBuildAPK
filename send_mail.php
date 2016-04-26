<?php
include('header.php');
include("class/class.phpmailer.php");
$s_id=$_GET[id];
$sql=mysql_query("select * from source where s_id='$s_id'");
$err=mysql_error();
$row=mysql_fetch_array($sql);
$address="$row[mail]";
$subject="渠道包完成通知";
$mailbody="$row[ftp]";
if($err){
//file_put_contents("error/running.button.error", $dt." - error | ".$err." 提交信息 \r\n".$mailbody."\r\n",FILE_APPEND);
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
//	file_put_contents("error/running.mail.error", $dt." - error | 发送失败 \r\n",FILE_APPEND);
}


?>
