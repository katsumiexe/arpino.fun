<?
$sv="{m15.coreserver.jp:110/pop3}INBOX";
$sv="{m15.coreserver.jp}INBOX";
$sv="{m15.coreserver.jp:110/pop3}INBOX";
$m_list=imap_open ($sv,'info@onlyme.fun','katsumi1941');
if(!$m_list){
	print("error");
}else{
//	$list = imap_list($m_list, $sv, "*");
//	$list = imap_listmailbox($m_list, $sv, "*");
	$list = imap_getmailboxes($m_list, $sv, "*");

	foreach ((array)$list as $a1 =>$a2) {
		echo $a1."●". $a2->name."●".$a2->attributes."●".$a2->delimiter."●<br>\n";
	}


//var_dump($list);
}
?>
<hr>
