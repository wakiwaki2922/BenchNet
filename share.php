<?
$down = $_GET['d'];
$up = $_GET['u'];
$ping = $_GET['p'];
$language = $_GET['lng'];


if(isset($language)){
@include_once "languages/".$language.".php";
}else{
@include_once "languages/EN.php";
}

$font = 'fonts/BebasNeue_Bold.ttf';
//$font = 'fonts/AmaticSC-Regular.ttf';

//set width+height
$im = imagecreate(250, 85);

// background and text color
$bg = imagecolorallocate($im, 245, 245, 245);
$textcolor = imagecolorallocate($im, 74, 74, 74);

// Write the strings
imagettftext($im, 16, 0, 20, 30, $textcolor, $font, download.": ".$down." Mbps");
imagettftext($im, 16, 0, 20, 50, $textcolor, $font, upload.": ".$up." Mbps");
imagettftext($im, 16, 0, 20, 70, $textcolor, $font, ping.": ".$ping." ms");


// Output the image
header('Content-type: image/png');

imagepng($im);
imagedestroy($im);
?>