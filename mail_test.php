<?
$sv="{m15.coreserver.jp:110/pop3}INBOX";
$sv="{m15.coreserver.jp:110}INBOX";
$m_list=imap_open ($sv,'info@onlyme.fun','katsumi1941');
if(!$m_list){
	print("error");
}else{
	$list = imap_list($m_list, $sv, "*");
	foreach ($list as $a1 =>$a2) {
		echo $a1."●".imap_utf7_decode($a2) . "\n";
	}
}
?>
<hr>
<?=time()?>■<?=$minfo?>

