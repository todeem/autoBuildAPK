<?php
/*
 * Created on 2007-9-19
 * Programmer : Alan , Msn - haowubai@hotmail.com
 * KeBeKe.com Develop a project PHP - MySQL - Apache
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
for ($i=0; $i<3; $i++)
{
	$letter .= chr(mt_rand(48,57));
}
//获取随机字母
for ($i=0; $i<1; $i++)
{
	$letter .= chr(mt_rand(65,90));
}
//重构字符顺序
$strs = str_split($letter);
shuffle ($strs);
$rndstring = "";
while (list (, $str) = each ($strs))
{
	$rndstring .= $str;
}

$width = 60; //验证码图片的宽度
$height = 26; //验证码图片的高度
@header("Content-Type:image/png");
$_SESSION["code"] = $rndstring;
$im=imagecreate($width,$height);
//背景色
$back=imagecolorallocate($im,rand(170,255),rand(170,255),rand(170,255));
//模糊点颜色
$pix=imagecolorallocate($im,rand(170,255),rand(170,255),rand(200,165));
//字体色
//			$font=imagecolorallocate($im,41,163,238);
$font=imagecolorallocate($im, rand(0,160), rand(0,160), rand(0,160));
//绘模糊作用的点
mt_srand();
for($j=0;$j<5;$j++)
{
	$te2 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));
	imageline($im, rand(0,15),rand(0,50) ,rand(0,50) , rand(0,35),$te2);
}
for($i=0;$i<1000;$i++)
{
	imagesetpixel($im,mt_rand(0,$width),mt_rand(0,$height),$pix);
}
imagestring($im, rand(3,13), rand(3,20), rand(3,9),$rndstring, $font);
imagerectangle($im,0,0,$width-1,$height-1,$font);

imagepng($im);
imagedestroy($im);
$_SESSION["code"] = $rndstring;
?>

