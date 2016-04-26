<?php
include('header.php');
$arr=$classuser->user_shell($_SESSION[uid], $_SESSION[user_shell],6,$_SESSION[times],$_SESSION[mail]);
if($i=$classuser->del_auth("source","$_SESSION[uid]","6")){
	if(isset($_GET)&&(preg_match('/^\d*$/',"$_GET[del]"))){
		// now time - update time 
		$del_SubmitUpdatetime=mysql_query("SELECT update_time,s_status FROM source where s_id='$_GET[del]'");
		$del_SubmitUpdatetime=mysql_fetch_array($del_SubmitUpdatetime);
		$del_s_status=$del_SubmitUpdatetime[s_status]; //处理状态.1:未处理，0:已处理完成
		$del_Time = strtotime(date("Y-m-d h:i:s"));
		$del_Time = date("Y-m-d h:i:s",$del_Time);
		$del_Time=strtotime($del_Time);
		$del_SubmitUpdatetime=strtotime($del_SubmitUpdatetime[update_time]);
		$del_Diff=$del_Time-$del_SubmitUpdatetime;
		// END - now time - update time
		$del_Diff=ceil($del_Diff/86400);
		if($del_Diff<=2 && $del_s_status =='1'){ //判断最后修改时间到当前时间是否小于两天，并且处理状态需是未处理
			$del_sql=mysql_query("DELETE FROM `source` WHERE `source`.`s_id` = '$_GET[del]' and uid='$_SESSION[uid]' LIMIT 1");
			$classaction->get_show_msg("source_list_id.php","1","已删除！");
		}else{
			if($del_s_status==1){
				$del_s_status="<font color=red>未处理（×）</font>";
			}else {
				$del_s_status="<font color=green>已处理（√）</font>";
			}
			$classaction->get_show_msg("source_list_id.php","0","对不起！可能以下信息不符合，导致无法删除数据！<br>渠道包状态：".$del_s_status."<br>修改时间差值：<font color=red>已超过\"1\"天</font>","5");
			
		}
		//		ceil(($time-$del_SubmitUpdatetime)/86400);
	}else{
		$classaction->get_show_msg(source_list_id.php,"0","含有非法字符！","3");
	}
	//	$sql=mysql_query("DELETE FROM `source` WHERE `source`.`s_id` = 55 LIMIT 1");
}else{
	$classaction->get_show_msg(source_list_id.php,"0","对不起，你不具备删除权限","3");
}
