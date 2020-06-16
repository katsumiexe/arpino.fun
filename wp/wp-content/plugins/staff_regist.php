<style>
<!--
input[type=text]{
	height:30px;
}

.w200{
	width:200px;
}

.w50{
	width:60px;
}

.w40{
	width:40px;
}
-->
</style>
<div class="wrap">
<h2>スタッフ登録</h2>
<form action="" method='post' id="my-submenu-form">
<button type='submit' value='保存' class='button button-primary button-large' name="set" value="保存">保存</button>
<button type='submit' value='保存' class='button button-primary button-large' name="del" value="削除">削除</button>
<input type="hidden" value="1" name="staff_set">
<table>
<tr><td>
	<div>名前			</div><input type="text" name="staff_name" class="w200" autocomplete="off">
	<div>フリガナ		</div><input type="text" name="staff_kana" class="w200" autocomplete="off">
	<div>生年月日		</div><input type="text" id="b_yy" name="b_yy" class="w60" value="1990" size="4" maxlength="4" autocomplete="off">年 <input type="text" class="w40" id="b_mm" name="b_mm" value="01" size="2" maxlength="2" autocomplete="off">月 <input type="text" class="w40" id="b_dd" name="b_dd" value="01" size="2" maxlength="2" autocomplete="off">日
	<div>性別			</div>
	<input id="sex1" type="radio" name="staff_sex" value="1"><label for="sex1">男性</label>
	<input id="sex2" type="radio" name="staff_sex" value="2"><label for="sex2">女性</label> 
	<input id="sex3" type="radio" name="staff_sex" value="3"><label for="sex3">他</label> 
	
	<div>ランク			</div><input type="text" name="staff_rank" class="w200" autocomplete="off">
	<div>役職			</div><input type="text" name="staff_position" class="w200" autocomplete="off">
	<div>グループ		</div><input type="text" name="staff_group" class="w200" autocomplete="off">
	<div>電話番号		</div><input type="text" name="staff_tel" class="w200" autocomplete="off">
	<div>住所			</div><input type="text" name="staff_address" class="w200" autocomplete="off">

</td><td>
	<div>CAST_ID		</div><input type="text" name="cast_id" class="w200" autocomplete="off">
	<div>CAST_PASS		</div><input type="text" name="cast_pass" class="w200" autocomplete="off">
	<div>CAST名			</div><input type="text" name="genji" class="w200" autocomplete="off">
	<div>フリガナ		</div><input type="text" name="genji_kana" class="w200" autocomplete="off">
	<div>CASTメール		</div><input type="text" name="castmail" class="w200" autocomplete="off">
	<div>CASTメール_PASS</div><input type="text" name="castmail_pass" class="w200" autocomplete="off">
</td>
</tr>
</table>
</form>
</div> 
