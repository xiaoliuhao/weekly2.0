$(function(){
	var now = 0;
	function module(){
		var $moduleBtn = $(".moduleBtn");
		var moduleLen = $moduleBtn.length;
		for(var i =0;i<moduleLen;i++){
			(function(i){
				$(".moduleBtn").eq(i).click(function(){
					$(".module").eq(now).removeClass("now");
					$(".module").eq(i).addClass("now");
					now = i;
				})
			})(i);
			
		}
	}
	module();
})