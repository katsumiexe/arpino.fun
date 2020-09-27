<?php
include_once("./library/session.php");

$sql	 ="SELECT * FROM log_data";
if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Card_Game_Aigis</title>
<style>
.main{
	position:relative;
	
}
.pc1,.pc2,.pc3{
	position	:absolute;
	width		:25vw;
	height		:25vw;
	top			:1vw;
}
.pc1{
	left:1vw;
	background:#ff0000;
}

.pc2{
	left:27vw;
	background:#009000;
}

.pc3{
	left:55vw;
	background:#0000ff;
}


</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>
<script>
</script>
</head>
<body style="text-align:center;background:#888888">
<div class="main">

<div class="pc1"></div>
<div class="pc2"></div>
<div class="pc3"></div>

<div class="stage1"></div>
<div class="stage2"></div>
<div class="stage3"></div>

<div class="cd1"></div>
<div class="cd2"></div>
<div class="cd3"></div>
<div class="cd4"></div>

<div class="yama1"></div>
<div class="yama2"></div>




</div>
</body>
</html>
