# autoBuildAPK
>阐述：通过web进行渠道包的批量打包（主要由于公司引入lib库原因，无法使用ant等进行完全自动化）。其核心部分主要是shell进行了一个反编译后修改文件。其实这个版本根本不算BUILD。
>其实这个代码对于现在来讲没有任何用，只是自己留着以后头脑不灵敏时回来看看。

```
在第一家公司因为很多时候都是重复的在做一件事情，所以大概2010年开始有这个想法，但开发语言不熟悉，之后2011年换第二家公司，并自己写了一个初级的版本，十分简单的。2012年这个程序6月份，现在这份平台写完。 期间遇到各种问题，各种困难。各种瓶颈。。。 之后有朋友公司需要类似平台，后期进行了全新构造，之后并投入使用，获得第一笔非工作收入。
```

## 配置步骤
1) 创建数据库   
创建数据库，并导入 `DB` 文件夹下的 `DB_autoBuildAPK.sql` 
```

mysql> create database sourceid character set utf8;
mysql> GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP,ALTER,INDEX on sourceid.* TO 'source'@'localhost' IDENTIFIED BY 'source';
mysql> flush privileges;
```

2) 修改 `config.php` 配置文件   
* 数据库配置
```
define("DB_HOST", 'localhost');	//主机名或IP   
define("DB_DATA", 'sourceid');	// 数据库   
define("DB_USER", 'source');	// 数据库登陆用户名   
define("DB_PASSWORD", 'source');//数据库密码     
define("MYDBCHARSET", 'utf8');	//编码  
```

* 自定义部分
```
//密码自定义串 keys str
define("ALL_PS", kinggoo.com);//自定义

define("OVERTIME", 3600);//最大登陆超时时间，默认为一小时，单位为秒
```

* 登陆帐号认证模式 
```
//是否采用LDAP/MYSQL帐号认证模式
define("USELDAP",false);    //是否使用了ldap认证，true：使用ldap账户认证，false：使用数据库帐号认证

//## OpenLDAP配置 ##
$ldaphost = 'kinggoo';//ldap的主机host 或者 域名
$ldapport = 389;//ldap的端口号
$ldapbase = 'dc=kinggoo,dc=cn';//ldap的BN
```

* 文件目录配置
```
//项目所在服务器根目录(这个地方会影响到class.show.php)
define("PROHOME", '/var/www/html/source/'); 

//服务主机上传apk包 D:\wamp\www\php.source\v1.0\upfile  
//服务主机上传apk包
define("UPFILEPATH", '../upfile/');    

//临时目录，需要
define("TMP", 'tmp/'); 
```

* 上传
```
//允许上传格式
define("UPFILETYPE", 'apk'); 

//上传文件大小限制，允许上传单个大小6M
define("UPFILESIZE", 6291456); 

```

* FTP配置 
```
//ftp服务器地址
define("FTP_HOST", 'pekdc1-mob-02.kinggoo.com');
//ftp端口
define("FTP_PORT", '21');

//用来提交传送apk包体的 - ftp 登陆用户名
define("FTP_USER", 'phpftp');
//用来提交传送apk包体的 - ftp 密码
define("FTP_PASSWD", 'phpftpwrite');

//发送给相关渠道打包人员的ftp帐号和密码，只读权限
define("FTP_READ", 'kinggoo');
define("FTP_READPASSWD", 'kinggoo');
```

* 定义邮件相关
```
$administrator=array(
"smtphost"=>"smtpsrv01.kinggoo.cn",               // smtp邮件服务器地址
"charset"=>"utf-8",                               // 文件编码
"port"=>"25",                                     // smtp端口
"fromadds"=>"admin@kinggoo.cn",                   // 对方显示显示的邮件地址
"fromname"=>"admin@kinggoo.cn",                   // 对方显示显示的邮件名称
"mail"=>"admin@kinggoo.cn",                       // 邮箱地址
"name"=>"admin@kinggoo.cn",                       // 邮箱用户名
"password"=>"KingGoo.com",                        // 邮箱密码
"site"=>"http://pek7-qas-01.kinggoo.cn/source/",  // autoBuildAPK WEB地址
"apply"=>"shenqing.php",                          // 发送申请开通帐号（不知道为什么没写）
"searcher"=>"1"                                   // 开启搜索查看模式(好像是可以不让其他人检索非自己提交的包体)
);

//
// 用来做打包将相关信息发送给相关人员
$G_head='<font color=red>
<b>此邮件仅为证实您提交的渠道号已经在自动打包序列排队，待打包完成后会有邮件通知您。</b></font><br><b>ftp地址</b>：';
//$ftpadds='ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/'.$id;
$G_aount='<b>username</b>:'.FTP_READ.'<br><b>password</b>:'.FTP_READPASSWD;
$G_ftp='Ftp下载方法及工具：<a href=ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/software/more.txt>ftp://'.FTP_READ.':'.FTP_READPASSWD.'@'.FTP_HOST.'/software/more.txt</a>';
//$i='<b>ftp地址</b>：<a href='.$ftpadds.' target=_blank>'.$ftpadds.'</a>';
$G_foot='</br>[<i>默认点击上面链接会直接登录,否则请使用下面帐号密码登录</i>]<br>'.$G_aount.'<br>'.$G_ftp.'<br>如有问题，请email联系：'.$administrator["mail"];

global $administrator,$G_head,$G_aount,$G_foot,$G_ftp;

```


* shell下脚本调用内置参数的配置(多数都是根据各自包体配置方式不一样来修改)
```
HOME_KEY //签名密钥文件
KEY_STR  //签名密码
JAVAHOME //java的环境变量
#通过这里一下子就能看明白了。
jarsigner -verbose -keystore ${HOME_KEY} -storepass ${KEY_STR} -signedjar ../../apk/${line}.apk ../${line}.apk yek 2>> ${log}
# ----------------------------------# 
# --- mysql db configure
mysqlname="source"
mysqlpasswd=source
mysqldb="sourceid"
mysqlhost=localhost
mysqlport=3306
# 
# ----------------------------------# 
# --- FTP配置
ftp_adds="pekdc1-mob-02.kinggoo.cn"
ftp_user="phpftp"
ftp_passwd="phpftpwrite"

```

# 默认帐号密码
```
admin/123456
test/123456
test3/123456
```
每次添加新用户，都会写入到 `error/mima` 文件内    
到时我们使用的是openldap来管理帐号，所以当时没有设计修改密码这一块。。。    

