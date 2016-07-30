$(function(){

	var maskheight = window.innerHeight;
	$(".mask").css("height",maskheight + "px");
	$(".passMask").css("height",maskheight + "px");
	$(".comMask").css("height",maskheight + "px");
	$(".creTeamMask").css("height",maskheight + "px");
	$(".examMask").css("height",maskheight + "px");

	var src=$(".pdphoto").children("img").attr("src");

	$(".pdtab").click(function(){
		$(".pdPanel").css("display","none");
		$(".cpdphoto").children("img").attr("src",src);
		$(".changePd").css("display","block");
	})

	$(".pdbtn").click(function(){
		$(".mask").fadeIn();
	})

	$(".back").click(function(){
		$(".mask").fadeOut();
		$(".passMask").fadeOut();
		$(".comMask").fadeOut();
		$(".creTeamMask").fadeOut();
		$(".examMask").fadeOut()
		console.log("hello");
	})

	$(".passBtn").click(function(){
		$(".passMask").fadeIn()

	})

	$(".comment").click(function(){
		$(".comMask").fadeIn();

	})

	$(".cbtn").click(function(){
		$(".creTeamMask").fadeIn();
	})

	$(".ePho").click(function(){
		$(".examMask").fadeIn();
	})

	var triggle_1 = 0

	$(".auto").click(function(){
		if(triggle_1 == 0){
			$(this).parent("li").addClass("active");
			triggle_1 = 1;
		}else{
			$(this).parent("li").removeClass("active");
			triggle_1 = 0;
		}
		
	})

	var triggle_2 = 0;
	$(".res_1").click(function(){
		if(triggle_2 == 0){
			$(this).addClass("active");
			$(".navbar-collapse").addClass("show");
			triggle_2 = 1;
		}else{
			$(this).removeClass("active");
			$(".navbar-collapse").removeClass("show");
			triggle_2 = 0;
		}
	})

	var triggle_3 = 0;
	$(".res_2").click(function(){
		if(triggle_3 == 0){
			$(this).addClass("active");
			$(".app-aside").addClass("off-screen");
			triggle_3 = 1;
		}else{
			$(this).removeClass("active");
			$(".app-aside").removeClass("off-screen");
			triggle_3 = 0;
		}
	})




	


})