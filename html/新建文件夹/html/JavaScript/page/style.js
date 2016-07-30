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

	


})