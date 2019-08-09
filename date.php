<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::MD5::</title>
</head>

<body>
<?php




echo '----------DATE-ENCODE-DECODE--------------<br><br>';
$dateto = '20.08.2019';
echo 'dateto-Encode(20.08.2019): '.base64_encode($dateto).'<br><br>';
echo 'dateto-Decode: '.base64_decode('MjAuMDguMjAxOQ==').'<br><br><br>';


echo '----------MAC ADDRESS -ENCODE-DECODE--------------<br><br>';
$textmac = '54-E1-AD-96-33-59';
echo 'lmac-Encode(54-E1-AD-96-33-59): '.base64_encode($textmac).'<br><br>';
echo 'lmac-Decode(54-E1-AD-96-33-59): '.base64_decode(base64_encode($textmac)).'<br><br><br>';


echo '---------MAC ADDRESS WITH INTERNET(GetMAC())------------------<br><br>';
echo 'system Mac ADD_1 : '.GetMAC().'<br><br>';
echo 'Encode nMac ADD_1 : '.base64_encode(GetMAC()).'<br><br>';
echo 'Decode nMac ADD_1 : '.base64_decode(base64_encode(GetMAC())).'<br><br><br>';


echo '---------MAC ADDRESS WITHOUT INTERNET(noImac())---------------<br><br>';
echo 'system Mac ADD_2 : '.noImac().'<br><br>';
echo 'Encode nMac ADD_2 : '.base64_encode(noImac()).'<br><br>';
echo 'Decode nMac ADD_2 : '.base64_decode(base64_encode(noImac())).'<br><br>';

echo '<br>------------------------------------------------------------------------<br></br>';

function noImac(){
$string=exec('getmac');
$mac=substr($string, 0, 17);
return $mac;	
	}


function GetMAC(){
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content,'\\')-20, 17);
}



?>




</body>
</html>