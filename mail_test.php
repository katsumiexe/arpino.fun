<?
$sv="{m15.coreserver.jp:110/pop3}INBOX";
$sv="{m15.coreserver.jp:110}INBOX";
$sv="{m15.coreserver.jp}INBOX";

$m_list=imap_open ($sv,'katsumi@onlyme.fun','RJWEYjRWSmUh');
$num = imap_num_msg($m_list);
if(!$m_list){
	print("error");

}else{
	for($s=0;$s<$num+1;$s++){	
		$head = imap_headerinfo($m_list,$s);

		$tmp_from=explode('<',$head->fromaddress);

		$dat[$s]["date"]=trim($head->date);
		$dat[$s]["subject"]=trim(mb_decode_mimeheader($head->subject));
		$dat[$s]["from"]=trim(mb_decode_mimeheader($tmp_from[0]));
		$dat[$s]["address"]=trim(str_replace(">","",$tmp_from[1]));

		$tmp_body = imap_body($m_list,$s);

		if(substr_count($tmp_body,"Content-Type")>1){
			$tmp=explode("\n",$a2);
			$tmp2=explode($tmp[0]."\n",$a2);
			$a2=$tmp2[1];
			$a2=str_replace($tmp[1],"",$a2);
		}

		$dat[$s]["body"]=$body;

	/*
		foreach ((array)$body as $a2) {
			echo $a2."<hr>";
	//		if(substr_count($a2,"Content-Type: text/plain;")>0){
				$tmp=explode("\n",$a2);
				$tmp2=explode($tmp[0]."\n",$a2);
				$a2=$tmp2[1];
				$a2=str_replace($tmp[1],"",$a2);
	//		}
			$a2 = mb_convert_encoding($a2, 'UTF-8', 'auto');
			$a2 =str_replace("\n","<br>",$a2);
			echo $a2."<hr>";
	 */

    }
	for($n=0;$n<$s;$n++){
		print($dat[$n]["date"]."<br>\n");
		print($dat[$n]["subject"]."<br>\n");
		print($dat[$n]["from"]."<br>\n");
		print($dat[$n]["address"]."<br>\n");
		print("<hr>");
		print($dat[$n]["body"]);
		print("<hr><hr>");
	}
}
?>
<hr>
