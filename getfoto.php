<?php
data:
echo "Link Url : ";
$urlfoto = trim(fgets(STDIN));
$angka = acak(5);
$cookie = curl('https://www.instagram.com/accounts/web_create_ajax/attempt/', null, null);
$csrf = ($cookie[2]['csrftoken']);
$rur = ($cookie[2]['rur']);
$mid = ($cookie[2]['mid']);

$headers = array();
$headers[] = 'Host: www.instagram.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
$headers[] = 'Accept-Language: id,en-US;q=0.7,en;q=0.3';
$headers[] = 'Connection: close';
$headers[] = 'Cookie: ig_did=39494EF9-EDA0-4EC9-B409-C02ED6E1C5AF; rur=VLL; csrftoken='.$csrf.'; mid='.$mid.'; urlgen="{\"110.138.151.14\": 7713}:1jvnQ2:2elOPNoUDNukZTl5O64VBk6mfME"';
$headers[] = 'Upgrade-Insecure-Requests: 1';

$img = curl(''.$urlfoto.'', null, $headers);
$linkimg = get_between($img[1], '<meta property="og:image" content="', '"');
$url = ''.$linkimg.'';
$downloadedFileContents = file_get_contents($url);

if($downloadedFileContents === false){
    throw new Exception('Failed to download file at: ' . $url);
}
$fileName = 'foto'.$angka.'.png';
$save = file_put_contents($fileName, $downloadedFileContents);
echo "Sukses Save File Name $fileName\n";
echo "\n";
if($save === false){
    throw new Exception('Failed to save file to: ' , $fileName);
}
goto data;
function get_between($string, $start, $end) 
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}
function acak($panjang)
{
    $karakter= '1234567890';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
  $pos = rand(0, strlen($karakter)-1);
  $string .= $karakter{$pos};
    }
    return $string;
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
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}
