<?php
include('header.php');
$arr=$classuser->user_shell($_SESSION[uid], $_SESSION[user_shell],9,$_SESSION[times],$_SESSION[mail]);
if($_SESSION[user_shell]==md5($_SESSION[username].$_SESSION[mail].ALL_PS)){
	if(isset($_GET[id])){
		$sql="SELECT * FROM `source` where s_id='$_GET[id]'";
		$sqlPD="SELECT * FROM `source` where s_id='$_GET[id]'";
		$sqlPD=mysql_query($sqlPD);
		$us = is_array($rowo=mysql_fetch_array($sqlPD));
		$uus = $us ? TRUE : FALSE;
		echo "<br><table align=\"center\"  style=\"font-size:14px\" border=\"1\" cellpadding=\"5\" bordercolor=\"#FF0000\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
		echo "<tr><td><font color=red><b>环境标识说明</b></font>（ 1：官网环境online， 2：模拟环境demo， 3：测试环境test ）</td></tr>";
		echo "<tr><td><font color=red><b>功能标识说明</b></font>（ 0：官网版本, 1：首次下卡屏蔽更新, 2：仅屏蔽更新 ）</td></tr>";
		echo "</table>";
		if($uus){
			$sql=mysql_query($sql);
			$version1=mysql_query("select s.client_platform,v.v_version,ua.username,fun.f_name,plat.p_name from version v,user_admin ua,source s,function fun,platform plat where v.v_id=s.v_id and ua.uid=s.uid and fun.f_venv=s.f_id and plat.p_venv=s.p_id and s.s_id='$_GET[id]'");
			$version=mysql_fetch_array($version1);
			echo "<hr><table align=\"center\"  style=\"font-size:14px;\" border=\"1\" cellpadding=\"5\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
			//print_r(mysql_fetch_array($sql));
			echo  "<caption ><font color=green ><b>如下数据为你此次提交部分重要信息</b></font></caption>";
			while($rowt=mysql_fetch_array($sql)){
				echo "<tr bordercolor=\"#000000\" bgcolor=\"#FFFF99\">
					<th  scope=\"col\">序号</th>
					<th  scope=\"col\">平台</th>
					<th  scope=\"col\">版本</th>
					<th  scope=\"col\">环境</th>
					<th  scope=\"col\">功能</th>
					<th  scope=\"col\">提交时间</th>
					<th  scope=\"col\">修改时间</th>
					<th  scope=\"col\">提交用户</th>
					<th scope=\"col\">发送邮件到</th>
					<th scope=\"col\">抄送邮件给</th>
					<th scope=\"col\">打包状态</th>
					<th scope=\"col\">　操作　</th>
			</tr>";
				$rowt_s_value=$rowt[s_value];
				$rowt_s_value_look=str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $rowt[s_value]));
				$rowt_s_value_look_array=explode("<br>", "$rowt_s_value_look");
				//			print_r($rowt_s_value_look_array);
				if($rowt[s_status]=='2'){
					$s_status="<font color=\"green\">处理中</font>";
				}
				if($rowt[s_status]=='1'){
					$s_status="<font color=\"red\">未处理</font>";
				}
				if($rowt[s_status]=='0'){
					$s_status="<font color=\"green\">已处理</font>";
				}
				if($version[client_platform]=='0'){
					$client_platform="VANCL";
				}
				if ($version[client_platform]=='1'){
					$client_platform="XSG";
				}
				$rn=rand(20,500).md5($version[username]);
				echo "<tr style=\"text-align: center;border: solid 1px #f90;border-collapse: collapse;\">
					<td  valign=\"top\">".$rowt[s_id]."</td>
					<td valign=\"top\">".$client_platform."</td>
					<td valign=\"top\">".$version[v_version]."</td>
					<td valign=\"top\">".$version[p_name]."</td>
					<td valign=\"top\">".$version[f_name]."</td>
					<td valign=\"top\">".$rowt[s_submitdatetime]."</td>
					<td valign=\"top\">".$rowt[update_time]."</td>
					<td valign=\"top\">".$version[username]."</td>
					<td valign=\"top\">".$rowt[mail]."</td>
					<td valign=\"top\">".$rowt[u_mailcc]."</td>	
					<td valign=\"top\">".$s_status."</td>	
					<td valign=\"top\">　<a href=\"mobify.php?s_id=$rowt[s_id]\">修改</a> | <a href=\"del.php?del=$rowt[s_id]&rn=$rn\">删除</a>　</td>
			</tr>";
				echo "<tr  bordercolor=\"#000000\" bgcolor=\"#FFFF99\">    <td colspan=\"5\" scope=\"col\"><font color=\"black\"><b>渠道号 </b></font><font style=\"font-size: 13px; font-family: 微软雅黑, arial, sans-serif;\">统,共计(<b>".$total=ceil(count($rowt_s_value_look_array))."</b>)</td ><td  colspan=\"7\"><font color=\"black\"><b>安装包存放信息</b>(FTP方式)</font></td></tr>";
				echo "<tr>    <td colspan=\"5\"  rowspan=\"3\">";
				$array=$rowt_s_value_look_array;
				$page=$_GET["page"]?$_GET["page"]:1;
				if($total>'100'){
					$tiaoshu=40;
				}else if($total<='30'){
					$tiaoshu=$total;
				}
				$r=page($array,$tiaoshu="20",$page);
				foreach($r["source"] as $s){
					echo $s."<br>";
				}
				
				echo "<hr>".$r["page"];
				echo "</td><td colspan=\"7\" style=\"vertical-align: TOP;height: 200px;width: 90%px;\" >";
				echo $rowt[ftp];
				echo "</td></tr>";
				echo "<tr>
				<td colspan=\"7\"  bordercolor=\"#000000\" bgcolor=\"#FFFF99\" ><font color=\"black\"><b>描述</b></font></td></tr>
				<tr><td colspan=\"7\" style=\"vertical-align: TOP;height:60;width: 90%px;\">".$rowt[s_describe]."</td></tr>
				
				</table>";
			}
		}else{
					echo  "ERROR,不存在此传参值：".$_GET[id];
		exit (0);
		}


		//print_r($rowt_s_value_look);
	}else{
		echo "传值好像出问题了";
	}
}else{
	$classaction->get_show_msg("index.php",'','无查看权限，请重新登陆后再试','5');
	exit(000);
}
?>

<?php
function page($array,$pagesize,$current="1"){
	$_return=array();
	/*calculator*/
	$total=ceil(count($array)/$pagesize);
	$prev=(($current-1)<=0 ? "1" : ($current-1));
	$next=(($current+1)>=$total ? $total : $current+1);
	if($next<$current||$prev>$current){
		echo  "不要这样玩好不好，乱传值？";
		echo "<a href=\"?id=$_GET[id]&&page=1\">返回到第一页</a>";
		exit(0);
	}
	$current=($current>($total)?($total):$current);
	$start=($current-1)*$pagesize;
	for($i=$start;$i<($start+$pagesize);$i++){
		array_push($_return,$array[$i]);
	}
	$pagearray["source"]=$_return;
	if($current<>'1'){
		$pagearray["page"]="<a href=\"?id=$_GET[id]&page=1\"><img src=\"image/first.gif\"></a>";
	}else {
		$pagearray["page"]="<img src=\"image/first.gif\" alt=\"别点了，没了，到头了\">";
	}
	if($prev<>$current){
		$pagearray["page"]=$pagearray["page"]."<a href=\"?id=$_GET[id]&page=$prev\"><img src=\"image/next.gif\"></a>";
	}else{
		$pagearray["page"]=$pagearray["page"]."<img src=\"image/next.gif\"  alt=\"不能上一页了\">";
	}
	if($next<>$current){
		$pagearray["page"]=$pagearray["page"]."<a href=\"?id=$_GET[id]&page=$next\"><img src=\"image/prev.gif\"></a>";
	}else{
		$pagearray["page"]=$pagearray["page"]."<img src=\"image/prev.gif\"  alt=\"不能下一页了\">";
	}
	if($total==$current && $current<>1){
		$pagearray["page"]=$pagearray["page"]."<img src=\"image/null.gif\"  alt=\"已在尾巴页面\">";
	}elseif($total==$current && $current==1){
		$pagearray["page"]=$pagearray["page"]."<img src=\"image/null.gif\"  alt=\"已在尾巴页面\">";
	}else{
		$pagearray["page"]=$pagearray["page"]."<a href=\"?id=$_GET[id]&page=$total\"><img src=\"image/after.gif\"></a>";
	}
	return $pagearray;
}

?>
	<?php
	include('foot.php');
	?>

