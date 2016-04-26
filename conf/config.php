<?php
/*
 * ++++++++++++++++++++++++++
 *
 * For  http://kinggoo.com
 *
 * ++++++++++++++++++++++++++
 *
 HELP:
 (Linux):在导入数据时，请将mysql做一下设置，否则中文会乱码
 使用set方法使下面设置为utf8
 mysql> set character_set_client = utf8;其他依次类推
 mysql> set character_set_connection = utf8;
 mysql> set character_set_database = utf8;
 mysql> set character_set_results = utf8;
 mysql> set character_set_server = utf8;
 mysql> show variables like '%cha%';
 +--------------------------+----------------------------+
 | Variable_name            | Value                      |
 +--------------------------+----------------------------+
 | character_set_client     | utf8                       |
 | character_set_connection | utf8                       |
 | character_set_database   | utf8                       |
 | character_set_filesystem | binary                     |
 | character_set_results    | utf8                       |
 | character_set_server     | utf8                       |
 | character_set_system     | utf8                       |
 | character_sets_dir       | /usr/share/mysql/charsets/ |
 +--------------------------+----------------------------+

 使用set方法使下面设置为utf8
 mysql> set names utf8;
 mysql> show variables like '%coll%';
 +----------------------+-----------------+
 | Variable_name        | Value           |
 +----------------------+-----------------+
 | collation_connection | utf8_general_ci |
 | collation_database   | utf8_bin        |
 | collation_server     | utf8_general_ci |
 +----------------------+-----------------+
 *
 *
 */



//数据库配置
define("DB_HOST", 'localhost'); //主机名或IP
define("DB_DATA", 'sourceid');// 数据库
define("DB_USER", 'source');// 数据库登陆用户名
define("DB_PASSWORD", 'source');//数据库密码
define("ALL_PS", kinggoo.com);//自定义
define("MYDBCHARSET", 'utf8'); //编码
define("OVERTIME", 3600);//最大超时时间，默认为一小时，单位为秒

//是否采用LDAP/MYSQL帐号认证模式
define("USELDAP",false);    //是否使用了ldap认证，true：使用ldap账户认证，false：使用数据库帐号认证
define("PROHOME", '/var/www/html/source/');    //项目所在服务器根目录(这个地方会影响到class.show.php)
//define("UPFILEPATH", '../upfile/');    //服务主机上传apk包D:\wamp\www\php.source\v1.0\upfile
define("UPFILEPATH", '../upfile/');    //服务主机上传apk包
define("TMP", 'tmp/');
define("UPFILETYPE", 'apk');//允许上传格式
define("UPFILESIZE", 6291456);//允许上传单个大小6M
//ldap配置
$ldaphost = 'kinggoo';//ldap的主机host 或者 域名
$ldapport = 389;//ldap的端口号
$ldapbase = 'dc=kinggoo,dc=cn';//ldap的BN
//ftp配置
define("FTP_HOST", 'pekdc1-mob-02.kinggoo.com');//ftp hostname
define("FTP_PORT", '21');// ftp port
define("FTP_USER", 'phpftp'); //ftp username
define("FTP_PASSWD", 'phpftpwrite');// ftp password

define("FTP_READ", 'kinggoo');//ftp only read username
define("FTP_READPASSWD", 'kinggoo');// ftp  only read password

//
$administrator=array(
"smtphost"=>"smtpsrv01.kinggoo.cn",
"charset"=>"utf-8",
"port"=>"25",
"fromadds"=>"admin@kinggoo.cn",
"fromname"=>"admin@kinggoo.cn",
"mail"=>"admin@kinggoo.cn",
"name"=>"admin@kinggoo.cn",
"password"=>"KingGoo.com",
"site"=>"http://pek7-qas-01.kinggoo.cn/source/",
"apply"=>"shenqing.php",
"sercher"=>"1"
);
$G_head='<font color=red>
<b>此邮件仅为证实您提交的渠道号已经在自动打包序列排队，待打包完成后会有邮件通知您。</b></font><br><b>ftp地址</b>：';
//$ftpadds='ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/'.$id;
$G_aount='<b>username</b>:'.FTP_READ.'<br><b>password</b>:'.FTP_READPASSWD;
$G_ftp='Ftp下载方法及工具：<a href=ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/software/more.txt>ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/software/more.txt</a>';
//$i='<b>ftp地址</b>：<a href='.$ftpadds.' target=_blank>'.$ftpadds.'</a>';
$G_foot='</br>[<i>默认点击上面链接会直接登录,否则请使用下面帐号密码登录</i>]<br>'.$G_aount.'<br>'.$G_ftp.'<br>如有问题，请email联系：'.$administrator["mail"];

global $administrator,$G_head,$G_aount,$G_foot,$G_ftp;


?>
