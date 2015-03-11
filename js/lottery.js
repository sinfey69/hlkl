	$(function(){ 
	     $("#startbtn").click(function(){
	    	$(".sure").hide();
	        lottery(); 
	     });
	     
	     $(".mi-right").click(function(){	    	 
	    	 $("#intro2").hide();
	    	 $("#intro1").show();
	     });
	    	 
	     $(".mi-left").click(function(){
	    	 $("#intro1").hide();
	    	 $("#intro2").show();
	     });
	     
	     $(".start").click(function(){
	    	 $(".sure").show();
	     });
	     
	     $("#close_sure").click(function(){
	    	 $(".sure").hide();
	     });
		 $("#close_select").click(function(){
	    	 $(".select").hide();
	     });
		 $("#show_select").click(function(){
	    	 $(".select").show();
			 GetList();
	     });
		 
	     maquer();     
	}); 
	
	function lottery(){ 
	    $.getJSON("data.php?t="+new Date().getTime(),function(json){ 
				var p = json.prize;
				if( json.code == -1){
					alert(p);
					return false;
				}
	            $("#startbtn").unbind('click').css("cursor","default"); 
				var a = json.angle; 
	            $(".start").rotate({ 
	                duration:3000, //转动时间 
	                angle: 0, //默认角度
	                animateTo:1800+a, //转动角度 
	                easing: $.easing.easeOutSine, 
	                callback: function(){
	                	if(json.is_prize == 0){
	                		alert(p);
	                	}else{
							if(json.is_real == 1){
								$(".g-b").html('恭喜你，抽中“'+p+'”');
								$(".did").val(json.did);
								$(".draw_id").val(json.draw_id);
								$("#address_list").html(json.consignee);
								$(".get").show();
							}else{
								alert('恭喜你，抽中“'+p+'”');
							}
	                	}
	                     
	                    $("#startbtn").click(function(){
	                    	$(".sure").hide(); 
	                    	lottery(); 
	                    }).css("cursor","pointer");	                    
	                } 
	            }); 
	    }); 
	}
	
	function maquer(){	
	    setInterval(function(){
	        $('#rightDemo li:first').animate({'height':'0','opacity': '0'}, 'slow', function() {
	          $(this).removeAttr('style').insertAfter('#rightDemo li:last');
	        });

	    },1000);
	    
	    //$(this).attr('disabled',true);
	    //return;
	}
	function GetList(){
		Ajax.call('draw.php?is_ajax=1', 'act=query', resultList, 'POST', 'JSON');
	}
	function resultList(result){
		if(!result.error){
			$('#listDiv').html(result.content);
			var s_w = $(".select").width();
			$(".select").css({"left":(1097/2)-(s_w/2)+'px',"top":'200px'});
		}else{
			alert(result.message);
			$('#listDiv').html('请先登录后查看');
		}
	}
