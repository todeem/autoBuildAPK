<?php
include("./header.php");
/* KingGoo编写上传文件代码
 * http://www.kinggoo.com
 */
$arr=$classuser_m->user_shell($_SESSION[uid], $_SESSION[user_shell],2,$_SESSION[times],$_SESSION[mail]);
?>
<?php
			$v=mysql_query("SELECT v_version FROM version GROUP BY v_version  order by v_version Desc");
			$ver=mysql_fetch_array($v);
			$c=mysql_query("SELECT v_versioncode FROM version GROUP BY v_versioncode  order by v_versioncode Desc");
			$code=mysql_fetch_array($c);
			$p=mysql_query("select p_name,p_venv from platform");
			$f=mysql_query("select f_name,f_venv from function");
			$pr=mysql_fetch_array($p);
			$fr=mysql_fetch_array($f);
			
?>

<div class="divline">
<form action="upload.php" enctype="multipart/form-data" method="post" name="form">
	<div class="hide" id="1"><b>上传文件</b><input type="hidden"  class ="最新/格式:	<?php echo $code[v_versioncode];?>" name="count" value="1" id="最新/格式:	<?php echo $ver[v_version];?>"></div>
		<div class="upleft" id="all" style="font-size:18px;">
			<div class="upleft"  id="upleft1">
				<div class="upbrowse" id="upbrowse1" date-id="1" >
					<input name="upfile[]" type="file"  id="upfile1"  onchange="if(!upFileName(this.id)){this.value = ''};this.focus();  ">
				</div>
				<p>包　名：<span id="span1" date-y="n">请添加无签名渠道包</span></p>
				<p>版本号：<input type="text" class="ver" name="ver1" id="ver1"  placeholder="最新/格式:	<?php echo $ver[v_version];?> " onchange="if (this.value.search(/^[a-zA-Z0-9\.]*$/g)== -1){alert('抱歉，只能输入 a-zA-Z0-9.'); this.value = ''; this.focus(); }"></p>
				<p>VersionCode号：<input type="text" class="versioncode" name="versioncode1" id="versioncode1" placeholder="最新/格式:	<?php echo $code[v_versioncode];?> " onchange="if (this.value.search(/^[0-9]*$/g)== -1){alert('抱歉，只能输入数字！！'); this.value = ''; this.focus(); }" ></p>
				<p>平　台：<select name="clientplatform1" id="clientplatform1">
				<option value="-1">请选此包对应平台</option>
				<option value="0">KINGGOO</option>
				<option value="1">Xsg</option>
				</select>
				</p>
				<p>环　境：<select name="plat1" id="plat1"><option value="-1">请选此包对应环境</option></select>
				</p>
				<p>功　能：<select name="flat1" id="flat1"><option value="-1">请选此包对应功能</option></select>
				</p>
				<br>
			</div>
		</div>
	<div style="clear:both;"></div>
<div class="upleft">
<img id="add" src="../image/add.png">　<img id="del" src="../image/del.png">　<input type="submit" value="开始上传" style="height:28px;width:76px;font-weight:bold;">
</div>
</form>
</div>
<?php
include('../foot.php');
?>
