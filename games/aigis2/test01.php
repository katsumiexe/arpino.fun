<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<script src="./js/jquery-3.2.1.min.js"></script>
<script>
$(function(){ 
$('input:radio').change( function() {
Tmp=$(this).attr('class');
$('#'+Tmp).val($(this).val());
});
});
</script>
</head>
<body>
<div>
	<br>選択<br/>
	<input type="radio" name="btn1" class="r1" value="あ">A
	<input type="radio" name="btn1" class="r1" value="い">B
</div>
<br/>
<textarea id="r1" class="text" cols=40 rows=2></textarea>

<div>
<br>選択<br/> 
	<input type="radio" name="btn2" class="r2" value="き">G
	<input type="radio" name="btn2" class="r2" value="く">H
</div>
<br/>
<textarea id="r2" class="text" cols=40 rows=2></textarea>




</body></html>
