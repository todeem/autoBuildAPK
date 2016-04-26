<?php
include("./header.php");
$arr=$classuser_m->user_shell($_SESSION[uid], $_SESSION[user_shell],5,$_SESSION[times],$_SESSION[mail]);
?>

<div class="divline">

<div id="left">



</div>
<div class="hide" id="envhide">Android无签名包<img class="imghide" id="a" src="../image/hide.gif" align="right" alt="显示隐藏"><br></div> 
<div class="left" id="colation" name="colation" >
<table align="center" id="myTable" class="tablesorter" style="font-size:14px;width:100%;">
<thead>
	<tr >
		<th style=\"text-align: center;\" scope=\"col\">ID</th>
		<th scope=\"col\">版本号</th>
		<th style=\"text-align: center;\" scope=\"col\">平台</th>
		<th scope=\"col\">渠道包名称</th>
		<th style=\"text-align: center;\" scope=\"col\">大小(M)</th>
		<th style=\"text-align: center;\" scope=\"col\">环境</th>
		<th style=\"text-align: center;\" scope=\"col\">功能</th>
		<th style=\"text-align: center;\" scope=\"col\">Code</th>
		<th style=\"text-align: center;\" scope=\"col\">提交者</th>
		<th style=\"text-align: center;\" scope=\"col\">时间</th>
	</tr></thead><tbody>
		<?php
		$envSql=mysql_query("SELECT v_id FROM  `version`");
		$total = mysql_num_rows($envSql);
		 pageft($total, 20);
		if ($firstcount < 0) $firstcount = 0;
		$envSqllimit=mysql_query("SELECT * FROM `version` order by v_version Desc limit   $firstcount, $displaypg");
		while($verRow=mysql_fetch_array($envSqllimit)){
				if($verRow[client_platform]=='0'){
					$client_platform="VANCL";
				}
				if ($verRow[client_platform]=='1'){
					$client_platform="XSG";
				}
				echo "<tr id=\"a\"><td  style=\"text-align: center;\"> $verRow[v_id]</td>
				<td >$verRow[v_version]</td>
				<td style=\"text-align: center;\">$client_platform</td>
				<td>$verRow[v_packname]</td>
				<td style=\"text-align: center;\">$verRow[size]</td>
				<td style=\"text-align: center;\">$verRow[v_env]</td>
				<td style=\"text-align: center;\">$verRow[v_function]</td>
				<td style=\"text-align: center;\">$verRow[v_versioncode]</td>
				
				<td style=\"text-align: center;\">$verRow[user]</td>
				<td style=\"text-align: center;\">$verRow[submittime]</td>
				</tr>";
	}
	?>
		</tbody>
		<tr>
		<th colspan="10" style="font-weight:normal"><?php echo $pagenav;?></th>
	</tr>
</table>
</div>
<br/>

<div class="hide" id="xsghide">Android 限时购客户端无签名包<img class="imghide" id="c" src="../image/hide.gif" align="right" alt="显示隐藏"><br></div> 
<div class="left" id="xsgcolation" name="xsgcolation" >
<table align="center" id="myTable" class="tablesorter" style="font-size:14px;width:100%;">
<thead>
	<tr >
		<th style=\"text-align: center;\" scope=\"col\">ID</th>
		<th scope=\"col\">版本号</th>
		<th style=\"text-align: center;\" scope=\"col\">平台</th>
		<th scope=\"col\">渠道包名称</th>
		<th style=\"text-align: center;\" scope=\"col\">大小(M)</th>
		<th style=\"text-align: center;\" scope=\"col\">环境</th>
		<th style=\"text-align: center;\" scope=\"col\">功能</th>
		<th style=\"text-align: center;\" scope=\"col\">Code</th>
		<th style=\"text-align: center;\" scope=\"col\">提交者</th>
		<th style=\"text-align: center;\" scope=\"col\">时间</th>
	</tr></thead>
	<tbody>
		<?php
		$xsgSql=mysql_query("SELECT v_id FROM  `version` where client_platform=1");
		$total = mysql_num_rows($xsgSql);
		 pageft($total, 20);
		if ($firstcount < 0) $firstcount = 0;
		$xsgSqllimit=mysql_query("SELECT * FROM `version` where client_platform=1 order by v_version Desc limit   $firstcount, $displaypg");
		while($xsgverRow=mysql_fetch_array($xsgSqllimit)){
				if($xsgverRow[client_platform]=='0'){
					$xclient_platform="VANCL";
				}
				if ($xsgverRow[client_platform]=='1'){
					$xclient_platform="XSG";
				}
				echo "<tr id=\"a\"><td  style=\"text-align: center;\"> $xsgverRow[v_id]</td>
				<td >$xsgverRow[v_version]</td>
				<td style=\"text-align: center;\">$xclient_platform</td>
				<td>$xsgverRow[v_packname]</td>
				<td style=\"text-align: center;\">$xsgverRow[size]</td>
				<td style=\"text-align: center;\">$xsgverRow[v_env]</td>
				<td style=\"text-align: center;\">$xsgverRow[v_function]</td>
				<td style=\"text-align: center;\">$xsgverRow[v_versioncode]</td>
				
				<td style=\"text-align: center;\">$xsgverRow[user]</td>
				<td style=\"text-align: center;\">$xsgverRow[submittime]</td>
				</tr>";
	}
	?>
		</tbody>
		<tr>
		<th colspan="10" style="font-weight:normal"><?php echo $pagenav;?></th>
	</tr>
</table>
</div>



<br/>
<div class="hide" id="sourcehide">运营已提交渠道号<img class="imghide" id="b" src="../image/hide.gif" align="right" alt="显示隐藏"></div> 
<div class="left"  id="sourcehidediv" name="sourcehidediv">
<table align="center" id="sourcetable" class="sourcetable" style="font-size:14px;width:100%;">
<thead>
	<tr id="a">
		<th scope=\"col\">序<font style="font-weight:normal">(共<?php echo $total;?>)</font></th>
		<th style=\"text-align: center;\">平台</th>
		<th scope=\"col\">版本<font style="font-weight:normal">(有链接提示)</font></th>
		<th scope=\"col\">环境</th>
		<th scope=\"col\">功能</th>
		<th scope=\"col\">状态</th>
		<th scope=\"col\">FTP</th>
		<th scope=\"col\">抄送</th>
		<th scope=\"col\">提交者</th>
		<th scope=\"col\">备注</th>
		<th scope=\"col\">提交时间</th>
		<th scope=\"col\">最后修改</th>
		<th scope=\"col\">手动</th>
	</tr></thead><tbody>
		<?php
		$sSql=mysql_query("SELECT s_id FROM  `source`");
		$total = mysql_num_rows($sSql);
		 pageft($total, 50);
		if ($firstcount < 0) $firstcount = 0;
		$sSqllimit=mysql_query("SELECT * FROM `source` ORDER BY s_id DESC  limit   $firstcount, $displaypg");
		while($sRow=mysql_fetch_array($sSqllimit)){
//			$svSql=mysql_query("SELECT v_packname FROM version WHERE v_id='$sRow[v_id]'");
			
			$svSql=mysql_query("SELECT p.p_name,f.f_name,v.v_packname,v.client_platform,u.username from source s,platform p,function f,version v,user_admin u where v.v_id=s.v_id and f.f_venv=s.f_id and u.uid=s.uid and p.p_venv=s.p_id and s.s_id='$sRow[s_id]' ");
			$svRow=mysql_fetch_array($svSql);
			if($sRow[s_status]=='1'){
					$s_status="<font color=\"red\">未处理</font>";
					$runpack='<input style="height:21px;width:80px" type="button" id='.$sRow[s_id].' name='.$sRow[s_id].' value="打包" >';
				}else if($sRow[s_status]=='0'){
					$s_status="<font color=\"green\">已处理</font>";
					$runpack='<input style="height:21px;width:80px"  disabled="true" type="button" id='.$sRow[s_id].' name='.$sRow[s_id].' value="完成" >';
				}else if($sRow[s_status]=='2'){
					$percentage = $sRow[percentage];
					$progress=  @file_get_contents("../progress/$sRow[s_id].progress",r);
					$progress = $progress ? $progress :0;
					$alt = "Status:".$progress."/Total".$percentage;
					$s_status="<a class=\"preview\" href=\"#\" id=\"bar$sRow[s_id]\" alt=\"$alt\"><img src=\"../image/load.gif\" class=\"$sRow[s_id]\"  id=\"$sRow[s_id]\" height=\"8px\" width=\"40px\"></a>";
					$runpack='<input style="height:21px;width:80px"  disabled="true" type="button" id='.$sRow[s_id].' name='.$sRow[s_id].' value="Running..." >';
				}
				if($svRow[client_platform]=='0'){
					$sclient_platform="VANCL";
				}
				if ($svRow[client_platform]=='1'){
					$sclient_platform="XSG";
				}
			$u_mailcc=str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $sRow[u_mailcc]));
			$ftp=str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $sRow[ftp]));
			$s_describe=str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $sRow[s_describe]));
			echo "<tr id=\"a\" ><td style=\"text-align: center;\">$sRow[s_id]</td>
				<td style=\"text-align: center;\">$sclient_platform</td>
				<td style=\"text-align: center;\"><a class=\"preview\" href=\"#\" alt=\"(序号：$sRow[s_id]) - unsigned包名：$svRow[v_packname]\">$sRow[v_version]</a></td>
				<td style=\"text-align: center;\">$svRow[p_name]</td>
				<td style=\"text-align: center;\">$svRow[f_name]</td>
				<td style=\"text-align: center;\" class=\"$sRow[s_id]\" id=\"$sRow[s_id]\" data-sum=\"$sRow[percentage]\">$s_status</td>

				<td style=\"text-align: center;\"><a class=\"preview\" href=\"#\" alt=\"$ftp\"><img src=\"../image/user.gif\"></a></td>		
				<td style=\"text-align: center;\"><a class=\"preview\" href=\"#\" alt=\"$u_mailcc\"><img src=\"../image/cc.png\" width=\"18\"  height=\"18\"></a></td>
				<td style=\"text-align: center;\">$svRow[username]</td>
				<td style=\"text-align: center;\"><a class=\"preview\" href=\"#\" alt=\"$s_describe\"><img src=\"../image/note.png\"></a></td>
				<td style=\"text-align: center;\">$sRow[s_submitdatetime]</td>
				<td style=\"text-align: center;\">$sRow[update_time]</td>
				<td style=\"text-align: center;\">
				<span  style=\"height:100%px;width:100%px\">
				$runpack 
				</span>
				</td>
				</tr>";		
	}

	?>
		</tbody>
		<tr>
		<th colspan="13" style="font-weight:normal"><?php echo $pagenav;?></th>
	</tr>
</table>


</div>
<div style="clear:both;"></div>
</div>


<?php 

	
include('../foot.php');


?>

 
