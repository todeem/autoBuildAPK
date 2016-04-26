<?php
include('header.php');
$arr=$classuser->user_shell($_SESSION[uid], $_SESSION[user_shell],9,$_SESSION[times],$_SESSION[mail]);
if($_SESSION[user_shell]==md5($_SESSION[username].$_SESSION[mail].ALL_PS)){
	$uid=$_SESSION[uid];
	$sqlID="SELECT * FROM `source` where uid='$uid'";
	$version1=mysql_query("SELECT username FROM `user_admin` where uid='$uid'");
	$version=mysql_fetch_array($version1);
	$sqlID=mysql_query($sqlID);
	$us = is_array($rowID=mysql_fetch_array($sqlID));
	$uus = $us ? TRUE : FALSE;
	
	echo "<div style=\"border: 1px solid #cc;border: 2px dashed #ccc;	margin:10px 2px 3px 2px;padding:10 10 10 5px;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;\"><table align=\"center\"  style=\"font-size:14px\" border=\"1\" cellpadding=\"5\" bordercolor=\"#FF0000\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
	echo "<tr><td><font color=red><b>环境标识说明</b></font>（ 1：官网环境online， 2：模拟环境demo， 3：测试环境test ）</td></tr>";
	echo "<tr><td><font color=red><b>功能标识说明</b></font>（ 0：官网版本, 1：首次下卡屏蔽更新, 2：仅屏蔽更新 ）</td></tr>";
	echo "</table>";
	if($uus){
		$s_idSql=mysql_query("SELECT s_id FROM  `source`");
		$total = mysql_num_rows($s_idSql);
		pageft($total, 50);
		if ($firstcount < 0) $firstcount = 0;
		echo "<hr><table id=\"myTable\" class=\"tablesorter\" align=\"center\"  style=\"font-size:14px;border: solid 1px #f90;border-collapse: collapse;\" border=\"1\" cellpadding=\"5\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
		echo "<thead><tr bordercolor=\"#000000\" bgcolor=\"#FFFF99\">
					<th  scope=\"col\">序号</th>
					<th  scope=\"col\">平台</th>
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
					<th scope=\"col\">　操作　</th>
			</tr></thead><tbody style=\"font-size:13px;\">";
		$sql="SELECT * FROM `source` where uid='$uid' order by update_time desc,s_id asc limit $firstcount, $displaypg";
		$sql=mysql_query($sql);
		while($rowt=mysql_fetch_array($sql)){
			$rowt_s_value_look=str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $rowt[s_value]));
			$rowt_s_value_look_array=explode("<br>", "$rowt_s_value_look");
			$total=ceil(count($rowt_s_value_look_array));
			$svSql=mysql_query("SELECT s.client_platform,p.p_name,f.f_name,v.v_packname,u.username from source s,platform p,function f,version v,user_admin u where v.v_id=s.v_id and f.f_venv=s.f_id and u.uid=s.uid and p.p_venv=s.p_id and s.s_id='$rowt[s_id]' ");
			$svRow=mysql_fetch_array($svSql);
			if($rowt[s_status]=='1'){
				$s_status="<font color=\"red\">未处理</font>";
			}
			if($rowt[s_status]=='0'){
				$s_status="<font color=\"green\">已处理</font>";
			}
			if($svRow[client_platform]=='0'){
				$client_platform="VANCL";
			}
			if ($svRow[client_platform]=='1'){
				$client_platform="XSG";
			}
		if($rowt[s_status]=='2'){
					$percentage = $rowt[percentage];
					$progress=  @file_get_contents("../progress/$rowt[s_id].progress",r);
					$progress = $progress ? $progress :0;
					$alt = "Status:".$progress."/Total".$percentage;
					$s_status="<a class=\"preview\" href=\"#\" id=\"bar$rowt[s_id]\" alt=\"$alt%\"><img src=\"image/load.gif\" class=\"$rowt[s_id]\" id=\"$rowt[s_id]\" height=\"8px\" width=\"40px\"></a>";
			}
			$rn=rand(20,500).md5($version[username]);
			echo "<tr class=\"a\" id=\"a\" style=\"text-align: center;\">
					<td valign=\"top\">".$rowt[s_id]."</td>
					<td valign=\"top\">".$client_platform."</td>
					<td valign=\"top\"><a class=\"preview\" href=\"#\" alt=\"(序号：$rowt[s_id]) - unsigned包名：$svRow[v_packname]\">$rowt[v_version]</a></td>
					<td valign=\"top\">".$svRow[p_name]."</td>
					<td valign=\"top\">".$svRow[f_name]."</td>
					<td valign=\"top\">".$version[username]."</td>
					<td valign=\"top\">".$rowt[mail]."</td>
					<td valign=\"top\">".$rowt[u_mailcc]."</td>
					<td valign=\"top\" align=\"left\">　<a href=\"submit_source_xinxi.php?id=$rowt[s_id]&page=1\">详细</a>　(共".$total."个)　</td>
					<td valign=\"top\">".$rowt[s_submitdatetime]."</td>
					<td valign=\"top\">".$rowt[update_time]."</td>
					<td valign=\"top\" id=\"$rowt[s_id]\" data-sum=\"$percentage\">".$s_status."</td>
					<td valign=\"top\">　<a href=\"mobify.php?s_id=$rowt[s_id]\">修改</a> | <a href=\"del.php?del=$rowt[s_id]&rn=$rn\">删除</a>　</td>	
			</tr>";
		}

		echo "</tbody><th colspan=\"12\" style=\"font-weight:normal\">".$pagenav."</th></table></div>";
	}else{
		echo "<hr><table align=\"center\"  style=\"font-size:15px\" border=\"1\" cellpadding=\"3\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
		echo "<tr bordercolor=\"#000000\" bgcolor=\"#FFFF99\"><td>您好<font color=\"green\"><b><u>'".$_SESSION[username]."'</u></b></font>，暂时您未提交过数据，如需要Android安装包，请点击'<a href=\"submit_source.php\"  style=\"text-decoration:none\" >提交渠道号</a>'链接进行相关操作</td></tr>";
		echo "</table></div>";
	}
}else{
	$classaction->get_show_msg("index.php",'','无查看权限','5');
	exit(000);
}
?>
<?php 
include('foot.php');
?>