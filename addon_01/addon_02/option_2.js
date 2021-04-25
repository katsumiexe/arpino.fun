var tmp_a;
var tmp_b;
/*
$.getJSON("dat1.json", function(dat){
	for(var i = 0; i < 20; i++) {
		tmp_a="text"+i;
		tmp_b="log"+i;
		document.getElementById(tmp_a).defaultValue =dat[i].title;
		document.getElementById(tmp_b).defaultValue =dat[i].log;
	}
})
*/

$(function(){
	$('#tab-menu li').on('click', function(){
		if($(this).not('active')){
			$(this).addClass('active').siblings('li').removeClass('active');
			var index = $('#tab-menu li').index(this);
			$('#tab-box div').eq(index).addClass('active').siblings('div').removeClass('active');

			if(0 < index && index < 5){
				var tmp_json="dat"+index+".json";
				$.getJSON(tmp_json, function(dat){

					for(var i = 0; i < 20; i++) {
					var a1=(index - 1) * 20 + i;
						tmp_a="text"+ a1;
						tmp_b="log" + a1;
						document.getElementById(tmp_a).defaultValue =dat[i].title;
						document.getElementById(tmp_b).defaultValue =dat[i].log;
					}
				})
			}
		}
	});
});

