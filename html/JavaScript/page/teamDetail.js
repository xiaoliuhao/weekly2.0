$(function(){
	var token = sessionStorage.getItem("token");
	var uid = sessionStorage.getItem("uid");
	var name = sessionStorage.getItem("name");
	var photo = sessionStorage.getItem("photo");
	console.log(uid);

	var location = window.location.href;

	var gid = location.split("gid=")[1];
	console.log(gid); 

	var urlHead = "http://115.159.54.210/weekly/index.php";



	var postData = {

		teamDetail: function(gid,urlHead){
			var type = "get";
			var url = urlHead + "/group/detail?gid=" + gid; 
			var data = null;
			var teamDetail = getData(url,type,data);
			console.log(teamDetail);

			var teamTemplate = Handlebars.compile($("#team-template").html());
			$("#teamDetail").append(teamTemplate(teamDetail));


			var link = $(".tmateURL").attr("href");
			console.log(link);
			$(".tmateBtn").attr("href",link);

		},
		exam: function(token,urlHead,gid){

			var type = "POST";
			var url = urlHead + "/admin/check_members";
			var data = {
				"token" : token,
				"gid" : gid
			}

			console.log(data);
			var returnData = getData(url,type,data);
			console.log(returnData);


			var applyTemplate = Handlebars.compile($("#apply-template").html());
			$("#applyList").append(applyTemplate(returnData.data));


		},

		TMweekly:function(gid,urlHead){
			var type = "GET";
			var url = urlHead + "/weekly/group";
			var data = {
				"gid":gid
			};
			var returnData = getData(url,type,data)
			console.log(returnData);



			var TMWTemplate = Handlebars.compile($("#TMW-template").html());
			$("#TMWList").append(TMWTemplate(returnData.data));

			var wlLEN = $(".WL").length;
			for(var i=0;i<wlLEN;i++){
				for (var content in returnData.data[i]){
					$(".WL").eq(i).html(returnData.data[i].content)
					console.log(returnData.data[i].content);
					break;
				}
			}


			// var weeklyLen = $(".myweekly").length;
			// console.log(weeklyLen);
			// for(var i=0;i<weeklyLen;i++){
			// 	for (var content in myWeekly.data[i]){
			// 		$(".myweekly").eq(i).html(myWeekly.data[i].content)
			// 		console.log(myWeekly.data[i].content);
			// 		break;
			// 	}	
			// }



		},

		agreeE: function(token,uid,urlHead){

			var type = "POST";
			


			var examLen = $(".agress").length;

			for(var i=0;i<examLen;i++){
				(function(i){
					$(".agress").eq(i).click(function(){
						var url = urlHead + "/admin/add_member";
						var uid = $(this).attr("myattr");
						var data = {
							"token":token,
							"gid":gid,
							"applyid":uid
						}
						console.log(data);
						var returnData = getData(url,type,data);
						console.log(returnData);

						if(returnData.status == 200){
							alert("允许通过");
							window.reload();
						}else{
							alert("你的权限不足")
						}

					})


					$(".refuse").eq(i).click(function(){
						var url = urlHead + "/admin/refuse"
						var uid = $(this).attr("myattr");
						var data = {
							"token":token,
							"gid":gid,
							"applyid":uid
						}
						console.log(data);
						var returnData = getData(url,type,data);
						console.log(returnData);

						if(returnData.status == 200){
							alert("操作成功");
							window.reload();
						}else{
							alert("你的权限不足")
						}


					})


				})(i);
			}


			// $(".allowBtn").click(function(){
			// 	console.log("hello");
			// 	var uid = $(this).attr("uid");
			// 	var gid = $(this).attr("gid");
			// 	var data = {
			// 		"token":token,
			// 		"gid":gid,
			// 		"applyid":uid
			// 	}

			// 	console.log(data);
			// 	var returnData = getData(url,type,data);
			// 	console.log(returnData);

			// 	if(returnData.status == 200){
			// 		alert("允许通过");
			// 		window.reload();
			// 	}else{
			// 		alert("你的权限不足")
			// 	}

			// });

		},

		revokeMana:function(token,gid,urlHead,ouid){

			var url = urlHead + "/admin/delete";
			var type = "POST";
			console.log(ouid);

			var cmanaLen = $(".cmana").length;
			for(var i=0;i<cmanaLen;i++){
				(function(i){
					$(".cmana").eq(i).click(function(){

						var uid = $(this).attr("myattr");
						console.log(uid);
						var suid = $(".creater").text();
						var data = {	
							"token":token,
							"gid":gid,
							"admin_id":uid
						}
						console.log(ouid,suid);
						if(suid == ouid){
							var returnData = getData(url,type,data);
							console.log(returnData);

						}
						else{
							alert("您无此权限");
						}

					})
				})(i);
			}


		},
		viewtData:function(gid,urlHead){
			var url = urlHead + "/group/detail";
			var type = "GET";
			var data = {
				"gid" : gid
			};

			var returnData = getData(url,type,data);
			console.log(returnData);

			var gdataTemplate = Handlebars.compile($("#gdata-template").html());
			$("#gdataList").append(gdataTemplate(returnData));

		},
		viewMana:function(gid,urlHead){
			var url = urlHead + "/group/admins";
			var type = "GET";
			var data = {
				"gid":gid
			};

			var returnData = getData(url,type,data);
			console.log(returnData);

			var mTemplate = Handlebars.compile($("#m-template").html());
			$("#mList").append(mTemplate(returnData.data));
		},
		ctData:function(token,gid,urlHead){
			var type = "POST";
			var url = urlHead + "/group/update"
			var introduce = $(".g_introduce").text();
			var name = $(".g_name").text();
			console.log(name);
			console.log(introduce);
			var data = {
				"token":token,
				"gid":gid,
				"name":name,
				"introduce":introduce
			}

			var returnData = getData(url)

		}



	}



	var getData = function (url,type,data) {

		var returnData;

		$.ajax({
			type:type,
			dataType:"JSON",
			url:url,
			data:data,
			async:false,
			success: function(data){
				console.log(data);
				returnData = data;
			},
			error: function(jqXHR,textStatus,errorThrown){
				 console.log(jqXHR.status);
                 console.log(jqXHR.readyState);
                 console.log(jqXHR.statusText);
                 console.log(textStatus);
                 console.log(errorThrown);
			}
		});

		return returnData;

	}

	function init(token,gid,urlHead,uid){
		postData.teamDetail(gid,urlHead);
		postData.exam(token,urlHead,gid);
		postData.TMweekly(gid,urlHead);
		postData.viewtData(gid,urlHead);

		postData.viewMana(gid,urlHead);
		postData.agreeE(token,gid,urlHead);
		postData.revokeMana(token,gid,urlHead,uid);

	}

	init(token,gid,urlHead,uid);


	function navTurn(){
		
		var tpLen = $(".tp").length;
		console.log(tpLen);
		var now_1 = 0;
		var now_2 = 0;
		for(var i=0;i<tpLen;i++){
			(function(i){
				$(".tp").eq(i).click(function(){
					console.log(i);
					$(".box").eq(now_1).removeClass("ap");
					$(".nav").eq(now_2).removeClass("active");
					$(".nav").eq(i).addClass("active");

					$(".box").eq(i).addClass("ap");
					now_1 = i;
					now_2 = i;

				})
			})(i);
		}



	}
	navTurn();


	

})
