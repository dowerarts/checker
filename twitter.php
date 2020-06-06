<?php

$nama = explode(" ", nama());
$nama1 = $nama[0];
$nama2 = $nama[1];
$headers = array();

$email = ''.$nama1.'@osyduck.co';

$gas = curl('http://osyduck.co/mailbox/'.$nama1.'@osyduck.co', null, null);
$xsrf = ($gas[2]['XSRF-TOKEN']);
$session = ($gas[2]['osyduck_mail_session']);

$headers2 = array();
$headers2[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0';
$headers2[] = 'Referer: http://osyduck.co/mailbox/'.$nama1.'@osyduck.co';
$headers2[] = 'Cookie: XSRF-TOKEN='.$xsrf.'; osyduck_mail_session='.$session.'; server_error=false';

$gas2 = curl('http://osyduck.co/mail/fetch', null, $headers2);
$code = get_between($gas2[1], '"subject":"', ' is your Instagram code');

$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
// $headers[] = 'X-CSRFToken: IW5hJCSS5PMvhMqVyoxY94ThjK146u2z';
// $headers[] = 'X-Instagram-AJAX: 0d4274850943';
// $headers[] = 'X-IG-App-ID: 936619743392459';
// $headers[] = 'Cookie: ig_did=3BA3020E-126B-4390-8DA7-567A89FE671F; rur=FRC; csrftoken=IW5hJCSS5PMvhMqVyoxY94ThjK146u2z; mid=XttrrwALAAED7O2SezcNHEsrL616';

$gas = curl('https://www.instagram.com/accounts/web_create_ajax/attempt/', null, $headers);
$ig_did = ($gas[2]['ig_did']);
$csrftoken = ($gas[2]['csrftoken']);
$rur = ($gas[2]['rur']);
$mid = ($gas[2]['mid']);

$headers2 = array();
$headers2[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0';
$headers2[] = 'Content-Type: application/x-www-form-urlencoded';
$headers2[] = 'X-CSRFToken: '.$csrftoken.'';
$headers2[] = 'X-Instagram-AJAX: 0d4274850943';
$headers2[] = 'X-IG-App-ID: 936619743392459';
$headers2[] = 'Cookie: ig_did='.$ig_did.'; rur='.$rur.'; csrftoken='.$csrftoken.'; mid='.$mid.'';

$gas2 = curl('https://www.instagram.com/accounts/web_create_ajax/attempt/', 'email='.$email.'&username=&first_name=&opt_into_one_tap=false', $headers2);
echo "Sedang Menunggu Informasi Email Dari $email\n";
echo "\n";
sleep(1);
if (strpos($gas2[1], 'Another account is using')) {
	echo "[1] ++.Email Sudah Terpakai.++\n";
} else {
	echo "[1] ++.Email Sudah Siap Dipakai.++\n";
}

echo "++.First Name : $nama1\n";
echo "++.Last Name : $nama2\n";
echo "\n";
$gas3 = curl('https://www.instagram.com/accounts/web_create_ajax/attempt/', 'email='.$email.'&username=&first_name='.$nama1.'+'.$nama2.'&opt_into_one_tap=false', $headers2);
$name = get_between($gas3[1], '"username_suggestions": [', '"],');
echo "[2] ++.Username Tersedia : $name.++\n";
$username = get_between($gas3[1], '"username_suggestions": ["', '",');
echo "[3] ++.Username Yang Diinginkan : $username\n";
$gas4 = curl('https://www.instagram.com/accounts/web_create_ajax/attempt/', 'email='.$email.'&username='.$username.'&first_name='.$nama1.'+'.$nama2.'&opt_into_one_tap=false', $headers2);
echo "[4] ++.Sedang Getting Code 120second.++\n";
sleep(60);
echo "++.Sedang Getting Code 60second.++\n";
sleep(60);
$gas5 = curl('https://i.instagram.com/api/v1/accounts/send_verify_email/', 'device_id=XttrrwALAAED7O2SezcNHEsrL616&email='.$email.'', $headers2);
echo "[5] Sedang Verif\n";
$gas6 = curl('https://i.instagram.com/api/v1/accounts/check_confirmation_code/', 'code='.$code.'&device_id=XttrrwALAAED7O2SezcNHEsrL616&email='.$email.'', $headers2);
if (strpos($gas6[1], '"status": "ok"')) {
	echo "[6] ++.Success Register.++\n";
} if (strpos($gas6[1], 'Kode tersebut tidak valid. Anda dapat meminta kode yang baru.')) {
	echo "[6] ++.Otp Salah.++\n";
}
$gas7 = curl('https://www.instagram.com/accounts/web_create_ajax/', 'email='.$email.'&enc_password=%23PWD_INSTAGRAM_BROWSER%3A10%3A1591441218%3AAcxQAAmmYC2tz4G%2FnrrY1gfQj1b1N5dmTKbVBnGndEjSC1wKHwFmp02A47HOOW9iWbuh5Gwmvj64Dkh6bNMk%2FTDVNtLzxnMhW7u%2FTaM8E9vtNboBwTlORQ8B703XeAxh0yzCm4JTyGxifXkNYw%3D%3D&username='.$username.'&first_name='.$nama1.'+'.$nama2.'&month=6&day=6&year=2000&client_id=XttrrwALAAED7O2SezcNHEsrL616&seamless_login_enabled=1&tos_version=row&force_sign_up_code=2vZGMwPW', $headers2);
$link = $name = get_between($gas7[1], '"checkpoint_url": "', '",');
echo "[7] Checkpoint Url = $link\n";
echo "[8] Saved Files To -> instagram-live.txt";
		fwrite(fopen("instagram-live.txt", "a"), "$email | Alfarz123 \n");
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