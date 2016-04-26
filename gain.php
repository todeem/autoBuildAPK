<?php
include('conf/config.php');
include_once('class/class.action.php');
include_once('class/class.mysql.php');
$db = new mysql(DB_HOST, DB_USER, DB_PASSWORD, DB_DATA, '', MYDBCHARSET);
if (isset($_POST)){
	if(isset($_POST[clientid])){
		$clientid = $_POST[clientid];
		$client_query=mysql_query("SELECT v_version, v_id FROM `version` where client_platform = '$clientid'   GROUP BY v_version  order by v_version Desc");
		echo "<option value='-1'>请选择版本</option>";
		while ($client_row=mysql_fetch_array($client_query)) {
		echo "<option value=\"$client_row[v_id]\">$client_row[v_version]</option>";
	}
	}
	
	if(isset($_POST[platverid]) && (isset($_POST[cpid]))){
		$platform_query=mysql_query("select p.p_name,p.p_venv from platform p,version v where p.p_venv=v.v_env and v.v_version=(select v_version from version where v_id='$_POST[platverid]' ) GROUP BY p.p_venv  order by p.p_venv Desc");
		echo "<option value='-1'>请选择环境</option>";
		while ($platform_row=mysql_fetch_array($platform_query)) {
			echo "<option value=\"$platform_row[p_venv]\">$platform_row[p_name]</option>";
		}
	}
	if(isset($_POST[funplatid]) && (isset($_POST[funverid]))){
		echo $fplat=$_POST[funplatid];
		echo $fver=$_POST[funverid];
		$functionquery=mysql_query("select f_name,f_venv from function where f_venv in (select v_function from version where v_env= '$fplat' and  v_version = (select v_version from version where v_id='$fver' )) GROUP BY f_venv ORDER BY f_venv DESC");
		echo "<option value='-1'>请选择功能</option>";
		while ($functionrow=mysql_fetch_array($functionquery)) {
			echo "<option value=\"$functionrow[f_venv]\">".$functionrow[f_name]."</option>";
		}
	}
	if(isset($_POST[valfunid]) && isset($_POST[valplatid]) && isset($_POST[valverid])){
		$fun=$_POST[valfunid];$plat=$_POST[valplatid];$ver=$_POST[valverid];
		//echo	"fun:\"".$fun."\"平台:".$plat."版本：".$ver;

		$query1=mysql_query("SELECT * FROM `version` where v_env='$plat' and v_function='$fun' and v_version = (select v_version from `version` where v_id='$ver')");
		$queryy=mysql_query("SELECT * FROM `version` where v_env='$plat' and v_function='$fun' and v_version = (select v_version from `version` where v_id='$ver')");
		$arrTF = is_array($gainrow2=mysql_fetch_array($queryy));
		$TF = $arrTF ? TRUE : FALSE;
		echo "<font color=red ><b>* 数据库内存在此包信息：</b></font><br>";
		echo "<table  style=\"font-size:13px\" border=\"1\" cellpadding=\"3\" bordercolor=\"#666666\" bordercolorlight=\"#33FF00\" bordercolordark=\"#CCFF00\" cellspacing=\"0\" >";
		if($TF){
			while($gain_row=mysql_fetch_array($query1)){
				echo "<tr><td>唯一标识(V_ID)：</td><td>".$gain_row[v_id]."</td></tr><tr><td>包名称：</td><td>".$gain_row[v_packname]."</td></tr><tr><td>特殊功能:</td><td>".$gain_row[v_function]."<font color=\"#999\">　- 说明（  0：官网版本, 1：首次下卡屏蔽更新, 2：仅屏蔽更新 ）</font></td></tr><tr><td>版本号:</td><td>".$gain_row[v_version]."</td></tr><tr><td>环境:</td><td>".$gain_row[v_env]."<font color=\"#999\">　- 说明（ 1：官网环境online， 2：模拟环境demo， 3：测试环境test ）</font></td></tr>";
			}
			echo "</table>";
		}else{
			echo "<font color=red>抱歉：数据库内无此包，请重新选择，或联系管理员处理:</font>".$administrator[mail];
		}
	}
}



?>
