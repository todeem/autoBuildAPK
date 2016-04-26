<?php
include('header.php');
include('class/class.upfile.php');
include('class/class.show.php');
function deldir($dir) {
	$dh=opendir($dir);
	while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				deldir($fullpath);
			}
		}
	}
	closedir($dh);
	if(rmdir($dir)){
		return true;
	} else {
		return false;
	}
}
function  pgrep($input) {
	preg_match_all('/.*>(.*)</i',$input, $a);
	return   $a[1][0];
}
function  emptyFun($input){
	if(empty($input)){
		return "未取到,请联系".$administrator[mail];
	}else{
		return $input;
	}
}
?>
<style type="text/css">
.cc {
	
	font-size: 13px;
	padding: 6px;
	margin: 1px;
	border-bottom: 1px dashed rgb(231, 231, 231);
	text-shadow：1px 1px 1px rgb(226, 226, 226),1px 0 1px rgb(211, 211, 211)；
}

.aa {
	font-size: 13px;
	padding: 5px;
	position: relative;
	margin: 10px;
}

.cc span {
	border-radius: 4px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	padding: 1px 5px;
	font-size: 13px;
	border-left: 4px solid red;
	border-right: 4px solid red;
	
}
</style>
<?php
if(!isset($_POST[submit])){
	if(!isset($_FILES)){
		$classaction->get_show_msg("showsourceid.php","0","提交数据出错，请返回后重新提交");
		exit();
	}
	$t=time();
	$dt=date("Y-m-d H:i:s",$t);
	$name=$_FILES[upfile][name];
	$type=$_FILES[upfile][type];
	$tempName=$_FILES[upfile][tmp_name];
	$error=$_FILES[upfile][error];
	$size=$_FILES[upfile][size]/1024/1024;
	$arr=$classuploadfile->uploadFile($name, $tempName, $size, $type, $error);//返回数组
	if($arr[0]==1){
		$msg = "错误:".$arr[1];// 返回错误信息
	}else{
		$apkn = basename($arr[1],".apk");
		exec("sh apktool d $arr[2] ./tmp/$apkn",$ouput);//由于无法在linux使用zip的函数，所以使用exec调用本地命令
		$sourid= exec("cat tmp/$apkn/assets/sourceid.txt");
		//NEW  XML类
		//		$xml = new XMLReader();
		//		$xml->open('tmp/$apkn/AndroidManifest.xml');
		//		$i=1;
		//		while ($xml->read()) {       //是否读取
		//			if ($xml->nodeType == XMLReader::TEXT) {   //判断node类型
		//				$package = $xml->getAttribute("package");
		//				$versionCode = $xml->getAttribute("android:versionCode");
		//				$versionName = $xml->getAttribute("android:versionName");
		//				$i++;
		//			}else{
		//				echo aaa;
		//			}
		//		}
		//		$xml->close();
		//		$package= exec("grep -o -P 'package=.*$' tmp/$apkn/AndroidManifest.xml");
		//		$versionCode = exec("grep -o -P 'android:versionCode=.[[:digit:]]+.' tmp/$apkn/AndroidManifest.xml");
		//		$versionCode = exec("grep -o -P 'android:versionCode=.[[:digit:]]+.' tmp/$apkn/AndroidManifest.xml");
		$xml = new XMLReader();
		$xml->open("./tmp/$apkn/AndroidManifest.xml");
		$i=1;
		while ($xml->read()) {
			$package = $xml->getAttribute("package");
			$versionCode = $xml->getAttribute("android:versionCode");
			$versionName = $xml->getAttribute("android:versionName");
		}
		$xml->close();
		
		$stringPath="tmp/".$apkn."/res/values/strings.xml";
		//platform 1测试，2demo，3正式
		$platform = exec("grep -o -P 'change_server\">(.*)<' $stringPath");
		$registerforgift_url = exec("grep -o -P 'registerforgift_url\">(.*)<' $stringPath");
		//zhuce_songka 1 开，2 关
		$zhuce_songka = exec("grep -o -P 'registerforgift_switch\">(.*)<' $stringPath");
		//autoupdate_switch 1 屏蔽， 2不屏蔽
		$autoupdate_switch = exec("grep -o -P 'autoupdate_switch\">(.*)<' $stringPath");
		//是否显示更多 1显示，2不显示
		$moreapp_switch = exec("grep -o -P 'moreapp_switch\">(.*)<' $stringPath");
		//是否显示打分
		$comment_switch = exec("grep -o -P 'comment_switch\">(.*)<' $stringPath");
		//是否启动推送
		$default_push_switch =  exec("grep -o -P 'default_push_switch\">(.*)<' $stringPath");
		//是否显示流量提示框
		$data_traffic_dialog_switch =  exec("grep -o -P 'data_traffic_dialog_switch\">(.*)<' $stringPath");
		//是否更新启动图
		$updata_welcomepic_switch =  exec("grep -o -P 'updata_welcomepic_switch\">(.*)<' $stringPath");
		
		
		$package=emptyFun($package);
		$versionCode=emptyFun($versionCode);
		$versionName=emptyFun($versionName);
		$registerforgift_url=emptyFun($registerforgift_url);
		$moreapp_switch=emptyFun($moreapp_switch);
		$comment_switch=emptyFun($comment_switch);
		$default_push_switch=emptyFun($default_push_switch);
		$data_traffic_dialog_switch = emptyFun($data_traffic_dialog_switch);
		$updata_welcomepic_switch =  emptyFun($updata_welcomepic_switch);
		
		if(pgrep($platform) == 1){
			$platform="测试环境";
		}else if(pgrep($platform) == 2){
			$platform="Demo环境";
		}else if(pgrep($platform) == 3){
			$platform="线上环境";
		}else{
			$platform="未取到,请联系".$administrator[mail];
		}
		//注册送卡
		if(pgrep($zhuce_songka) == 1){
			$zhuce_songka="是";
		}else if(pgrep($zhuce_songka) == 2){
			$zhuce_songka="否";
		}else{
			$zhuce_songka="未取到,请联系".$administrator[mail];
		}
		//自动更新
		if(pgrep($autoupdate_switch) == 1){
			$autoupdate_switch="是";
		}else if(pgrep($autoupdate_switch) == 2){
			$autoupdate_switch="否";
		}else{
			$autoupdate_switch="未取到,请联系".$administrator[mail];
		}
		//更多应用
		if(pgrep($moreapp_switch) == 1){
			$moreapp_switch = "是";
		}elseif(pgrep($moreapp_switch) == 2){
			$moreapp_switch = "否";
		}else{
			$moreapp_switch="如果是3.5.1以前版本，并不存在此选项,或联系".$administrator[mail];
		}
		//是否显示打分
		if(pgrep($comment_switch)==1){
			$comment_switch = "是";
		}else if(pgrep($comment_switch)==2){
			$comment_switch = "否";
		}else{
			$comment_switch="如果是3.5.1以前版本，并不存在此选项,或联系".$administrator[mail];
		}
		
		if(pgrep($default_push_switch)==1){
			$default_push_switch = "是";
		}else if(pgrep($default_push_switch)==2){
			$default_push_switch = "否";
		}else{
			$default_push_switch = "如果是3.5.1以前版本，并不存在此选项,或联系".$administrator[mail];
		}
		
		if(pgrep($data_traffic_dialog_switch)==1){
			$data_traffic_dialog_switch = "是";
		}else if(pgrep($data_traffic_dialog_switch)==2){
			$data_traffic_dialog_switch = "否";
		}else{
			$data_traffic_dialog_switch = "如果是3.5.1以前版本，并不存在此选项,或联系".$administrator[mail];
		}
		
		if(pgrep($updata_welcomepic_switch)==1){
			$updata_welcomepic_switch= "随运营更新启动图";
		}else if(pgrep($updata_welcomepic_switch)==2){
			$updata_welcomepic_switch = "固定启动图";
		}else{
			$updata_welcomepic_switch = "如果是3.5.1以前版本，并不存在此选项,或联系".$administrator[mail];
		}
		
		
		
		
		if(file_exists($arr[2])){//文件存在则
			if((!unlink($arr[2])) || (!deldir("./tmp/".$apkn))){//不能删除则
				file_put_contents("error/running.zip.error", $dt." - error | 清理zip残余失败\r\n",FILE_APPEND);
			}
		}else{
			file_put_contents("error/running.zip.error", $dt." - error | ".$arr[1]."文件不存在,无法清除\r\n",FILE_APPEND);
		}
	}
}
?>

<div class="divline">
<form action="" enctype="multipart/form-data" method="post" name="form">
<div class="hide" id="1"><b>上传文件</b><input type="hidden"></div>
<div class="upleft" id="all"
	style="font-size: 18px; border: 1px solid #ccc;"">
<div class="upleft">
<div class="upbrowse" id="upbrowse1" date-id="1"><input name="upfile"
	type="file" id="upfile1"
	onchange="if(!upFileName(this.id)){this.value = ''};this.focus();  "></div>
</div>
<div class="upleft"><input type="submit" value="上传查看"
	style="height: 28px; width: 76px; font-weight: bold;"></div>
<div class="aa">
<div class="cc">渠道号：<span><font><b><?php echo $sourid; ?></b></font></span></div>
<div class="cc">package：<span><font><b><?php echo $package; ?></b></font></span></div>
<div class="cc">versionCode：<span><font><b><?php echo $versionCode; ?></b></font></span></div>
<div class="cc">versionName：<span><font><b><?php echo $versionName;  ?></b></font></span></div>
<div class="cc">环境：<span><font><b><?php echo $platform;  ?></b></font></span></div>
<div class="cc">wap.url：<span><font><b><?php echo pgrep($registerforgift_url);  ?></b></font></span>(注册包下发礼品卡用)</div>
<div class="cc">是否开启注册送卡：<span><font><b><?php echo $zhuce_songka;  ?></b></font></span></div>
<div class="cc">是否屏蔽更新：<span><font><b><?php echo $autoupdate_switch;  ?></b></font></span></div>


<div class="cc">是否显示更多应用：<span><font><b><?php echo $moreapp_switch;  ?></b></font></span></div>
<div class="cc">是否显示打分：<span><font><b><?php echo $comment_switch;  ?></b></font></span></div>
<div class="cc">是否启动推送消息：<span><font><b><?php echo $default_push_switch;  ?></b></font></span></div>
<div class="cc">是否显示流量提示框：<span><font><b><?php echo $data_traffic_dialog_switch;  ?></b></font></span></div>
<div class="cc">是否更新启动图：<span><font><b><?php echo $updata_welcomepic_switch;  ?></b></font></span></div>
<br>
<div style="clear: both;"></div>
</div>
</div>
<div style="clear: both;"></div>
</form>
</div>


<?php
include('./foot.php');
?>