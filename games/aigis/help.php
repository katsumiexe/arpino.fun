<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="./css/main.css?_<?=date("YmdHi")?>">
<style>
</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="./js/main.js?_<?=date("YmdHi")?>"></script>


</head>
<body style="text-align:center;background:#303030">
<div class="main">


	<div class="howto">
		<div class="howto_page">
			<span class="score_back"></span>
			<span id="ibox0" class="howto_page_tag">準備</span>
			<span id="ibox1" class="howto_page_tag">進行</span>

			<span id="ibox2" class="howto_page_tag">ユニット</span>
			<span id="ibox3" class="howto_page_tag">アイテム</span>
			<span id="ibox4" class="howto_page_tag">魅力</span>

			<span id="ibox5" class="howto_page_ttl">カード種類</span>

		</div>

		<div class="howto_main">
			<div id="box0" class="howto_in" style="display:block;">
				<div class="howto_title">準備</div>
				各プレイヤーに1枚、<span style="color:#101010">『ユニットカード』</span>を裏向きで1枚配ります。<bR>
				配られた<span style="color:#101010">『ユニットカード』</span>は見ることが可能ですが、他のプレイヤーにはゲーム終了まで見せないようにしてください。<br>
				<span style="color:#101010">『アイテムカード』</span>を各1枚づつ、計12枚を各プレイヤーに配ります。<bR>
				<span style="color:#101010">『魅力カード』</span>をシャッフルし、裏向けに置いてゲームスタートです。<br>
			</div>
			
			<div id="box1" class="howto_in">
				<div class="howto_title">進行</div>
				ターンのはじめに<span style="color:#101010">『魅力カード』</span>が一枚提示されます。<br>
				各プレイヤーはそれぞれ<span style="color:#101010">『アイテムカード』</span>を一枚捧げます。<br>
				このときに、最も価値の高いものを出した人が<span style="color:#101010">『魅力カード』</span>を獲得できます。<br>
				ただし、同じ<span style="color:#101010">『アイテムカード』</span>を出した人がいた場合はブッキングとなり、対象は次に高い人になります。<br>
				全員がブッキングした場合、その魅力はだれも受け取ることが出来ません。<br>
				一度使った<span style="color:#101010">『アイテムカード』</span>は再度使うことはできません。<br>
				これを12ターン行い、【魅力ポイント】が最も高いプレイヤーの勝利です。<br>
				<br>
				同点の場合は、<br>
				「副官任命」を持っているユニット<br>
				「リング」を持っているユニット<br>
				の順に順位がつけられます。<br>
				それでも同じ場合は、同点となります。
			</div>

			<div id="box2" class="howto_in">
				<div class="howto_title">ユニットカード（10種類）</div>
				王子を慕う10人の女性ユニットです。<br>
				各プレイヤーはスタート時に1枚選択します。<br>
				各ユニットは『巨乳』『幼女』『知的』『清楚』『天使』の5つのチャームポイントのうち、2つを有しています。<br>
				他のプレイヤーがどのユニットを選択したかは、ゲーム終了までわかりません。<br>
			</div>

			<div id="box3" class="howto_in">
				<div class="howto_title">アイテムカード（12種類）</div>
				王子から頂いたプレゼントでこれを捧げることで、<span style="color:#101010">【魅力ポイント】</span>を獲得することができます。<br>
				スタート時は各1つづつ、計12個を所持しています。<br>
				アイテムの価値は<br>
				<span class="howto_item"></span>ダイヤ3<br>
				<span class="howto_item"></span>ダイヤ2<br>
				<span class="howto_item"></span>ダイヤ1<br>
				<span class="howto_item"></span>ルビー3<br>
				<span class="howto_item"></span>ルビー2<br>
				<span class="howto_item"></span>ルビー1<br>
				<span class="howto_item"></span>パール3<br>
				<span class="howto_item"></span>パール2<br>
				<span class="howto_item"></span>パール1<br>
				<span class="howto_item"></span>花束3<br>
				<span class="howto_item"></span>花束2<br>
				<span class="howto_item"></span>花束1<br>
				の順となります。<br>
			</div>


			<div id="box4" class="howto_in">
				<div class="howto_title">魅力カード（12種類）</div>
				『魅力カード』には、それぞれ【魅力ポイント】が設定されており、それを他のプレイヤーより多く獲得することが目的となります。<br>
				選んだ<span style="color:#101010">『ユニットカード』</span>が持つチャームポイントによって、獲得ポイントが変わるものもあります。<br>
				<br>
				副官任命（1枚）<br>
				魅力ポイント+3<br>
				<br>
				リング（1枚）<br>
				魅力ポイント+2<br>
				<br>
				ボーナスカード（5枚）<br>
				魅力ポイント+1、対象の魅力を所持しているユニットだと+3となります。<br>
				<br>
				アンチカード（5枚）<br>
				魅力ポイント+2、対象の魅力を所持しているユニットだと逆効果となり-2となります。<br>
			</div>
		</div>
	</div>

</div>
</body>
</html>
