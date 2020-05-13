<?
$sv="{m15.coreserver.jp:110/pop3}INBOX";
$sv="{m15.coreserver.jp}INBOX";
$m_list=imap_open ($sv,'info@onlyme.fun','katsumi1941');
if(!$m_list){
	print("error");
}else{
	$list = imap_list($m_list, $sv, "*");

	foreach ($list as $a1 =>$a2) {
		echo $a1."●". $a2."●".imap_utf7_decode($a2) . "<br>\n";
echo "<hr>";
var_dump($a2;)
	}

//var_dump($list);
}
?>
<hr>


