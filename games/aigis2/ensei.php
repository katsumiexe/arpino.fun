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
	width		:600px;
	height		:600px;
	max-width	:600px;
	position	:relative;
	background	:#fafafa;
}

.pc1,.pc2,.pc3{
	position	:absolute;
	width		:160px;
	height		:160px;
	top			:10px;
}
.pc1{
	left:10px;
	background:#ff0000;
}

.pc2{
	left:180px;
	background:#009000;
}

.pc3{
	left:350px;
	background:#0000ff;
}

.fa1{
	position	:absolute;
	width		:100px;
	height		:100px;
	top			:0;
	left		:0;
	background	:#d0d0d0;
}

.score{
	position	:absolute;
	display		:flex;
	width		:60px;
	min-height	:160px;
	top			:0;
	left		:100px;
	background	:#9090a0;
}


.pc1{
	left:10px;
	background:#ff0000;
}

.cd1,.cd2,.cd3,.cd4{
	position	:absolute;
	width		:80px;
	height		:120px;
	bottom		:10px;
}

.cd1{
	left:10px;
	background:#0000ff;
}

.cd2{
	left:100px;
	background:#0000ff;
}

.cd3{
	left:190px;
	background:#0000ff;
}

.cd4{
	left:280px;
	background:#0000ff;
}

.set1,.set2,.set3{
	position	:absolute;
	width		:80px;
	height		:120px;
	bottom		:140px;
}

.set1{
	left:10px;
	background:#d0d0d0;
}

.set2{
	left:100px;
	background:#d0d0d0;
}

.set3{
	left:190px;
	background:#d0d0d0;
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

<div class="pc1">
	<div class="fa1"></div>
	<div class="score">
		<span class="sc1"></span>
		<span class="sc2"></span>
		<span class="sc3"></span>
		<span class="sc_ttl"></span>
	</div>
</div>

<div class="pc2">
	<div class="fa1"></div>
	<div class="score">
		<span class="sc1"></span>
		<span class="sc2"></span>
		<span class="sc3"></span>
		<span class="sc_ttl"></span>
	</div>
</div>

<div class="pc3">
	<div class="fa1"></div>
	<div class="score">
		<span class="sc1"></span>
		<span class="sc2"></span>
		<span class="sc3"></span>
		<span class="sc_ttl"></span>
	</div>
</div>




<div class="stage1"></div>
<div class="stage2"></div>
<div class="stage3"></div>

<div class="cd1"></div>
<div class="cd2"></div>
<div class="cd3"></div>
<div class="cd4"></div>

<div class="set1"></div>
<div class="set2"></div>
<div class="set3"></div>

<div class="yama1"></div>
<div class="yama2"></div>
</div>
</body>
</html>
