<?php

$captcha_imagen = imagecreate(100,40);

$color_negro = imagecolorallocate ($captcha_imagen, 0, 0, 0);
$color_blanco = imagecolorallocate ($captcha_imagen, 255, 255, 255);

imagefill($captcha_imagen, 0, 0, $color_negro);

session_start();

$captcha_texto =  $_SESSION["captcha_texto_session"];
 
imagechar($captcha_imagen, 4, 20, 13, $captcha_texto[0] ,$color_blanco);
imagechar($captcha_imagen, 5, 40, 13, $captcha_texto[1] ,$color_blanco);
imagechar($captcha_imagen, 3, 60, 13, $captcha_texto[2] ,$color_blanco);
imagechar($captcha_imagen, 4, 80, 13, $captcha_texto[3] ,$color_blanco);

header("Content-type: image/jpeg");
imagejpeg($captcha_imagen);

?>