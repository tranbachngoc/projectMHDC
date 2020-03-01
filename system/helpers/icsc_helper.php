<?php
if ( ! function_exists('RemoveSign'))
{
	function RemoveSign($string){
		$trans = array(
			"đ"=>"d","ă"=>"a","â"=>"a","á"=>"a","à"=>"a",
			"ả"=>"a","ã"=>"a","ạ"=>"a",
			"ấ"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ậ"=>"a",
			"ắ"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ặ"=>"a",
			"é"=>"e","è"=>"e","ẻ"=>"e","ẽ"=>"e","ẹ"=>"e",
			"ế"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ệ"=>"e",
			"í"=>"i","ì"=>"i","ỉ"=>"i","ĩ"=>"i","ị"=>"i",
			"ư"=>"u","ô"=>"o","ơ"=>"o","ê"=>"e",
			"Ư"=>"u","Ô"=>"o","Ơ"=>"o","Ê"=>"e",
			"ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",
			"ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",
			"ó"=>"o","ò"=>"o","ỏ"=>"o","õ"=>"o","ọ"=>"o",
			"ớ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ợ"=>"o",
			"ố"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ộ"=>"o",
			"ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",
			"ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",
			"ý"=>"y","ỳ"=>"y","ỷ"=>"y","ỹ"=>"y","ỵ"=>"y",
			"Ý"=>"Y","Ỳ"=>"Y","Ỷ"=>"Y","Ỹ"=>"Y","Ỵ"=>"Y",
			"Đ"=>"D","Ă"=>"A","Â"=>"A","Á"=>"A","À"=>"A",
			"Ả"=>"A","Ã"=>"A","Ạ"=>"A",
			"Ấ"=>"A","Ầ"=>"A","Ẩ"=>"A","Ẫ"=>"A","Ậ"=>"A",
			"Ắ"=>"A","Ằ"=>"A","Ẳ"=>"A","Ẵ"=>"A","Ặ"=>"A",
			"É"=>"E","È"=>"E","Ẻ"=>"E","Ẽ"=>"E","Ẹ"=>"E",
			"Ế"=>"E","Ề"=>"E","Ể"=>"E","Ễ"=>"E","Ệ"=>"E",
			"Í"=>"I","Ì"=>"I","Ỉ"=>"I","Ĩ"=>"I","Ị"=>"I",
			"Ư"=>"U","Ô"=>"O","Ơ"=>"O","Ê"=>"E",
			"Ư"=>"U","Ô"=>"O","Ơ"=>"O","Ê"=>"E",
			"Ú"=>"U","Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ụ"=>"U",
			"Ứ"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ự"=>"U",
			"Ó"=>"O","Ò"=>"O","Ỏ"=>"O","Õ"=>"O","Ọ"=>"O",
			"Ớ"=>"O","Ờ"=>"O","Ở"=>"O","Ỡ"=>"O","Ợ"=>"O",
			"Ố"=>"O","Ồ"=>"O","Ổ"=>"O","Ỗ"=>"O","Ộ"=>"O",
			"Ú"=>"U","Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ụ"=>"U",
			"Ứ"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ự"=>"U",);
		//remove any '-' from the string they will be used as concatonater
		$str = str_replace('-', ' ', $string);
		$str = strtr($str, $trans);
		// remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);
		// lowercase and trim
		$str = trim(strtolower($str),'-');
		return $str;

	}
        
	function khongdau($word){
		$trans = array(
			"đ"=>"d","ă"=>"a","â"=>"a","á"=>"a","à"=>"a",
			"ả"=>"a","ã"=>"a","ạ"=>"a",
			"ấ"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ậ"=>"a",
			"ắ"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ặ"=>"a",
			"é"=>"e","è"=>"e","ẻ"=>"e","ẽ"=>"e","ẹ"=>"e",
			"ế"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ệ"=>"e",
			"í"=>"i","ì"=>"i","ỉ"=>"i","ĩ"=>"i","ị"=>"i",
			"ư"=>"u","ô"=>"o","ơ"=>"o","ê"=>"e",
			"Ư"=>"u","Ô"=>"o","Ơ"=>"o","Ê"=>"e",
			"ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",
			"ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",
			"ó"=>"o","ò"=>"o","ỏ"=>"o","õ"=>"o","ọ"=>"o",
			"ớ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ợ"=>"o",
			"ố"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ộ"=>"o",
			"ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",
			"ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",
			"ý"=>"y","ỳ"=>"y","ỷ"=>"y","ỹ"=>"y","ỵ"=>"y",
			"Ý"=>"Y","Ỳ"=>"Y","Ỷ"=>"Y","Ỹ"=>"Y","Ỵ"=>"Y",
			"Đ"=>"D","Ă"=>"A","Â"=>"A","Á"=>"A","À"=>"A",
			"Ả"=>"A","Ã"=>"A","Ạ"=>"A",
			"Ấ"=>"A","Ầ"=>"A","Ẩ"=>"A","Ẫ"=>"A","Ậ"=>"A",
			"Ắ"=>"A","Ằ"=>"A","Ẳ"=>"A","Ẵ"=>"A","Ặ"=>"A",
			"É"=>"E","È"=>"E","Ẻ"=>"E","Ẽ"=>"E","Ẹ"=>"E",
			"Ế"=>"E","Ề"=>"E","Ể"=>"E","Ễ"=>"E","Ệ"=>"E",
			"Í"=>"I","Ì"=>"I","Ỉ"=>"I","Ĩ"=>"I","Ị"=>"I",
			"Ư"=>"U","Ô"=>"O","Ơ"=>"O","Ê"=>"E",
			"Ư"=>"U","Ô"=>"O","Ơ"=>"O","Ê"=>"E",
			"Ú"=>"U","Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ụ"=>"U",
			"Ứ"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ự"=>"U",
			"Ó"=>"O","Ò"=>"O","Ỏ"=>"O","Õ"=>"O","Ọ"=>"O",
			"Ớ"=>"O","Ờ"=>"O","Ở"=>"O","Ỡ"=>"O","Ợ"=>"O",
			"Ố"=>"O","Ồ"=>"O","Ổ"=>"O","Ỗ"=>"O","Ộ"=>"O",
			"Ú"=>"U","Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ụ"=>"U",
			"Ứ"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ự"=>"U",);
		//remove any '-' from the string they will be used as concatonater
		$str = strtr($word, $trans);
		// remove any duplicate whitespace, and ensure all characters are alphanumeric
		return $str;

	}

function RemoveSign1($str)
{
$coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
,"ờ","ớ","ợ","ở","ỡ",
"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
"ỳ","ý","ỵ","ỷ","ỹ",
"đ",
"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
"Ì","Í","Ị","Ỉ","Ĩ",
"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
,"Ờ","Ớ","Ợ","Ở","Ỡ",
"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
"Đ","ê","ù","à"," ",",","–",".","/");
$khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
,"a","a","a","a","a","a",
"e","e","e","e","e","e","e","e","e","e","e",
"i","i","i","i","i",
"o","o","o","o","o","o","o","o","o","o","o","o"
,"o","o","o","o","o",
"u","u","u","u","u","u","u","u","u","u","u",
"y","y","y","y","y",
"d",
"A","A","A","A","A","A","A","A","A","A","A","A"
,"A","A","A","A","A",
"E","E","E","E","E","E","E","E","E","E","E",
"I","I","I","I","I",
"O","O","O","O","O","O","O","O","O","O","O","O"
,"O","O","O","O","O",
"U","U","U","U","U","U","U","U","U","U","U",
"Y","Y","Y","Y","Y",
"D","e","u","a","-","-","","","");
$tempvalue = strtolower(str_replace($coDau,$khongDau,$str));
$returnvalue = "";
for($i=0;$i<strlen($tempvalue);$i++){
	if(
	$tempvalue[$i]=='a' ||
	$tempvalue[$i]=='b' ||
	$tempvalue[$i]=='c' ||
	$tempvalue[$i]=='d' ||
	$tempvalue[$i]=='e' ||
	$tempvalue[$i]=='f' ||
	$tempvalue[$i]=='g' ||
	$tempvalue[$i]=='h' ||
	$tempvalue[$i]=='i' ||
	$tempvalue[$i]=='j' ||
	$tempvalue[$i]=='k' ||
	$tempvalue[$i]=='l' ||
	$tempvalue[$i]=='m' ||
	$tempvalue[$i]=='n' ||
	$tempvalue[$i]=='o' ||
	$tempvalue[$i]=='p' ||
	$tempvalue[$i]=='q' ||
	$tempvalue[$i]=='r' ||
	$tempvalue[$i]=='s' ||
	$tempvalue[$i]=='t' ||
	$tempvalue[$i]=='u' ||
	$tempvalue[$i]=='v' ||
	$tempvalue[$i]=='w' ||
	$tempvalue[$i]=='x' ||
	$tempvalue[$i]=='y' ||
	$tempvalue[$i]=='z' ||
	$tempvalue[$i]=='0' ||
	$tempvalue[$i]=='1' ||
	$tempvalue[$i]=='2' ||
	$tempvalue[$i]=='3' ||
	$tempvalue[$i]=='4' ||
	$tempvalue[$i]=='5' ||
	$tempvalue[$i]=='6' ||
	$tempvalue[$i]=='7' ||
	$tempvalue[$i]=='8' ||
	$tempvalue[$i]=='9' ||	
	$tempvalue[$i]=='-'	
	)
	$returnvalue =$returnvalue.$tempvalue[$i];
}
return $returnvalue."/";
}
}

/**
 * Phrase Highlighter
 *
 * Highlights a phrase within a text string
 *
 * @access	public
 * @param	string	the text string
 * @param	string	the phrase you'd like to highlight
 * @param	string	the openging tag to precede the phrase with
 * @param	string	the closing tag to end the phrase with
 * @return	string
 */	
if ( ! function_exists('cut_string_unicodeutf8'))
{
	function cut_string_unicodeutf8($text, $limit=25)
	{
		$val = cstr_utf8($text, 0, $limit);
		return $val[1] ? $val[0]."..." : $val[0];
	}
}

if ( ! function_exists('cstr_utf8'))
{
	function cstr_utf8($text, $start=0, $limit=12)
	{
		if (function_exists('mb_substr')) {
			$more = (mb_strlen($text) > $limit) ? TRUE : FALSE;
			$text = mb_substr($text, 0, $limit, 'UTF-8');
			if($more){
				for($i=strlen($text)-1;$i>0;$i--){
					if($text[$i]==' ') {$text=substr($text,0,$i); break;}
				}
			}
			return array($text, $more);
			} elseif (function_exists('iconv_substr')) {
				$more = (iconv_strlen($text) > $limit) ? TRUE : FALSE;
				$text = iconv_substr($text, 0, $limit, 'UTF-8');
				return array($text, $more);
			} else {
			preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);
			if(func_num_args() >= 3) {
				if (count($ar[0])>$limit) {
					$more = TRUE;
					$text = join("",array_slice($ar[0],0,$limit))."...";
				}
				$more = TRUE;
				$text = join("",array_slice($ar[0],0,$limit));
			} else {
				$more = FALSE;
				$text =  join("",array_slice($ar[0],0));
			}
			return array($text, $more);
		}
	}
}

if ( ! function_exists('formatMoney'))
{
function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
} 
}

 ?>