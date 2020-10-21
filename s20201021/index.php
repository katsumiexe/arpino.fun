<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){ 
	setInterval(function(){
		$('#form').submit();		
	},600000);
})
</script>
</head>
<body>
<form id="form" method="post" action="index.php"></form>
<div class="calc_box">
<?=date("Y-m-d H:i:s")?>
</div>
</body>
</html>
