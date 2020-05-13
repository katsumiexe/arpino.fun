<?
$sv="{m15.coreserver.jp:110/pop3}INBOX";
$sv="{m15.coreserver.jp:110}INBOX";
$sv="{m15.coreserver.jp}INBOX";

$m_list=imap_open ($sv,'katsumi@onlyme.fun','RJWEYjRWSmUh');

if(!$m_list){
	print("error");
}else{
$num = imap_num_msg($m_list);
print("△".$num."<br>\n");

foreach ((array)$mc as $a1 => $a2) {
	echo $a1."□".$a2."<br>\n";
}

for($s=0;$s<$num+1;$s++){	
	$head = imap_headerinfo($m_list,$s);

	foreach ((array)$head as $a1 => $a2) {
		echo $a1."■".$a2."<br>\n";
	}

	$tmp_from=explode('<',$head->fromaddress);
	$tmp_ttl=trim(mb_decode_mimeheader($tmp_from[0]));
	$tmp_addr=trim(str_replace(">","",$tmp_from[1]));

	$sb=trim(mb_decode_mimeheader($head->subject));

	print($sb."□<br>\n");	
	print($tmp_ttl."□".$tmp_addr."<br>\n");	

	$body = imap_body($m_list,$s);
	foreach ((array)$body as $a2) {
		if(substr_count($a2,"Content-Type: text/plain;")>0){
			$tmp=explode("\n",$a2);
			$tmp2=explode($tmp[0]."\n",$a2);
			$a2=$tmp2[1];
			$a2=str_replace($tmp[1],"",$a2);
		}
		$a2 = mb_convert_encoding($a2, 'UTF-8', 'auto');
		$a2 =str_replace("\n","<br>",$a2);
		echo $a2."<hr>\n";
    }
}

print("<hr>");
print(mb_decode_mimeheader("=?utf-8?B?5Lya5ZOh55m76Yyy5a6M5LqG?="));
print(mb_decode_mimeheader("=?utf-8?B?5YaZ55yf5ZCN5Yi65L2c5oiQ44K144Kk44OI4piFT25seU1l?="));

/*
if ($headers == false) {
    echo "コールが失敗しました<br />\n";
} else {
}
*/
}
?>
<hr>
