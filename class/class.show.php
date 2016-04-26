<?php
class ID{
	
// -- windows
//	public function unZip($filename){
//		$zip=zip_open($filename);
//		if ($zip)
//		{
//			while ($zip_entry = zip_read($zip))
//			{
//				if(zip_entry_name($zip_entry)=="assets/sourceid.txt"){
////					if (zip_entry_open($zip, $zip_entry, "r")) {
//						$sourceid = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));	
//						return  $sourceid;
//					}
////				}
//			}
//			zip_entry_close($zip_entry);
//			zip_close($zip);
//			unset($zip);
//}
//		
//	}

	public function unZip($filename){
		//$sourceid = exec("sh /var/www/html/source/shell/unZip.sh $filename");
		$prohome    = PROHOME;
		$prozip    = PROHOME."shell/unZip.sh";
		$sourceid = exec("sh $prozip $filename $prohome");
		echo $sourceid;
		return $sourceid;
	}

}
$unzipID = new ID();
?>
