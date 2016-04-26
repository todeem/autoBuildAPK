<?php
class ftp{
	private $hostname;
	private $username;
	private $password;
	private $port;
	private $passive;
	private $debug;
	private $conn_id;
	function __construct($hostname, $port, $username, $password)
	{
		$this->hostname = $hostname;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->passive = true;
		$this->debug = true;
		$this->conn_id = false;
		echo  $hostname.$port.$username. $password;
		$this->conn_id = @ftp_connect($this->hostname,$this->port) or die("FTP服务器连接失败");
		@ftp_login($this->conn_id,$this->username,$this->password) or die("FTP服务器登陆失败");
		@ftp_pasv($this->conn_id,true); // 打开被动模拟
	}
	public function ftp_createdir($id){
		$result=ftp_mkdir($this->conn_id,$id);
		if($result === FALSE) {
			if($this->debug === TRUE) {
				$this->_error("创建文件".$id."失败");
			}
			return FALSE;
		}
		return TRUE;
	}
//	public function notfound($d){
//		$result=ftp_size($this->conn_id, $d);
//		if($result<0) {
//			$r=ftp_mkdir($this->conn_id,$d);
//				if($r === FALSE) {
//					if($this->debug === TRUE) {
//					$this->_error("创建文件".$d."失败".$pwd=ftp_pwd($this->conn_id));
//				}
//				}
//			return TRUE;
//		}else{
//			return FALSE;
//		}
//	}
	public function chmod($path, $perm) {
		//只有在PHP5中才定义了修改权限的函数(ftp)
		if( ! function_exists('ftp_chmod')) {
			if($this->debug === TRUE) {
				$this->_error("ftp_unable_to_chmod(function)");
			}
			return FALSE;
		}
		 
		$result = @ftp_chmod($this->conn_id, $perm, $path);

		if($result === FALSE) {
			if($this->debug === TRUE) {
				$this->_error("ftp_unable_to_chmod:path[".$path."]-chmod[".$perm."]");
			}
			return FALSE;
		}
		return TRUE;
	}
	private function _error($msg) {
		$t=time();
		$dt=date("Y-m-d H:i:s",$t);
		return @file_put_contents('../error/ftp_err.log', $dt." - ".$msg, FILE_APPEND);
	}
	
}
