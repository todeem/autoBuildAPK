<?php
include_once('header.php');
$arr=$classuser->user_shell($_SESSION[uid], $_SESSION[user_shell],8,$_SESSION[times],$_SESSION[mail]);
if($_POST[submit_source]){
	$sourcecode=strtoupper($_POST['sourcecode']);
	if($sourcecode==$_SESSION['code']){
		//提交数据
		$order=$_POST[order][0];
		$portion=$_POST[portion];//有序部分
		$numberA=$_POST[numberA];//从
		$numberB=$_POST[numberB];//到
		$capacity=$_POST[capacity];//几位,如0010
		$ftp="未执行相关操作";
		if($order==1){//无序
			//$androidsourceId=$_POST['android-sourceid']; //提交sourceid内容
			$androidsourceId=str_replace("\r", "", $_POST['android-sourceid']);
		}else if($order==0) {//有序
			$i=0;
			for($i=$numberA;$i<=$numberB;$i++){
				$iformat="%0".$capacity."d";
				$portion_i=sprintf("$iformat",$i);
				$portion_T.=$portion.$portion_i."|";
			}
			$androidsourceId=str_replace("|", "\n", $portion_T);
			$androidsourceId=trim($androidsourceId);
		}
			
		$arrSum=explode("\n", $androidsourceId);
		$percentageSum=count($arrSum);
		$versionPostId=$_POST['version_id'];//版本
		$platformId=$_POST['platform_id'];//环境
		$functionId=$_POST['function_id'];//功能
		$client_platform= $_POST['client_platform'];//客户端平台xsg或者vancl
		$submitVerSql=mysql_query("SELECT v_id FROM `version` where v_env='$platformId' and v_function='$functionId' and v_version=(select v_version from `version` where v_id='$versionPostId')");
		$submitVer=mysql_fetch_array($submitVerSql);
		$versionId=$submitVer[v_id];
		$mailTo=$_SESSION[mail];//发送邮件
		$version_id=$_POST['version_id'];//版本
		$_describe=str_replace("|", "\n", $_POST['describe']);
		$_describe=trim($_describe);
		$describe = $_describe ? $_describe : '无描述';
		$ago=mysql_query("SELECT MAX( s_id ) as maxs_id FROM source;");
		$v_version1=mysql_query("select * from version where v_id='$version_id'");
		$Version=mysql_fetch_array($v_version1);
		$Vversion="$Version[v_version]";
		$ago=mysql_fetch_array($ago);
		$ago="$ago[maxs_id]";

		$sql="INSERT INTO `source` (
		`s_id`, `v_id`, `f_id`, `p_id`, `v_version`, `s_status`,`client_platform` ,`percentage`, `s_value`, `s_submitdatetime`, `update_time`, `u_mailcc`, `uid`, `mail`, `ftp`, `s_describe`) 
		VALUES (NULL, '$versionId', '$functionId', '$platformId', '$Vversion', '1', '$client_platform' , '$percentageSum','$androidsourceId', NOW(), NOW(), '$administrator[mail]', '$_SESSION[uid]', '$mailTo', '$ftp', '$describe')";
		$submitQuery=mysql_query($sql);
		$last=mysql_insert_id();
		if($ago>=$last){
			echo "好像提交失败了，请访问列表页查看是否有此条信息数据";
			echo "<table  style=\"font-size:13px\" border=\"1\" cellpadding=\"3\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
			echo "<tr><td>上一次提交 ID</td><td>".$ago."</td></tr>";
			echo "<tr><td>本次提交 ID</td><td>".$last."</td></tr>";
			echo "<tr><td>如本次ID小于或等于上次提交ID，说明提交已经失败了。请再次提交，或联系管理员 MAIL:$administrator[mail]</td><td>".mysql_errno()."</td></tr>";
			echo "</table>";
			exit(0);
		}else {
			$classaction->get_show_msg("submit_source_xinxi.php?id=$last&page=1","1","提交成功","3");
		}
	}else{
		echo '<script type="text/javascript">window.onload=function(){alert("验证码错误!（对不起，由于暂时无法记录以选择值，请重新选择）");history.go(-1);}</script>';//返回上一步操作
	}
}
//function downli($v_id){
//	$returnArr=mysql_query("select v.v_function,f.f_name,p.p_name,v.v_env
//from
//version v,function f,platform p where v.v_env=p.p_venv and v.v_function=f.f_venv and v_id='$v_id'");
//	$returnArr=mysql_fetch_array($returnArr);
//	return $returnArr;
//}
?>
<!--<script type="text/javascript" src="js/select.js" ></script>-->
<div>
<form action="" id="androidsourceid" method="post"
	name="androidsourceid" onsubmit="return funSubmit()">
<fieldset><legend
	style="color: red; font-weight: bold; font-size: 14px;">请填写相关信息【
Android 】：</legend><br>

<label class="c">平 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;台： <select name="client_platform" id="client_platform">
	<option value="-1">请选择平台</option>
	<option value="0">VANCL</option>
	<option value="1">XSG</option>
</select> </label></br>

<label class="c">版 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本： <select name="version_id" id="version_id">
	<option value="-1">请选择版本</option>
</select> </label> </br>
<label class="c">环 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;境： <select name="platform_id" id="platform_id">
	<option value="-1">请选择环境</option>
</select> </label> </br>

<label class="c">特殊功能： <select name="function_id" id="function_id"
	onchange="return pinhe()">
	<option value="-1">请选择功能</option>
</select> </label><font style="font-size: 14px">注：只有官网才有特殊功能包</font>
<hr class="hr0" />
<div style="valign: top" name="package-xianshi" id="package-xianshi"><font
	color=red style="font-size: 14px">*在此处会显示是否有此包，<br>
如提示数据库无此包，说明此包并未添加到数据库内<br>
请联系管理员添加: </font><u><?php echo $administrator[mail];?> </u> <!--<label  style="border:1px solid #999999;font-weight:normal;" name="package-xianshi" id="package-xianshi"><font color=green>*在此处会显示是否有此包</font></label>-->

</div>
<hr class="hr0" />
<label class="c">邮件地址：</label><?php echo $_SESSION[mail];?> <!-- <div style="font-family:微软雅黑 ">     如还需要抄送给其他人，请在此处添加 <input name="mailto" size="100" type="text"  value=" 例: username@vancl.cn,liuxue@vancl.cn （ 多个邮箱请用英文逗号分割 ）" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999" />  </div>-->

<!-- <input name="mailto"  type="text"  value=" 例:liuxue@vancl.cn" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999" /> 
 --> </br>

<!--<textarea id="android-sourceid"  class="c" style="color:#999999"  name="android-sourceid" rows="10" cols="28"  onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}">-->
<!--</textarea>--><hr class="hr0" />
<table style="valign: top">
	<tr>
		<td><label class="c">渠道提交模式 </label><label class="c" name=orderA><input type="radio" id=orderA
			name="order[]" value="2"  onchange="souridshow()"  />无序手动</label><label class="c" name=orderB>
		<input type="radio" id=orderB name="order[]" value="2" onchange="souridhide()"  />有序自动
		</label></td>
	</tr>
	<tr class="c" id="showsourceid" style="display: none">
		<td>有规则部分:<input type="text" id="portion" size="15" name="portion"
			style="height: 22px" onchange="if (this.value.search(/^[a-zA-Z0-9_-]*$/g)== -1){alert('渠道号不就a-zA-Z0-9_吗？还有哪些？\r联系方式:\r\tMail:<?php echo $administrator[mail];?>'); this.value = ''; this.focus(); }"/>
			， 从:<input type="text" id="numberA" size="3"
			name="numberA" style="height: 22px" onchange="if (this.value.search(/^[0-9]*$/g)== -1){alert('数字，只能是数字！！'); this.value = ''; this.focus(); }" />
			~ 到:<input type="text"
			id="numberB" size="3" name="numberB" style="height: 22px" onchange="if (this.value.search(/^[0-9]*$/g)== -1){alert('数字，只能是数字！！'); this.value = ''; this.focus(); }" />
			， 位数:<input
			type="text" id="capacity" size="1" name="capacity"
			style="height: 22px" onchange="if (this.value.search(/^[0-9]*$/g)== -1){alert('数字，只能是数字！！'); this.value = ''; this.focus(); }"/>位<br />
			<u><i>如</i>：（有规则部分:<font color="red"> vancl_android_</font>， 从:<font color="red"> 1 </font>  ~ 到:<font color="red"> 10 </font>， 位数:<font color="red"> 3 </font>）</u>
			<br/>结果应为："vancl_android_001 到  vancl_android_010"这个范围<br> 
			</td>
	</tr>
	<tr id="hidesourceid" style="display: none;"  >

		<td><label class="c" for="addsourid" style="vertical-align: top">渠道号：</label>
		<textarea id="android-sourceid" class="c" style="color: #999999"
			name="android-sourceid" rows="10" cols="28" onMouseOver="return ch()"
			onMouseOut="return ch()"
			onchange="if (this.value.search(/[\u4E00-\u9FA5]/g)!= -1){ alert('渠道号可以是中文了？? \r\n如果可以使用中文请联系我，程序需要修改！\r联系方式:\r\tMail:<?php echo $administrator[mail];?>'); this.value = ''; this.focus(); }">
</textarea><a href="javascript:void(0);" class="abtn_3"
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
<hr class="hr0" />
<label class="c" style="vertical-align: top">描 述：</label> <textarea
	id="describe" class="c" style="color: #999999" name="describe" rows="3"
	cols="60" onkeyup="return maxlength3(this, 200);">
</textarea><label class="c" style="vertical-align: top">限制输入200个汉字
,请尽量填写</label> <br>
<hr class="hr0" />
<input type="sourcecode" name="sourcecode" size="10"
	style="height: 23px" id="sourcecode" /> <img src="imgcode.php"
	onClick="this.src='imgcode.php?' + Math.random()" alt="点击更换验证码"><font
	style="font-size: 14px">点图刷新</font><br>
<p><input style="height: 30px;" type="submit" name="submit_source"
	value=" 确认提交？  " /></p>
</fieldset>
</form>
</div>
	<?php
	include('foot.php');
	?>

