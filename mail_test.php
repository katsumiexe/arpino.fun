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

			$tmp_log="";
			$main_log="";

			$tmp=explode("\n",$tmp_body);
			$tmp1=explode($tmp[0],$tmp_body);

			for($n=0;$n<count($tmp1);$n++){

				if(substr_count($tmp1[$n], "Content-Type: text/plain")>0){
					$tmp2=explode("\n",$tmp1[$n]);

					for($t=0;$t<count($tmp2);$t++){
						if(substr_count($tmp2[$t], "Content-Transfer-Encoding")==0 && substr_count($tmp2[$t], "Content-Type:")==0 ){
							$main_log.=$tmp2[$t];
						}
					}
				}

				if(substr_count($tmp1[$n], "Content-Type: image/")>0){
					$tmp3=explode("\n",$tmp1[$n]);

					for($s=0;$s<count($tmp3);$s++){
						if(substr_count($tmp3[$n], "Content-Type: image/")>0){
							$tmp4=explode('"',$tmp3[$n]);
							$img_name=$tmp4[1];

						}elseif(substr_count($tmp3[$n], "Content-")===0){
							$img_log.=$tmp3[$n];
						}
					}
				}
			}

			$tmp_body=base64_decode($main_log);
//			$tmp_body=$main_log;
		}

		$dat[$s]["body"]=$tmp_body;

    }
	for($n=0;$n<$s;$n++){
		print($dat[$n]["udate"]."<br>\n");
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
