<?php
include_once('header.php');
//user_shell(1);
	if($_SESSION[user_shell]==md5($_SESSION[username].$_SESSION[mail].ALL_PS)){
		$classaction->get_show_msg("source_list_id.php","1","已登录用户！","0");
	}
?>

<?php
	$classuser->get_user_login($_POST);
?>
<object type="application/x-shockwave-flash" width="200" height="200"> 
    <param name="movie" value="image/head.swf"></param> 
    <param name="wmode" value="opaque"></param> 
</object>

<div>
<form action="" id="thisform" method="post" name="loginform" onsubmit="return checkpost()">
<fieldset>
<legend>登陆 </legend><br>
<label for="name">用户名:</label><br />
<input type="text" name="username" style="height: 21px" tabindex="1"  value="" /> 
<a href="javascript:void(0);" class="abtn_3" style="text-decoration: none;">
<img alt="答疑" src="image/qa.png"  width="15"  height="18" />
    <div class="hintsB">
        <div><font color="red">此处输入jira或svn帐号！</font><hr>如提示“某某用户，不存在于登陆列表”，则说明，用户并无登陆权限</div>
    </div>
</a>

<br><label for="password">密码:</label><br />
<input type="password" id="password" name="password" tabindex="2"  value="" />
<a href="javascript:void(0);" class="abtn_3"  style="text-decoration: none;">
<img alt="答疑" src="image/qa.png"  width="15"  height="18">
    <div class="hintsB">
        <div><font color="red">此处输入jira或svn密码。<hr>忘记了？</font>可以通过登陆jira或svn系统进行找回。</div>
    </div>
</a>
<br>
<label for="password">验证码:</label><br /><input type="code" name="code"	size="10" style="height: 23px" tabindex="3"  />
<img src="imgcode.php" onclick="this.src='imgcode.php?' + Math.random()" alt="点击更换验证码" >点图刷新<br>
<p><input type="submit" name="submit" value=" 登 陆  " tabindex="4" style="height:28px;width:60px"/>　<a href="http://pek7-qas-01.vancloa.cn:8080/secure/ForgotLoginDetails.jspa" style="text-decoration: none" >忘记密码？</a></p>
</fieldset>
</form>
</div>
<!--  <input name="keyword"  type="text"  value="请输入关键字" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999" /> 
 -->  
<div style="bottom: 0px;padding:0;">
<?php 
echo $password=md5("test3".ALL_PS."123456");
include_once('foot.php');
?>
</div>