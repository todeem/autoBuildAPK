<?php
include("header.php");
$arr=$classuser->user_shell($_SESSION[uid], $_SESSION[user_shell],6,$_SESSION[times],$_SESSION[mail]);//6时可以修改自己提交数据
if($_POST[cencel]){
	$classaction->get_show_msg("source_list_id.php","1","已取消","2");
	exit(0);
}
if(isset($_GET[s_id])){
	if($s_id=preg_match('/^\d*$/', $_GET[s_id])){
		$s_id=$_GET[s_id];
		$mobifys_ID=$s_id;
		$mobifySql=mysql_query("SELECT * FROM `source` where s_id='$s_id'");
		$mobifyRow=mysql_fetch_array($mobifySql);
		$mobify_s_value=str_replace("<br>", "\n", str_replace(" ", "&nbsp;", $mobifyRow[s_value])); //处理渠道号
		
		if($mobifyRow[s_status]=='0'){
			$classaction->get_show_msg("source_list_id.php","0","对不起！此数据已处理完成状态，无法进行修改","3");
		}else if($mobifyRow[s_status]=='2'){
			$classaction->get_show_msg("source_list_id.php","0","对不起！此数据正在处理中...无法进行修改","3");
		}
	}else{
		$classaction->get_show_msg("source_list_id.php","0","<font color=red><b> 警告</b>：<br><br>　　请不要乱提交非法字符，已将你此次猜测数据发送给管理员！</font>","9");
	}
}else{
	$classaction->get_show_msg("source_list_id.php","0","传送有误，值域未传送成功，请返回重试!");
}
if($_POST[update_source]){
	$mobifysourcecode=strtoupper($_POST['sourcecode']);
	if($mobifysourcecode==$_SESSION['code']){
		//提交数据
		$androidsourceIdM=str_replace("\r", "", $_POST['android-sourceid']);
		$versionIdM=$_POST['version_id'];//版本
		$clientplatform=$_POST['client_platform'];
		$platformIdM=$_POST['platform_id'];//版本
		$functionIdM=$_POST['function_id'];//版本
		$version_idM=$_POST['version_id'];//版本
		$_describe=str_replace("|", "\n", $_POST['describe']);
		$_describe=trim($_describe);
		$describe = $_describe ? $_describe : '无描述';
		$v_version1M=mysql_query("select * from version where v_id='$version_idM'");
		$VersionM=mysql_fetch_array($v_version1M);
		$VversionM="$VersionM[v_version]";
		$updateSql=mysql_query("UPDATE `source` SET `v_id`='$versionIdM',`f_id`='$functionIdM',`client_platform`='$clientplatform',`p_id`='$platformIdM',`v_version`='$VversionM',`s_value`='$androidsourceIdM',`update_time`=NOW(),`s_describe`='$describe' WHERE `s_id`='$mobifys_ID'");
		$submitQuery=mysql_query($updateSql);
		$classaction->get_show_msg("submit_source_xinxi.php?id=".$mobifys_ID."&page=1","1","成功");
	}else{
		echo '<script type="text/javascript">window.onload=function(){alert("验证码错误，请重新选择环境等信息！");history.go(-1);}</script>';//返回上一步操作
	}
}


?>
<div>

<form action="" id="androidsourceid" method="post"
	name="androidsourceid" onsubmit="return funSubmit()">
<fieldset><legend
	style="color: red; font-weight: bold; font-size: 14px;">请填写相关信息【Android】：</legend><br>
<label class="c">平 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;台：
<select name="client_platform" id="client_platform">
	<?php if($mobifyRow[client_platform]=="0"){
			$platform0 = "selected";
			
			}
			elseif($mobifyRow[client_platform]=="1"){
				$platform1 = "selected";
			} ?>
	<option value="0" <?php echo $platform0;?>/>VANCL</option>
	<option value="1" <?php echo $platform1;?>/>XSG</option>
</select> </label> </br>
<label class="c">版 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本： <select name="version_id" id="version_id">
	<option value="<?php echo $mobifyRow[v_id]; ?>"><?php echo $mobifyRow[v_version]; ?></option>
	<?php
	$query=mysql_query("SELECT v_version, v_id FROM `version` where client_platform='$mobifyRow[client_platform]' GROUP BY v_version  order by v_version Desc");
	while ($row=mysql_fetch_array($query)) {
		echo "<option value=\"$row[v_id]\">$row[v_version]</option>";
	}
	?>
</select> </label> </br>
<label class="c">环 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;境： <select name="platform_id" id="platform_id">
<?php
$mobifyPlatform=mysql_query("select p_name from platform where p_venv='$mobifyRow[p_id]'");
$mobifyPlatform=mysql_fetch_array($mobifyPlatform);
?>
	<option value="<?php echo $mobifyRow[p_id]; ?>"><?php echo $mobifyPlatform[p_name];?></option>
</select> </label> </br>

<label class="c">特殊功能： <select name="function_id" id="function_id"
	onchange="return pinhe()">
	<?php
	$mobifyFunction1=mysql_query("select f_name from function where f_venv='$mobifyRow[f_id]'");
	$mobifyFunction=mysql_fetch_array($mobifyFunction1);
	?>
	<option value="<?php echo $mobifyRow[f_id]; ?>"><?php echo $mobifyFunction[f_name];?></option>
</select> </label><font style="font-size: 14px">注：只有官网才有特殊功能包</font><br>
<br>
<div style="valign: top" name="package-xianshi" id="package-xianshi"><font
	color=red style="font-size: 14px"><b>* 数据库内存在此包信息：</b></font><br>
<table id="package-xianshi" style="font-size: 13px" border="1"
	cellpadding="3" bordercolor="#666666" bordercolorlight="#33FF00"
	bordercolordark="#CCFF00" cellspacing="0">
	<?php
	$mobifyVersion1=mysql_query("select * from version where v_id='$mobifyRow[v_id]'");
	$mobifyVersion=mysql_fetch_array($mobifyVersion1);
	echo "<tr><td>唯一标识(V_ID)：</td><td>".$mobifyRow[v_id]."</td></tr><tr><td>包名称：</td><td>".$mobifyVersion[v_packname]."</td></tr><tr><td>特殊功能:</td><td>".$mobifyFunction[f_name]."</td></tr><tr><td>版本号:</td><td>".$mobifyRow[v_version]."</td></tr><tr><td>环境:</td><td>".$mobifyPlatform[p_name]."</td></tr>";
	?>
</table>
</div>
</br>
<label class="c">邮件地址：</label><?php echo $_SESSION[mail];?>
<table style="valign: top">
	<tr>
		<td><label class="c" for="addsourid" style="vertical-align: top">渠道号：</label>
		<textarea id="android-sourceid" class="c" style="color: #999999"
			name="android-sourceid" rows="10" cols="28" onMouseOver="return ch()"
			onMouseOut="return ch()" onchange="if (this.value.search(/[\u4E00-\u9FA5]/g)!= -1 || this.value.search(/\ /g)!= -1 ){ alert('渠道号可以是中文了？? \r\n如果可以使用中文请联系我，程序需要修改！\r联系方式:\r\tMail:<?php echo $administrator[mail];?>'); this.value = ''; this.focus(); }"><?php echo $mobify_s_value;?>
</textarea> <a href="javascript:void(0);" class="abtn_3"
			style="text-decoration: none;"> <img alt="清空输入的渠道信息?"
			src="image/empty.gif" onclick="clickclear('你确定要清空当前渠道号吗？')" />
		<div class="hintsB" style="left: 350px">
		<div><font color="red">清空渠道号</font></div>
		</div>
		</a></td>
		<td valign="top"><span id="tishi-android-sourceid"
			style="font-size: 13px; font-family: 微软雅黑, arial, sans-serif; border-color: #ccc;">
		请按格式要求输入正确渠道号！<br>
		鼠标移至输入框上方会有提示 </span></td>
	</tr>
</table>

<label class="c" style="vertical-align: top">描　述：</label>
<textarea id="describe" class="c" style="color: #999999"
			name="describe" rows="3" cols="60" onkeyup="return maxlength3(this, 200);"><?php echo $mobifyRow[s_describe];?>
</textarea><label class="c" style="vertical-align: top">限制输入200个汉字 ,请尽量填写</label>


<br>
<input type="sourcecode" name="sourcecode" size="10"
	style="height: 23px" id="sourcecode" /> <img src="imgcode.php"
	onClick="this.src='imgcode.php?' + Math.random()" alt="点击更换验证码"><font
	style="font-size: 14px">点图刷新</font><br>
<p><input type="submit" name="update_source" value=" 修改更新  " /> <input
	type="button" name="Submit" value="取消修改"
	onclick="javascript:history.go(-1)" /></p>
</fieldset>
</form>
</div style="margin-top:10px;">
	<?php
	include('foot.php');
	?>
</div>