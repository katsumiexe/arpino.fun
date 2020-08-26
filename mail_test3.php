


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

	print("TITLE□".$sb."<br>\n");	
	print("ADDR_NAME□".$tmp_ttl."<br>\n");	
	print("ADDR□".$tmp_addr."<br>\n");	

	$body = imap_body($m_list,$s);
	echo "<hr>";
	$body=str_replace("\n","<br>",$body);
	
	echo "<hr>".$body."<hr style=\"height:5px\">";
}
print("<hr>");
/*
imap_delete($m_list,1);
imap_expunge($m_list);
imap_close($m_list);
*/
}
?>
<hr>
