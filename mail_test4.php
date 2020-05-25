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

		$dat[$s]["udate"]		=date("Y-m-d H:i:s",$head->udate);
		$dat[$s]["date"]		=trim($head->date);
		$dat[$s]["subject"]		=trim(mb_decode_mimeheader($head->subject));
		$dat[$s]["from"]		=trim(mb_decode_mimeheader($tmp_from[0]));
		$dat[$s]["address"]		=trim(str_replace(">","",$tmp_from[1]));

		$tmp_body = imap_body($m_list,$s);

		if(substr_count($tmp_body,"Content-Type")>1){
			$tmp_log	="";
			$main_log	="";
			$main_img	="";

			$tmp		="";
			$tmp1		="";
			$tmp2		="";
			$tmp3		="";
			$tmp4		="";
			$bound		="";

			$tmp=explode("\n",$tmp_body);
			for($n=0;$n<count($tmp);$n++){

				if(strpos($tmp[$n], "boundary") !== false){
					$tmp3=explode('"',$tmp[$n]);
					$bound="--".$tmp3[1];
				}

				if(strpos($tmp[$n], "charset") !== false){
					$tmp3=explode('"',$tmp[$n]);
					$chara=$tmp3[1];
				}

				if(strpos($tmp[$n], "Encoding") !== false){
					$tmp3=explode(':',$tmp[$n]);
					$enc=trim($tmp3[1]);
				}

				if(strpos($tmp[$n], "Content-") === false){
					$m_list.=$tmp[$n]."\n";
				}
			}



			if($enc==664){
				$tmp_body=base64_decode($tmp1[1]);
			}else{
				$tmp_body=$tmp1[1];
			}	
			$enc="";
		}

		$dat[$s]["body"]=$tmp_body;
		$dat[$s]["img"]=$main_img;

    }
	for($n=0;$n<$s;$n++){
		print($dat[$n]["udate"]."<br>\n");
		print($dat[$n]["date"]."<br>\n");
		print($dat[$n]["subject"]."<br>\n");
		print($dat[$n]["from"]."<br>\n");
		print($dat[$n]["address"]."<br>\n");
		print($dat[$n]["img"]."<br>\n");
		print("<hr>");
		print($dat[$n]["body"]);
		print("<hr><hr>");
	}
}
?>
<hr>
