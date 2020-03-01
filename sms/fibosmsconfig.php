<?php


function CheckRequest()
{
	$file = "fibosmsserver.txt";
	$fh = fopen($file, 'r+')or die("can't open fibosmsserver.txt file");
	$contents = fread($fh, filesize($file));
	fclose($fh);
	$ipList = explode("\n", $contents);
	$serverIP=$_SERVER['REMOTE_ADDR'];
	
	$ipOK=false;
	for($i=0;$i<count($ipList);$i++)
	{
		//echo $ipList[$i];
		if (trim($serverIP) == trim($ipList[$i]))
			$ipOK=true;
	}
	if ($ipOK == false)
	{ 
		echo $serverIP." can not access";
		exit();
	}

}
function ReplaceSpecialCharForXML($strIn)
{
	$strRet =  str_replace("\"", "&quot;",$strIn);
	$strRet= str_replace("&","&amp;",$strRet);
	$strRet= str_replace("'","&apos;",$strRet);
	$strRet= str_replace("<","&lt;",$strRet);
	$strRet = str_replace(">", "&gt;",$strRet);
	return $strRet;
}




?>