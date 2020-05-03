 <?php
  echo "\n";
  echo "List Empas  : ";
$xyz = trim(fgets(STDIN));
$no = 1;
echo "\n";
$jml = count(explode("\n", str_replace("\r", "", file_get_contents($xyz))));
echo "\n";
echo "Total Empas : $jml\n";
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
  $pecah = explode("|", trim($akun));
  $email = trim($pecah[0]);
  $passwd = trim($pecah[1]);

$headers = array();
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Mobile Safari/537.36';

$gas = curl('https://www.md5online.org/md5-decrypt.html', 'hash='.$passwd.'', $headers);

  if ($token = get_between($gas[1], 'Found : <b>', '</b></span><br>')) {
  echo "[$no] [Cracked] $email|$token\n";
  fwrite(fopen("md5-cracked.txt", "a"), "$email|$token \n");
} else {
  echo "[$no] [Gagal Cracked] $email|$passwd\n";
}
$no++;
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
  $cookies = array();
  foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
  }
  return array (
  $header,
  $body,
  $cookies
  );
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