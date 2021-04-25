var bN;
var TMP;
var len = 20;
var Log = new Array( );
var Color = new Array( );
var Cl = new Array( );

Color[0]="#e0e0e0";
Color[1]="#ff9090";
Color[2]="#c0ffc0";
Color[3]="#c0c0ff";
Color[4]="#c0ffff";
Color[5]="#ffc0ff";
Color[6]="#ffffc0";
Color[7]="#ffb050";



$.getJSON("dat1.json", function(dat){
/*	var len = dat.length;*/
	for(var i = 0; i < len; i++) {
		Log[i+1]=dat[i].log;
		document.getElementById(i+1).innerHTML =dat[i].title;
		$('.c'+i).css('background-color', Color[dat[i].color]);
	}
})


/*tagList[i].style.backgroundColor = "yellow";*/

$(document).ready(function() {
	$('.btn').on('click', function() {
		var bN = $(this).attr('id');

		if (bN == 0){
			document.getElementById('txtarea1').value = '';

		}else{
			var strInsert =Log[bN];
			var strOriginal = document.getElementById('txtarea1').value;
			var posCursole = document.getElementById('txtarea1').selectionStart;
			var leftPart = strOriginal.substr(0, posCursole);
			var rightPart = strOriginal.substr(posCursole, strOriginal.length);
			document.getElementById('txtarea1').value = leftPart + strInsert + rightPart;
		}
	});

	$('.btn2').on('click', function() {
		var bN = $(this).attr('id');

		if (bN == 21){
			$.getJSON("dat1.json", function(dat1){
				for(var n = 0; n < len; n++) {
					Log[n+1]=dat1[n].log;
					document.getElementById(n+1).innerHTML =dat1[n].title;
					$('.c'+n).css('background-color', Color[dat1[n].color]);
				}
			})

		}else if (bN == 22){
			$.getJSON("dat2.json", function(dat2){
				for(var n = 0; n < len; n++) {
					Log[n+1]=dat2[n].log;
					document.getElementById(n+1).innerHTML =dat2[n].title;
					$('.c'+n).css('background-color', Color[dat2[n].color]);
				}
			})


		}else if (bN == 23){
			$.getJSON("dat3.json", function(dat3){
				for(var n = 0; n < len; n++) {
					Log[n+1]=dat3[n].log;
					document.getElementById(n+1).innerHTML =dat3[n].title;
					$('.c'+n).css('background-color', Color[dat3[n].color]);
				}
			})

		}else if (bN == 24){
			$.getJSON("dat4.json", function(dat4){
				for(var n = 0; n < len; n++) {
					Log[n+1]=dat4[n].log;
					document.getElementById(n+1).innerHTML =dat4[n].title;
					$('.c'+n).css('background-color', Color[dat4[n].color]);
				}
			})
		}
	});
});



