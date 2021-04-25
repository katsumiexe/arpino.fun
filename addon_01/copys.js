$(function(){ 
var bN;
var TMP;
var len		=20;
var UseCode	=0;
var SetCode	=0;
var SetName	="";

var Log		= new Array();
var Color	= new Array();
var Cl		= new Array();
var Tmpl	= new Array();
var Name	= new Array();

var User	= {};

Color[0]="#e0e0e0";
Color[1]="#ff9090";
Color[2]="#c0ffc0";
Color[3]="#c0c0ff";
Color[4]="#c0ffff";
Color[5]="#ffc0ff";
Color[6]="#ffffc0";
Color[7]="#ffb050";

$.getJSON("user.json").done(function(User,textStatus,jqXHR) {

/*	User=JSON.parse(User); */
	$('#user_name').text(User[1].set_name);
	$('#add_from').val(User[1].address);
	$('#add_title').val(User[1].title);
	$('#user_from').text(User[1].name);
	console.log(User);
});

$.getJSON("dat0_1.json", function(dat){
	for(var i = 0; i < len; i++) {
		Log[i]=dat[i].log;
		$('#b'+i).html(dat[i].title).css('background', Color[dat[i].color]);
	}
});

	$('.btn').on('click', function() {
		var bN = $(this).val();
		if (bN == 20){
			$('#txtarea1').val("");
		}else{
			var strInsert =Log[bN];
			var strOriginal = $('#txtarea1').val();
			var posCursole = $('#txtarea1').get(0).selectionStart;
			var leftPart = strOriginal.substr(0, posCursole);
			var rightPart = strOriginal.substr(posCursole, strOriginal.length);
			$('#txtarea1').val(leftPart + strInsert + rightPart);
		}
	});

	$('.btn2').on('click', function() {
		var bN = $(this).val();
		$.getJSON("dat0_"+bN+".json", function(dat2){
			for(var i = 0; i < len; i++) {
				Log[i]=dat2[i].log;
				$('#b'+i).html(dat2[i].title).css('background', Color[dat2[i].color]);
			}
		});
	});
});

