<?php

include('inc/inc.init.php');

$imageSize = $_SESSION['imageSize'];
$gridSize = $_SESSION['gridSize'];
$colorArray = unserialize( $_SESSION['colorData'] );
$numOfColors = count($colorArray);

$numOfBlocks = $imageSize/$gridSize;
$numOfBlocks *= $numOfBlocks;

if($numOfBlocks<$numOfColors) { die("colordata vs number of blocks mismatch $numOfColors / $numOfBlocks"); }

$im = @imagecreatetruecolor(++$imageSize, $imageSize) or die("Cannot Initialize new GD image stream");

// Colors!! - should also be declared in inc.init.php
// The 16 Websafe colors. 

$white 		= imagecolorallocate($im, 255,255,255);
$green 		= imagecolorallocate($im, 15, 50, 15);
$aqua 		= imagecolorallocate($im, 0, 255, 255);
$black 		= imagecolorallocate($im, 0, 0, 0);
$blue 		= imagecolorallocate($im, 0,0,255);
$fuchsia	= imagecolorallocate($im, 255,0,255);
$gray		= imagecolorallocate($im, 128,128,128);
$lime		= imagecolorallocate($im, 0,255,0);
$maroon		= imagecolorallocate($im, 128,0,0);
$navy		= imagecolorallocate($im, 0,0,128);
$olive		= imagecolorallocate($im, 128,128,0);
$purple		= imagecolorallocate($im, 128,0,128);
$red 		= imagecolorallocate($im, 255,0,0);
$silver 	= imagecolorallocate($im, 192,192,192);
$teal 		= imagecolorallocate($im, 0,128,128);
$yellow 	= imagecolorallocate($im, 250,250,50);
$orange 	= imagecolorallocate($im, 255,165,0);

// Extras
$gridColor	= imagecolorallocate($im, 5,5,5);

$i=0;
$row=0;

imagefill($im, 0, 0, $green);

while(($i+$gridSize)<=$imageSize)
{
	imageline($im, $i, 0, $i, $imageSize-1, $gridColor); 
	imageline($im, 0, $i, $imageSize-1, $i, $gridColor); 
	$i+=$gridSize;
}

for($i=0; $i<$numOfBlocks; $i++)
{
	if($c*$gridSize >= $imageSize-1)
	{
		$c = 0;
		$row++;
	}
	
	if($colorArray[$i]=='green') // standard bg color, no need to fill. 
	{
		//imagesetpixel($im, $c*$gridSize+$gridSize-2, $row*$gridSize+$gridSize-2, $gridColor);
	}
	else if($colorArray[$i] != '') // A color, but not green.
	{
		imagefill($im, $c*$gridSize+1, $row*$gridSize+1, $$colorArray[$i]);
		imagesetpixel($im, $c*$gridSize+2, $row*$gridSize+2, $white);
	}
	else if($i>=$numOfColors) // No more colordata, fill black boxes.
	{
		imagefill($im, $c*$gridSize+2, $row*$gridSize+2, $gridColor);
		imagesetpixel($im, $c*$gridSize+$gridSize-1, $row*$gridSize+$gridSize-1, $black);
	}
	$c++;
}

header("Content-type: image/png");
imagepng($im);
imagedestroy($im);

?> 
