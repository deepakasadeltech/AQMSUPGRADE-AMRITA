<?php
    date_default_timezone_set('Asia/Calcutta');
	$h = date('H');
	$a = $h >= 12 ? 'PM' : 'AM';
    echo $timestamp = date('h:i:s ').$a;
	?>