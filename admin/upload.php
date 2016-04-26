<?php
include('./header.php');
$arr=$classuser_m->user_shell($_SESSION[uid], $_SESSION[user_shell],2,$_SESSION[times],$_SESSION[mail]);
?>
<?php
if(!isset($_POST[submit])){
	if(!isset($_FILES)){
		$classaction_m->get_show_msg("upfile.php","0","提交数据出错，请返回后重新提交");
		exit();
	}
	$err="";
	$count=$_POST[count];
	$countFile=count($_FILES[upfile][name]);//文件个数
	for($i=1;$i<=$count;$i++){
		$ver[]=$_POST[ver.$i];
		$versioncode[]=$_POST[versioncode.$i];
		$plat[]=$_POST[plat.$i];
		$clientplat[]=$_POST[clientplatform.$i];
		$flat[]=$_POST[flat.$i];
	}
	for($j=0;$j<$countFile;$j++){
		$name[]=$_FILES[upfile][name][$j];
		$error[]=$_FILES[upfile][error][$j];
		$tmpName[]=$_FILES[upfile][tmp_name][$j];
		$size[]=$_FILES[upfile][size][$j]/1024/1024;
		$type[]=$_FILES[upfile][type][$j];
	}
	for($j=0;$j<$countFile;$j++){
		$arr=$classuploadfile->uploadFile($name[$j],$tmpName[$j],$size[$j],$type[$j],$error[$j]);
		if($arr[0]==1){
			$err.="<tr id=\"a\" ><td>".$name[$j]."</td><td style=\"text-align: center;\">".$ver[$j]."</td><td style=\"text-align: center;\">".$clientplat[$j]."</td><td style=\"text-align: center;\">".$plat[$j]."</td><td style=\"text-align: center;\">".$flat[$j]."</td><td style=\"text-align: center;\">".$versioncode[$j]."</td></tr>";
		}else{
			$sql="INSERT INTO `version` (
		`v_id`, `user` ,`v_versioncode`, `v_packname`,`client_platform`, `size`, `v_path`, `v_function`, `v_version`, `v_env` ,`submittime`
		) VALUES (NULL, '$_SESSION[username]' ,'$versioncode[$j]', '$name[$j]', '$clientplat[$j]', '$size[$j]', '".UPFILEPATH."', '$flat[$j]', '$ver[$j]', '$plat[$j]', NOW() )";
			$sql=mysql_query($sql);//提交
			$right.="<tr id=\"a\" ><td>".$name[$j]."</td><td style=\"text-align: center;\">".$ver[$j]."</td><td style=\"text-align: center;\">".$clientplat[$j]."</td><td style=\"text-align: center;\">".$plat[$j]."</td><td style=\"text-align: center;\">".$flat[$j]."</td><td style=\"text-align: center;\">".$versioncode[$j]."</td><td style=\"text-align: center;\">".$size[$j]."</td><td style=\"text-align: center;\">".UPFILEPATH."</td></tr>";
		}

	}
	if(!empty($err)){
		$omm="（<font color='red' style='font-size:13px;'>存在失败提交：[".$arr[1]."]</font>）";
	}else{
		$omm="（<font color=green><b>全部提交</b></font>）";
	}


	$upmsg='<div class="divline">
		<div class="hide">成功信息：'.$omm.'</div>
		<div class="upleft">
		<table align="center" id="sourcetable" class="sourcetable" style="font-size:14px;width:100%;">
		<thead>
			<tr id="a">
				<th scope="col">包名</th>
				<th style="text-align: center;" scope="col">版本</th>
				<th style="text-align: center;" scope="col">平台</th>
				<th style="text-align: center;" scope="col">环境</th>
				<th style="text-align: center;" scope="col">功能</th>
				<th style="text-align: center;" scope="col">versionCode</th>
				<th style="text-align: center;" scope="col">文件大小</th>
				<th style="text-align: center;" scope="col">存放路径</th>
			</tr>
		</thead>
				
		<tbody>' . $right . '</table></div>
		<div class="hide" style="background-color: #ccc;color:#F00;font-weight:bold">失败信息</div>
		<div class="upleft">
		<table align="center" id="sourcetable" class="sourcetable" style="font-size:14px;width:100%;">
		<thead>
			<tr id="a">
				<th scope="col">包名</th>
				<th style="text-align: center;" scope="col">版本</th>
				<th style="text-align: center;" scope="col">平台</th>
				<th style="text-align: center;" scope="col">环境</th>
				<th style="text-align: center;" scope="col">功能</th>
				<th style="text-align: center;" scope="col">versionCode</th>
			</tr>
		</thead>
		<tbody>'.$err.'</tbody>
		</table>
		</div>

		</div>';
	echo $upmsg;

}else{
	$classaction_m->get_show_msg("upfile.php","0","提交数据出错，请返回后重新提交");
	exit();
}

?>

<?php
include('../foot.php');
?>

