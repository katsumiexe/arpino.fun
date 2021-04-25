var tmp_a;
var tmp_b;
var tmp_c;
var tmp_d;

$(function(){
	$('#tab-menu li').on('click', function(){
		if($(this).not('active')){
			$(this).addClass('active').siblings('li').removeClass('active');

			var index = $('#tab-menu li').index(this);

			if(index == 0){
				$("#tab01").addClass('active')
				$("#tab02").removeClass('active')
				$("#tab03").removeClass('active')

			}else if(0 < index && index < 5){
				$("#tab01").removeClass('active')
				$("#tab02").addClass('active')
				$("#tab03").removeClass('active')

				var tmp_json="dat"+index+".json";
				$.getJSON(tmp_json, function(dat){
					for(var i = 0; i < 20; i++) {
						tmp_a="#text"+ i;
						tmp_b="#log" + i;
						tmp_c="cl" + i;
						tmp_d=dat[i].color;

						$('#text'+ i).val(dat[i].title);
						$('#log'+ i).val(dat[i].log);
						document.getElementsByName(tmp_c)[tmp_d].checked = true;
					}
				})

			} else {
				$("#tab01").removeClass('active')
				$("#tab02").removeClass('active')
				$("#tab03").addClass('active')
			}
		}
	});

	$('#save').click(function(){
		$.post(
	        "logset.php",
			{
            'top'	: Top,
            'left'	: Left,
            'vsize'	: vSize,
            'wsize'	: wSize,
            'rote'	: Rote,
            'zoom'	: Zoom,
            'wturn'	: wTurn,
            'vturn'	: vTurn,
            'bright': Bright
	        },
			function(data){
				alert(data);
			}
		);
	});




});

