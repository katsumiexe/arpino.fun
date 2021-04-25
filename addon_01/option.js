
var tmp_a;
var tmp_b;
var tmp_c;
var tmp_d;

var SetName		=[];
var SetAddress	=[];
var SetEnter	=[];
var SetHistry	=[];
var SetTitle	=[];
var SetQuote	=[];
var SetLabel	=[];
var SetStar		=[];
var SetSignet	=[];
var SetStaff	=[];
var SetSender	=[];
var Tmp="";
var UseId=0;

$.getJSON("user.json", function(User){
	for(var j1 in User){
		SetName[j1]		=User[j1].set_name;
		SetAddress[j1]	=User[j1].address;
		SetEnter[j1]	=User[j1].enter;
		SetHistry[j1]	=User[j1].history;
		SetTitle[j1]	=User[j1].title;
		SetQuote[j1]	=User[j1].quote;
		SetLabel[j1]	=User[j1].label;
		SetStar[j1]		=User[j1].star;
		SetSignet[j1]	=User[j1].signet;
		SetStaff[j1]	=User[j1].staff;
		SetSender[j1]	=User[j1].name;

		Tmp+="<option value=\""+j1+"\">"+User[j1].set_name+"</option>";
	}
});


$(function(){
	$(".user_select").html(Tmp);
	$('#tab-menu li').on('click', function(){
		if($(this).not('active')){
			$(this).addClass('active').siblings('li').removeClass('active');

			index = $('#tab-menu li').index(this);

			if(index == 0){
				$("#tab01").addClass('active')
				$("#tab02").removeClass('active')
				$("#tab03").removeClass('active')

			}else if(0 < index && index < 5){
				$("#tab01").removeClass('active')
				$("#tab02").addClass('active')
				$("#tab03").removeClass('active')

				tmp_json="dat"+UseId+"_"+index+".json";


				$.getJSON(tmp_json, function(dat){
					for(var i = 0; i < 20; i++) {
						tmp_a="#text"+ i;
						tmp_b="#log" + i;
						tmp_c="cl" + i;
						tmp_d=dat[i].color;
						$('#text'+ i).val(dat[i].title);
						$('#log'+ i).val(dat[i].log);
						$('input[name=' +tmp_c +']:eq('+tmp_d+')').prop('checked',true);
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
	});

	$(".user_select").on('change',function(){
		var UseId=$(this).val();

		if(index == 0){
		}else if(0 < index && index < 5){

			tmp_json="dat"+UseId+"_"+index+".json";
			$.getJSON(tmp_json, function(dat){
				for(var i = 0; i < 20; i++) {
					tmp_a="#text"+ i;
					tmp_b="#log" + i;
					tmp_c="cl" + i;
					tmp_d=dat[i].color;
					$('#text'+ i).val(dat[i].title);
					$('#log'+ i).val(dat[i].log);
					$('input[name=' +tmp_c +']:eq('+tmp_d+')').prop('checked',true);
				}
			})

			console.log(tmp_json);

		}
	});
});
