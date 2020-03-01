<?php

// max_width and image variables are sent by htaccess
$max_height = 1000;

$image = 'media/'.$_GET["imgfile"];
#echo $image; exit;
$max_width = $_GET["width"];
if (strrchr($image, '/')) {
	$filename = substr(strrchr($image, '/'), 1); // remove folder references
} else {
	$filename = $image;
}

$size = getimagesize($image);
$width = $size[0];
$height = $size[1];

header("Content-type: image/jpeg");
if (!$max_width) {
	readfile($image);
	exit;
}

// get the ratio needed
$x_ratio = $max_width / $width;
$y_ratio = $max_height / $height;

// if image already meets criteria, load current values in
// if not, use ratios to load new size info
if (($width <= $max_width) && ($height <= $max_height) ) {
	$tn_width = $width;
	$tn_height = $height;
} else if (($x_ratio * $height) < $max_height) {
	$tn_height = ceil($x_ratio * $height);
	$tn_width = $max_width;
} else {
	$tn_width = ceil($y_ratio * $width);
	$tn_height = $max_height;
}

/* Caching additions by Trent Davies */
// first check cache
// cache must be world-readable
$resized = 'cache/'.$tn_width.'x'.$tn_height.'-'.$filename;
$imageModified = @filemtime($image);
$thumbModified = @filemtime($resized);


// if thumbnail is newer than image then output cached thumbnail and exit


// read image
$ext = substr(strrchr($image, '.'), 1); // get the file extension
$handle = finfo_open(FILEINFO_MIME);
$mime_type = finfo_file($handle, $image);
$mime_type = mime_content_type($image);

switch ($mime_type) { 

	case 'image/jpeg':     // jpg
		$src = imagecreatefromjpeg($image) or notfound();
		break;
	case 'image/jpeg':     // jpeg
		$src = imagecreatefromjpeg($image) or notfound();
		break;
	case 'image/png':		
		$src = imagecreatefrompng($image) or notfound();
		
		break;
	case 'image/gif':     // gif
		$src = imagecreatefromgif($image) or notfound();
		break;
	default:
		notfound();
}

// set up canvas
$dst = imagecreatetruecolor($tn_width,$tn_height);

imageantialias ($dst, true);

// copy resized image to new canvas
imagecopyresampled ($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

/* Sharpening adddition by Mike Harding */
// sharpen the image (only available in PHP5.1)
if (function_exists("imageconvolution")) {
	$matrix = array(    array( -1, -1, -1 ),
                    array( -1, 32, -1 ),
                    array( -1, -1, -1 ) );
	$divisor = 24;
	$offset = 0;

	imageconvolution($dst, $matrix, $divisor, $offset);
}


// send the header and new image
imagejpeg($dst, null, -1);
imagejpeg($dst, $resized, -1); // write the thumbnail to cache as well...

// clear out the resources
imagedestroy($src);
imagedestroy($dst);

?>

