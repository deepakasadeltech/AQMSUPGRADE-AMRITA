<?php

$datefrom = date('d.m.Y');
$dateto = 'MjAuMDguMjAxOQ==';   //20.08.2019
//$dateto = 'MjkuMDQuMjAxOQ=='; //29.04.2019 

//-------------------------

//$nMac = GetMAC();
$nMac = noImac();
$lMac = 'QkMtQTgtQTYtOTAtRkYtQzM=';  //BC-A8-A6-90-FF-C3
//$lMac = 'NTQtRTEtQUQtOTYtMzMtNTk=';  //6C-88-14-00-C7-14


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