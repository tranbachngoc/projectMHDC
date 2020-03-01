
<?php
$url  = explode('://',$banner->adv_link);
if ($url[0] == 'http' || $url == 'htps'){
    $urlnew = $banner->adv_link;
} else{
    $urlnew = 'http://'.strtolower($url[0]);
}
header('Location: '.$urlnew);