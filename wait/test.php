<?
session_save_path('./session/');
ini_set('session.gc_maxlifetime', 3*60*60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', FALSE);
ini_set('session.use_only_cookies', TRUE);
session_start();

if($_POST["start"]){
    $rnd=array(0,1,2,3,4,5,6,7,8,9,10,11);
    shuffle($rnd);

    $_SESSION["a"]=$rnd;
    $dat["a"]=$rnd;

    shuffle($rnd);
    $_SESSION["b"]=$rnd;
    $dat["b"]=$rnd;

    shuffle($rnd);
    $_SESSION["c"]=$rnd;
    $dat["c"]=$rnd;

    shuffle($rnd);
    $_SESSION["card"]=$rnd;
    $dat["card"]=$rnd;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
.main{
    width:100%;
    max-width:600px;
    background:#f0f0f0;
    margin:0 auto;    
}

.hako{ 
    display:inline-block;
    width:55px;
    height:55px;
    line-height:55px;
    background:#f00000;
    box-sizing:border-box;
    border:0.5vw solid #0000ff;
    text-align:center;
    font-size:20px;
}

.table_a{
    width:100%;    
    background:#e0f0ff;
}

.td_a{
    width:120px;    
    background:#a0f0ff;
}

.table_b{
    width:100%;    
    background:#e0f0ff;
}

.td_b1{
    height:30px;    
    background:#00f020;
}

.td_b2{
    background:#00f0ff;
}

.p_name{
    display:inline-block;
    width:200px;
    background:#ff5030;
}

.p_status{
    display:inline-block;
    width:45px;
    background:#ff50a0;
}

.p_pts{
    display:inline-block;
    width:74px;
    height:40px;
    background:#cccccc;
    box-sizing:border-box;
    border:1px solid #ffffff;
	color:#fafafa
}

.p_pts_on{
    background:#906000 !important;
}
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script>
var Turn=0;
$(function(){ 
    $(".p_pts_on").on('click',function(){
        Turn++;
        $(this).removeClass('p_pts_on');
        No=$(this).attr('id').replace('i','');
		$.post("post_read_turn.php",
			{
				'turn':Turn,
				'bet':No,
			},
			function(data){
                $('.td_a').text(Turn);

                
			}
		);

    });
});
</script>
</head>
<body style="text-align:center">
<div class="main">
<table class="table_a">
	<tr>
		<td class="td_a">あ</td>
		<td>
			<table class="table_b">
				<tr>
					<td class="td_b1">
						<span class="p_name">みりあ</span>
						<span class="p_status">みり</span>
						<span class="p_status">みり</span>
						<span class="p_status">みり</span>
						<span class="p_status">みり</span>
						<span class="p_status">みり</span>
					</td>
				</tr>
				<tr>
					<td class="td_b2"><?for($n=0;$n<12;$n++){?><span id="i<?=$n?>" class="p_pts p_pts_on"></span><?}?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
</body>
</html>