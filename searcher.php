<?php
include('header.php');
?>
<style type="text/css">
<!--
.hr0 {
	height: 1px;
	border: none;
	border-top: 1px dashed #ccc;
}
</style>
<br>
<form action="searcher.php" id="formsearch" method="get"
	name="formsearch">
<table align="center">
	<tr>
		<td><input name="submitSearch" placeholder=" 可留空或输入单个渠道或一部分"
			id="submitSearch" type="text"
			style="color: #999999; height: 28px; width: 335px; font-size: 14px;"
			onFocus="if(value==defaultValue){value='';this.style.color='#000'}"
			onBlur="if(!value){value=defaultValue;this.style.color='#999'}" /></td>
		<td><a href="javascript:void(0);" class="abtn_3"
			style="text-decoration: none;"> <img src="image/sou.png" alt="高级模式"
			width="20" height="20">
		<div class="hintsB">
		<div><font color="red" id="FhintsB">*更多条件筛选结果</font></div>
		</div>
		</a></td>
		<td><input type="submit" style="height: 30px; width: 80px"
			value="开始搜索"></td>
	</tr>
	<tr>

		<td name="high_td" id="high_td" style="display: none; padding: 0px;">
		<table style="font-size: 12px; width: 100%; padding: 0px;" class="std">
		<?php
		if($administrator[sercher]=="0"){
			echo "<tr><td>环境:";
			$plat=mysql_query("select p.p_venv,p.p_name from source s, platform p where p.p_venv=s.p_id and s.uid='$_SESSION[uid]' GROUP BY s.p_id");
			while($platrow=mysql_fetch_array($plat)){
				echo "<input type=\"radio\" name=\"env[]\" value=\"$platrow[p_venv]\">$platrow[p_name]";
			}
			echo "<hr class=\"hr0\"></td></tr>";
			echo "<tr><td>功能:";
			$fun=mysql_query("select f.f_venv,f.f_name from source s, function f where f.f_venv=s.f_id and s.uid='$_SESSION[uid]' GROUP BY s.f_id");
			while($funrow=mysql_fetch_array($fun)){
				echo "<input type=\"radio\" name=\"fun[]\" value=\"$funrow[f_venv]\">$funrow[f_name]";
			}
			echo "<hr class=\"hr0\"></td></tr>";

			echo "<tr><td>版本:";
			$query=mysql_query("SELECT v_version,v_id FROM `source` where uid=$_SESSION[uid] group by v_version  order by v_version Desc");
			echo "<select name=\"v_id\" id=\"v_id\">
		<option value=\"\">请选择版本</option>";
			while ($row=mysql_fetch_array($query)) {
				echo "<option value=\"$row[v_id]\">$row[v_version]</option>";
			}

			echo "</select><hr class=\"hr0\"></td></tr>";
			echo "<tr><td>处理情况:";
			$statusSql=mysql_query("SELECT s_status FROM `source` where uid='$_SESSION[uid]' GROUP BY s_status ");
			while ($statusRow=mysql_fetch_array($statusSql)){
				if($statusRow[s_status]=='1'){
					$st="未处理";
				}else if($statusRow[s_status]=='0'){
					$st="已处理";
				}else if($statusRow[s_status]=='2'){
					$st="处理中";
				}else{
					$st="ERROR";
				}
				echo "<input type=\"radio\" name=\"status[]\" value=\"$statusRow[s_status]\">$st</option>";
			}
			echo "<hr class=\"hr0\"></td></tr>";
		}else if($administrator[sercher]=="1"){
			echo "<tr><td>环境:";
			$plat=mysql_query("select p.p_venv,p.p_name from source s, platform p where p.p_venv=s.p_id  GROUP BY s.p_id");
			while($platrow=mysql_fetch_array($plat)){
				echo "<input type=\"radio\" name=\"env[]\" value=\"$platrow[p_venv]\">$platrow[p_name]";
			}
			echo "<hr class=\"hr0\"></td></tr>";
			echo "<tr><td>功能:";
			$fun=mysql_query("select f.f_venv,f.f_name from source s, function f where f.f_venv=s.f_id GROUP BY s.f_id");
			while($funrow=mysql_fetch_array($fun)){
				echo "<input type=\"radio\" name=\"fun[]\" value=\"$funrow[f_venv]\">$funrow[f_name]";
			}
			echo "<hr class=\"hr0\"></td></tr>";
			echo "<tr><td>版本:";
			$query=mysql_query("SELECT v_version,v_id FROM `source`  group by v_version  order by v_version Desc");
			echo "<select name=\"v_id\" id=\"v_id\">
		<option value=\"\">请选择版本</option>";
			while ($row=mysql_fetch_array($query)) {
				echo "<option value=\"$row[v_id]\">$row[v_version]</option>";
			}
			echo "</select><hr class=\"hr0\"></td></tr>";
			echo "<tr><td>处理情况:";
			$statusSql=mysql_query("SELECT s_status FROM `source`   GROUP BY s_status asc ");
			while ($statusRow=mysql_fetch_array($statusSql)){
				if($statusRow[s_status]=='1'){
					$st="未处理";
				}else if($statusRow[s_status]=='0'){
					$st="已处理";
				}else if($statusRow[s_status]=='2'){
					$st="处理中";
				}else{
					$st="ERROR";
				}
				echo "<input type=\"radio\" name=\"status[]\" value=\"$statusRow[s_status]\">$st</option>";
			}


			echo "<hr class=\"hr0\"></td></tr>";
		}else if($administrator[sercher]=="2"){

		}
		?>
			<tr>
				<td></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr align="center">
		<td><font color="#999" style="font-size: 13px">仅能搜索您自己提交的渠道号<br>
		如需要搜索到其他人提交的渠道号，请申请增加相对权限！</font></td>
	</tr>
</table>

</form>

		<?php
		if(isset($_GET)){
			//	print_r($_GET);
			$p_id=$_GET[env][0];
			$status=$_GET[status][0];
			$f_id=$_GET[fun][0];
			$v_id=$_GET[v_id];
			$psfv=$p_id.$status.$f_id.$v_id;
			if(preg_match('/^[0-9a-zA-Z_]{1,}$/', $_GET[submitSearch])||isset($_GET[submitSearch]) && preg_match('/^\d*$/', $psfv )||isset($psfv)  ){
				if($administrator[sercher]=="0"){ //仅自己
					$uid=$_SESSION[uid];
				}else if($administrator[sercher]=="1"){ //可看任何人
					$uid="";
				}else if($administrator[sercher]=="2"){ //根据权限
					$uid="";
				}
				$sqlkey=searchKeyword($_GET[submitSearch],"$uid","$f_id","$status","$p_id","$v_id");
				$sqltest=searchKeyword($_GET[submitSearch],"$uid","$f_id","$status","$p_id","$v_id");
				$es = is_array(mysql_fetch_array($sqltest));
				$ees = $es ? TRUE  : FALSE ;
				if($ees){
					echo "<div style=\"border: 1px solid #cc;border: 2px dashed #ccc;	margin:2 2px;padding:10 10 10 5px\"><table align=\"center\"  style=\"font-size:14px\" border=\"1\" cellpadding=\"5\" bordercolor=\"#FF0000\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >
				<table id=\"myTable\" class=\"tablesorter\"  align=\"center\"  style=\"font-size:14px;border: solid 1px #f90;border-collapse: collapse;\" border=\"1\" cellpadding=\"5\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
					echo "<thead><tr bordercolor=\"#000000\" bgcolor=\"#FFFF99\">
					<th  scope=\"col\">序号</th>
					<th  scope=\"col\">版本</th>
					<th  scope=\"col\">环境</th>
					<th  scope=\"col\">功能</th>
					<th  scope=\"col\">提交用户</th>
					<th scope=\"col\">邮件</th>
					<th scope=\"col\">抄送给</th>
					<th  scope=\"col\">渠道号</th>
					<th  scope=\"col\">提交时间</th>
					<th  scope=\"col\">修改时间</th>
					<th scope=\"col\">打包状态</th>
			</tr></thead><tbody>";
					while($rowt=mysql_fetch_array($sqlkey)){
						$rowt_s_value_look=str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $rowt[s_value]));
						$rowt_s_value_look_array=explode("<br>", "$rowt_s_value_look");
						$total=ceil(count($rowt_s_value_look_array));
						$fSql=mysql_query("SELECT f_name from function where f_venv='$rowt[f_id]'");
						$fRow=mysql_fetch_array($fSql);
						$pSql=mysql_query("SELECT p_name from platform where p_venv='$rowt[p_id]'");
						$pRow=mysql_fetch_array($pSql);
						$uSql=mysql_query("SELECT username from user_admin where uid='$rowt[uid]'");
						$uRow=mysql_fetch_array($uSql);
						if($rowt[s_status]=='1'){
							$s_status="<font color=\"red\">未处理</font>";
						}
						if($rowt[s_status]=='0'){
							$s_status="<font color=\"green\">已处理</font>";
						}
						if($rowt[s_status]=='2'){
							$s_status="<font color=\"blue\">处理中</font>";
						}
						$rn=rand(20,500).md5($_SESSION[username]);
						echo "<tr  id=\"a\" style=\"text-align: center;\">
					<td valign=\"top\">".$rowt[s_id]."</td>
					<td valign=\"top\">".$rowt[v_version]."</td>
					<td valign=\"top\">".$pRow[p_name]."</td>
					<td valign=\"top\">".$fRow[f_name]."</td>
					<td valign=\"top\">".$uRow[username]."</td>
					<td valign=\"top\">".$rowt[mail]."</td>
					<td valign=\"top\">".$rowt[u_mailcc]."</td>
					<td valign=\"top\" align=\"left\">　<a href=\"submit_source_xinxi.php?id=$rowt[s_id]&page=1\">详细</a>　(共".$total."个)　</td>
					<td valign=\"top\">".$rowt[s_submitdatetime]."</td>
					<td valign=\"top\">".$rowt[update_time]."</td>
					<td valign=\"top\">".$s_status."</td>
					
			</tr>";
					}

					echo "</tbody></table></div>";
						
				}else{
					echo "<hr class=\"hr0\"><table align=\"center\"  style=\"font-size:15px\" border=\"1\" cellpadding=\"3\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
					echo "<tr bordercolor=\"#000000\" bgcolor=\"#FFFF99\"><td>您好<font color=\"green\"><b><u>'".$_SESSION[username]."'</u></b></font>，抱歉未检索到你需要的渠道信息'<a href=\"searcher.php\"  style=\"text-decoration:none\" >重新检索</a>'渠道号</td></tr>";
					echo "</table></div>";
				}

			}else{
				$classaction->get_show_msg("searcher.php","0","<font color=red><b>传递参数字符不合法，您的恶意相关操作信息已发送给管理员！</b></font>","8");
			}
		}
		function searchKeyword($sourceidkey,$uid,$f_id,$s_status,$p_id,$v_id){ //检索此渠道号有哪些
			//$sourceidkey:关键字
			//$uid:用户UID，session，$f_id:功能，$s_status:处理状态，$p_id:环境，$v_id:版本id
			$sql="SELECT *  FROM `source` WHERE  s_value LIKE '%$sourceidkey%' AND f_id LIKE '%$f_id%' AND p_id LIKE '%$p_id%' AND s_status LIKE '%$s_status%' AND v_id LIKE '%$v_id%' AND uid LIKE '%$uid%'";
			$sql=mysql_query($sql);
	return $sql;
}
?>

<?php
include('foot.php');
?>
