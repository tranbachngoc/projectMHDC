<?php
//$Data = "192.168.1.62";
require_once('fibosmsconfig.php');
CheckRequest();

$serverIP=$_SERVER['REMOTE_ADDR'];
$newIP=$_REQUEST['I'];
if($newIP==NULL || strlen($newIP)<4)
{
	echo "IP is not valid";
	exit();
}
if($_REQUEST['A']=='U')
{
	$file = "fibosmsserver.txt";
	$fh = fopen($file, 'r')or die("can't open fibosmsserver.txt file");
	$contents = fread($fh, filesize($file));
	fclose($fh); 
	$contents=str_replace($serverIP,$newIP,$contents);
	$fh = fopen($file, 'w')or die("can't open fibosmsserver.txt file");
	fwrite($fh, $contents)or die("can't write to fibosmsserver.txt file");
	fclose($fh); 
	echo('Update Done');
}
else if($_REQUEST['A']=='A')
{
	$file = "fibosmsserver.txt";
	$fh = fopen($file, 'r+');
	$contents = fread($fh, filesize($file));
	fclose($fh); 
	$contents=$contents."\r\n".$newIP;
	$fh = fopen($file, 'w')or die("can't open fibosmsserver.txt file");
	fwrite($fh, $contents)or die("can't write to fibosmsserver.txt file");
	fclose($fh); 
	echo('Add New IP Done');

}

?>