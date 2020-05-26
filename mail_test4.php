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

		$tmp_body	= imap_body($m_list,$s);
		$tmp_body	= trim($tmp_body);

		if(strpos($tmp_body,"Content-Type") !== false){
			$bound		="";
			$chara		="";
			$enc		="";
			$total_list	="";

			$tmp=explode("\n",$tmp_body);
			$tmp1=explode($tmp[0],$tmp_body);
			$tmp2=explode("\n",$tmp1[1]);


			for($n=0;$n<count($tmp2);$n++){
				if(strpos($tmp2[$n], "boundary") !== false){
					$tmp3=explode('"',$tmp2[$n]);
					$bound="--".$tmp3[1];
				}

				if(strpos($tmp2[$n], "charset") !== false && !$chara){
					$tmp3=explode('"',$tmp2[$n]);
					$chara=$tmp3[1];
				}

				if(strpos($tmp2[$n], "Encoding") !== false){
					$tmp3=explode(':',$tmp2[$n]);
					$enc=trim($tmp3[1]);
				}

				if(strpos($tmp2[$n], "Content-") === false && strpos($tmp2[$n], "charset") === false){
					$total_list.=$tmp2[$n]."\n";
				}
			}

			if($bound){
				$tmp4=explode($bound,$total_list);
				$total_list=$tmp4[1];
			}

			if($enc=="quoted-printable"){
				$tmp_body=quoted_printable_decode($total_list);

			}elseif($enc=="base64"){
				$tmp_body=base64_decode($total_list);

			}else{
				$tmp_body=$total_list;
			}

			if($chara=="iso-2022-jp"){
				$tmp_body=mb_convert_encoding($tmp_body,"UTF-8","iso-2022-jp");
			}
		}
print($s."◇".$enc."□".$chara2."<br>\n");

		$dat[$s]["body"]=str_replace("\n","<br>",$tmp_body);
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
