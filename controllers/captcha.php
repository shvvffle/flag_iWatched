<?php
	session_start();

	header("Content-Type: image/png");

	$image = imagecreate(336, 60);

	imagecolorallocate($image, 54, 59, 65);

	$font_color = imagecolorallocate($image, 113, 117, 114);

	$font_path = "atwriter.ttf";

	$captcha = substr( sha1(mt_rand(10000, 99999)), 0, 7);

	$_SESSION["captcha"] = $captcha;

	imagettftext($image, 30, 0, 90, 45, $font_color, $font_path, $captcha);

	imagepng($image);
?>