<?php

class upload {
	public function uploadFile($name,$tempName,$size,$type,$error){
		/* $_count:统计个数
		 *
		 *
		 *
		 */

		global $classaction;
		$uploadfile=TMP; //上传apk及写入source id 的路径
		if (is_writable($uploadfile)) {
			switch ($error){
				case "0": $errormsg="上传成功";
				break;
				case "1": $errormsg="不超过服务器端文件大小限制";
				break;
				case "2": $errormsg="不超过客户端文件大小限制";
				break;
				case "3": $errormsg="全部上传了";
				break;
				case "4": $errormsg="有文件上传";
				break;
				case "6": $errormsg="找不到临时文件夹";
				break;
				case "7": $errormsg="文件写入临时文件夹失败 ";
				break;
				case "10": $errormsg="不允许上传该类型文件";
				break;
			}
			if (is_uploaded_file($tempName)){
				$nameExtension=substr(strrchr($name,"."),1);//获取文件扩展名
				$nameExtension=strtolower($nameExtension);
				if ( stristr(UPFILETYPE,$nameExtension) && $error=="0" && $size <= UPFILESIZE){
					if (!file_exists($uploadfile)){
						mkdir($uploadfile);
					}
					$md5rand=md5($name.time().rand(1,100));
					if (!file_exists($uploadfile.$md5rand.$name)){
						move_uploaded_file($tempName,"$uploadfile$md5rand$name");
						$msg=array("0",$md5rand.$name,$uploadfile.$md5rand.$name);
						return $msg;
					}else{
						$msg=array("1",$errormsg."/服务器已存在相同数据！");
						return $msg;
					}
				}else{
					$msg=array("1",$errormsg."/上传错误错误码".$errormsg."或文件大小不符合！");
					return $msg;
				}
			}else{
				$msg=array("1",$errormsg."/临时文件".$tempName."不存在！");
				return $msg;
			}
		}else {
			$msg=array("1",$errormsg."/目录".$uploadfile."不可写!");
			return $msg;
		}
	}
	

}
$classuploadfile = new upload();

?>
