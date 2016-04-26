<?php
include('header.php');
$arr=$classuser->user_shell($_SESSION[uid], $_SESSION[user_shell],9,$_SESSION[times],$_SESSION[mail]);
if($_SESSION[user_shell]==md5($_SESSION[username].$_SESSION[mail].ALL_PS)){
	
}

?>
<br><br><br><br>
<br><br>
<form action="searcher.php" id="formsearch" method="get" name="formsearch">
<table align="center" >
<tr><td>
<input name="submitSearch" id="submitSearch" type="text" placeholder=" *请输入单个渠道或一部分" style="color:#999999;height: 28px;width:335px;font-size:15px;"  onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" /> 
</td><td><a href="javascript:void(0);" class="abtn_3" style="text-decoration: none;" >
<img src="image/sou.png" alt="高级模式"  width="20"  height="20" >
    <div class="hintsB">
        <div><font color="red">*通过更多选择搜索结果!</font></div>
    </div>
</a></td><td>
　<input  type="submit"  style="height: 30px;width:80px" value="开始搜索">
</td></tr>
<tr>

<td name="high_td" id="high_td" style="display:none;" >
<table style="font-size:12px;" class="std">
<?php
echo "<tr><td>环境:";
$plat=mysql_query("select p.p_venv,p.p_name from source s, platform p where p.p_venv=s.p_id and s.uid='$_SESSION[uid]' GROUP BY s.p_id");
while($platrow=mysql_fetch_array($plat)){
	echo "<input type=\"radio\" name=\"env[]\" value=\"$platrow[p_venv]\">$platrow[p_name]";
}
echo "</td></tr>";
echo "<tr><td>功能:";
$fun=mysql_query("select f.f_venv,f.f_name from source s, function f where f.f_venv=s.f_id and s.uid='$_SESSION[uid]' GROUP BY s.f_id");
while($funrow=mysql_fetch_array($fun)){
	echo "<input type=\"radio\" name=\"fun[]\" value=\"$funrow[f_venv]\">$funrow[f_name]";
}
echo "</td></tr><tr><td>";

echo "<tr><td>版本:";
$query=mysql_query("SELECT v_version,v_id FROM `source` where uid=$_SESSION[uid] group by v_version  order by v_version Desc");
echo "<select name=\"v_id\" id=\"v_id\"><option value=\"\">请选择版本</option>";
while ($row=mysql_fetch_array($query)) {
		echo "<option value=\"$row[v_id]\">$row[v_version]</option>";
	}

echo "</select></td></tr>";
echo "<tr><td>处理情况:";
$statusSql=mysql_query("SELECT s_status FROM `source` where uid='$_SESSION[uid]' GROUP BY s_status ");
	while ($statusRow=mysql_fetch_array($statusSql)){
			if($statusRow[s_status]=='1'){
			$st="未处理";
		}else{
			$st="已处理";
		}
		echo "<input type=\"radio\" name=\"status[]\" value=\"$statusRow[s_status]\">$st</option>";
	}
	

echo "</td></tr>";
?>
<tr><td>
<!--处理情况：-->
<!--<input type="radio" name="status[]" value="0">已处理-->
<!--<input type="radio" name="status[]" value="1">未处理-->
</td></tr>
</table>
<td></tr>
<tr align="center"><td>
<font color="#999" style="font-size:13px">仅能搜索您自己提交的渠道号<br>
如需要搜索到其他人提交的渠道号，请申请增加相对权限！</font>
</td></tr>
</table>

</form>
<?php 
include('foot.php');
?>
