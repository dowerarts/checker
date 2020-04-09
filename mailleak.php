curl "https://digibody.avast.com/v1/web/leaks" -H "Connection: keep-alive" -H "Accept: application/json, text/plain, */*" -H "Sec-Fetch-Dest: empty" -H "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36" -H "Content-Type: application/json;charset=UTF-8" -H "Origin: https://www.avast.com" -H "Sec-Fetch-Site: same-site" -H "Sec-Fetch-Mode: cors" -H "Referer: https://www.avast.com/hackcheck" -H "Accept-Language: id,en;q=0.9" --data-binary "^{^\^"email^\^":^\^"dowerarts^@gmail.com^\^"^}" --compressed

<?php

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

Console::log(" __  __       _ _ _                _            _  _____ _               _    
|  \/  |     (_) | |              | |          | |/ ____| |             | |   
| \  / | __ _ _| | |     ___  __ _| | _____  __| | |    | |__   ___  ___| | __
| |\/| |/ _` | | | |    / _ \/ _` | |/ / _ \/ _` | |    | '_ \ / _ \/ __| |/ /
| |  | | (_| | | | |___|  __/ (_| |   <  __/ (_| | |____| | | |  __/ (__|   < 
|_|  |_|\__,_|_|_|______\___|\__,_|_|\_\___|\__,_|\_____|_| |_|\___|\___|_|\_\ ", 'red');
console::log("By Apri Amsyah", 'green');
echo "\n";
console::log("List Email :", 'green');
$xyz = trim(fgets(STDIN));
echo "\n";
$no = 1;
$jml = count(explode("\n", str_replace("\r", "", file_get_contents($xyz))));
console::log("Total Empas : $jml", 'red');
echo "\n";
foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
 	$pecah = explode("|", trim($akun));
	$mail = trim($pecah[0]);

$headers = array();
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36';
$headers[] = 'Content-Type: application/json;charset=UTF-8';

$gas = curl('https://digibody.avast.com/v1/web/leaks', '{"email":"'.$mail.'"}', $headers);
	if (strpos($gas[1], 'leak_id')) {
		console::log("[Total Account $no/$jml] | [Terleak] | $mail", 'red');
	} else {
		console::log("[Total Account $no/$jml] | [Email Aman] | $mail", 'green');
		fwrite(fopen("terleak-live.txt", "a"), "[Email Aman] | $mail \n");		
	}
    $no++;
}
/**
 * PHP Colored CLI
 * Used to log strings with custom colors to console using php
 * 
 * Copyright (C) 2013 Sallar Kaboli <sallar.kaboli@gmail.com>
 * MIT Liencesed
 * http://opensource.org/licenses/MIT
 *
 * Original colored CLI output script:
 * (C) Jesse Donat https://github.com/donatj
 */
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