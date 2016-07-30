
$(function(){
	var token = sessionStorage.getItem("token");
	var uid = sessionStorage.getItem("uid");
	var name = sessionStorage.getItem("name");
	var photo = sessionStorage.getItem("photo");
	var urlHead = "http://115.159.54.210/weekly/index.php";

	function insertData (){
		$(".myName").html(name);
		$(".myPhoto").attr("src",photo);
	}
	insertData();
	var postData = {

		newInform:function(type,token,urlHead){/*点击获得的消息的内容，包括unread和all*/
			var url = urlHead + "/message/get";
			var type_1 = "POST";
			var data = {
				"token":token,
				"type":type
			}
			
			var newInform = getData(data,url,type_1);
			console.log(newInform);
			var newLen = newInform.data.length;
			$(".unreadNum").html(newLen);
			var newTemplate = Handlebars.compile($("#unread-template").html());
			$("#unreadList").append(newTemplate(newInform.data));

			$(".allInform").click(function(){
				
			})



		},
		informDetail:function(token,id,urlHead){/*消息列表*/
			var url = urlHead + "/message/get";
			var data = {
				"token":token,
				"type":"all"
			}
			var type = "POST";	
			var informDetail  = getData(data,url,type);
			var dataLen = informDetail.data.length;
			for(var i = 0;i<dataLen;i++){
				if(informDetail.data[i].status == 1){
					informDetail.data[i].typePanel = "unread";
					informDetail.data[i].type = "未读";
				}
			}
			

			console.log(informDetail);

			var allTemplate = Handlebars.compile($("#all-template").html());
			$("#informList").append(allTemplate(informDetail.data));

			$(".delete").click(function(){
				var type = "POST";
				var url = urlHead + "/message/delete";
				var id = $(this).attr("myAttr");
				console.log(id);
				var data = {
					"token" : token,
					"id" : id
				}

				var deleteDetail  = getData(data,url,type);
				console.log(deleteDetail);
				if(deleteDetail.status == 200){
					alert("消息删除成功");
				}else{
					alert("消息删除失败");
				}
			})

		},
		perDetail:function(uid,urlHead){
			var type = "GET";
			var url = urlHead +  "/user/detail";
			var data = {
				"uid" : uid
			}
			var perDetail = getData(data,url,type);
			console.log(perDetail);

			var pdTemplate = Handlebars.compile($("#pd-template").html());
			$("#pdPanel").append(pdTemplate(perDetail));

			var cpdTemplate = Handlebars.compile($("#cpd-template").html());
			$("#changePd").append(cpdTemplate(perDetail)); 

			var labelTemplate = Handlebars.compile($("#label-template").html());
			$("#banner").append(labelTemplate(perDetail.data.label));


		},
		changeDetail:function(token,type,value,urlHead){
			var type_1="POST";
			var url = urlHead + "/user/update";




			var data = {
				"token" : token,
				"type" : type,
				"value" : value
			};
			/*返回信息*/
			var data = getData(data,url,type_1);
		},
		changePass :function(token,urlHead){
			var type = "POST";
			var url = urlHead + "/User/change_pass";

			$(".savePass").click(function(){
				var oldpass = $(".oldpass").val();
				var newpass = $(".newpass").val();

				if( newpass.length < 6 ){
					$(".passtip").html("  *密码长度大于6")
				}else{

					var data = {
						"token" : token,
						"old_pass" : oldpass,
						"new_pass" : newpass
					};
					var backData = getData(data,url,type);

					//if(backData.status == )
				}
			})
		},
		allWeekly:function(urlHead){
			var type = "get";
			var url = urlHead + "/weekly/all";
			var data = null;
			var returnData = getData(data,url,type);
			console.log(returnData);

			var mainTemplate = Handlebars.compile($("#main-template").html());
			$("#main").append(mainTemplate(returnData.data)); 

			var comTemplate = Handlebars.compile($("#com-template").html());

			var comLen = $(".comment").length;
			for(var i = 0;i<comLen;i++){
				(function(i){
					$(".comment").eq(i).click(function(){
						console.log(returnData.data[i]);
						$("#comList").html(comTemplate(returnData.data[i].comments))
					})
				})(i);
			}

		},
		WriWeekly:function(token,title,content,urlHead){
			var type = "post";
			var url = urlHead +  "/weekly/add";
			var data = {
				"token" : token,
				"title" : title,
				"content" : content
			}
			
			
			var returnData = getData(data,url,type);
			if(returnData.status == 200){
				alert("提交周报成功");
				$("#contentText").html("点击此处，开始周报吧！");
			}
			
		},
		changeWeekly:function(){
			
		},

		markread:function(urlHead){
			var type="GET";
			var url = urlHead + "/message/update";
			var unreadLen = $(".unread").length;
			for(var i=0;i<unreadLen;i++){
				(function(i){
					$(".unread").eq(i).click(function(){

						var id = $(this).attr("tid");
						var data = {
							"id":id
						};

						var returnData = getData(data,urlHead,type);

						if(returnData.status == 200){
							alert("标记成功");
							location.reload();
						}else{
							alert("标记失败");
						}

					})
				})(i);
				
			}
		},
		weeklyView:function(uid,urlHead){
			var url = urlHead + "/weekly/all";
			var orderby = "update_time";
			var type="get";
			var data = {
				"orderby":orderby,
				"uid": uid
			}

			var myWeekly = getData(data,url,type);
			console.log(myWeekly);

			// var weeklyList = JSON.parse(myWeekly);
			// console.log(weeklyList);

			var myTemplate = Handlebars.compile($("#my-template").html());
			$("#allWeekly").append(myTemplate(myWeekly.data)); 

			deleteTab(myWeekly);

			// var weeklyLen = $(".weekly").length;
			// for(var i=0;i<weeklyLen;i++){
			// 	$(".weekly").eq(i).html(myWeekly.data[i].content);
			// }


			var weeklyLen = $(".myweekly").length;
			console.log(weeklyLen);
			for(var i=0;i<weeklyLen;i++){
				for (var content in myWeekly.data[i]){
					$(".myweekly").eq(i).html(myWeekly.data[i].content)
					console.log(myWeekly.data[i].content);
					break;
				}	
			}



		},

		searchTeam:function(urlHead){

			var url = urlHead + "/group/search";
			var type = "POST";
			$(".searchBtn").click(function(){
				var name = $(".stname").val();
				var data = {
					"name":name
				};
				var returnData = getData(data,url,type);
				console.log(returnData);

				var stTemplate = Handlebars.compile($("#st-template").html());
				$("#searchT").append(stTemplate(returnData.data)); 

				postData.joinTeam(token,urlHead);
			})



		},
		joinTeam:function(token,urlHead){
			var url = urlHead + "/member/apply";
			var type = "POST";
			var applyLen = $(".applyBtn").length;
			console.log(applyLen);
			for(var i=0;i<applyLen;i++){
				(function(i){
					
					$(".applyBtn").eq(i).click(function(){
						console.log(i);
						var gid = $(this).attr("myattr");
						var data = {
							"token":token,
							"gid":gid,
							"reason":null
						};

						var returnData = getData(data,url,type);
						console.log(returnData);

						if(returnData.status == 200){
							alert("申请成功");
						}else if(returnData.status == 202){
							alert("你已经在这个群里了");
						}else{
							alert("申请失败");
						}

					})
					
				})(i);
			}
		},
		newTeam:function(token,urlHead){

			var type = "POST";
			var url = urlHead + "/group/add";
			
			$(".creBtn").click(function(){

				var Tname = $(".cTname").val();
				var intro = $(".cTIntro").val();
				console.log(Tname);
				if(name != undefined){
					var data = {
						"token":token,
						"name":name,
						"introduce":intro
					}

					var returnData = getData(data,url,type);
					console.log(returnData);
					if(returnData.status == 200){
						alert("创建群成功");
					}

				}else{
					alert("群名称长度不为0");
				}
			})
		},
		teamLi:function(urlHead){
			var type = null;
			var url = urlHead + "/group/all";
			var teamLi = getData();/*返回的数据不懂*/

		},
		teamDetail: function(gid,urlHead){
			var type = "get";
			var url = urlHead + "/detail?gid=" + gid; 

			var data = {
				"gid" :gid
			}
			var teamDetail = getData(data,url,type);
		},
		allmate :function(gid,urlHead){
			var url = urlHead + "/group/members?gid="+gid;
			var data = {
				"gid" :gid
			}
		},
		sortWeekly:function(){

		},
		subCom: function(token,urlHead){
			var type = "post";
			var url = urlHead + "/weekly/agree";
			var ZAN = $(".ZAN");
			var ZANLen = ZAN.length;
			
			var comment = $(".comment");
			var comLen = comment.length;
			
			for(var i = 0;i<ZANLen;i++){
				
				(function(i){
					var ZANflag = 0;
					var comFlag = 0;
					$(".ZAN").eq(i).click(function(){
						
						var num = $(".ZANnum").eq(i).text()
						var wid= $(".weeklyFooter").eq(i).attr("myattr");
						var data = {
							"token": token,
							"wid": wid
						}
						if(ZANflag == 0){
							num ++ ;
							$(this).children("img").attr("src","iconfont/zan_2.png");
							$(".ZANnum").eq(i).html(num);
							ZANflag = 1;
							var ZANData = getData(data,url,type);
							console.log(ZANData);
						}else if(ZANflag == 1){
							num -- ;
							$(this).children("img").attr("src","iconfont/zan_1.png");
							$(".ZANnum").eq(i).html(num);
							ZANflag = 0;
							var ZANData = getData(data,url,type);
							console.log(ZANData);
						}
						
					});
				})(i);
			}

			for(var i = 0;i<comLen;i++){
				(function(){
					$(".comment").eq(i).click(function(){
						var w_id =  $(this).attr("w_id");
						console.log(w_id);

						$(".subCom").click(function(){
							var comCon = $(".myComCon").val();
							var url = urlHead + "/weekly/comment";
							var type = "POST";
							console.log(comCon);
							if(comCon.replace(/\s/g,"") != null){
								var data = {
									"token":token,
									"content":comCon,
									"w_id":w_id
								}

								var returnData = getData(data,url,type);
								console.log(returnData);
								if(returnData.status == 200){
									alert("评论成功");
									location.reload();
								}

							}else{
								alert("评论内容不为空")
							}

						})

					})
				})(i)
			}

		}
	}


	var getData = function (data,url,type) {
		var returnData;

		$.ajax({
			type:type,
			dataType:"JSON",
			url:url,
			data:data,
			async:false,
			success: function(data){
				
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


	var type = "unread";
	var id = 1;
	console.log(token);
	


	function init(type,token,urlHead){
		postData.newInform(type,token,urlHead);
		postData.informDetail(token,id,urlHead);
		postData.perDetail(uid,urlHead);
		postData.changePass(token,urlHead);
		postData.allWeekly(urlHead);
		postData.subCom(token,urlHead);
		postData.weeklyView(uid,urlHead);
		postData.newTeam(token,urlHead);
		postData.markread(urlHead);
		postData.searchTeam(urlHead);
		
	}

	init(type,token,urlHead);

	
	function postWeekly(){

		var titLen = $(".title").length;
		var now =0;
		for(var i =0;i<titLen;i++){
			(function(i){
				$(".title").eq(i).click(function(){
					console.log(i);
					$(".title").eq(now).removeClass("tit_weekly");
					$(".title").eq(i).addClass("tit_weekly");
					now = i;
				})
			})(i);
		}

		$(".simditor-placeholder").click(function(){
			$(this).css("display","none");
			console.log("dhue");
		})
		$("#contentText").blur(function(){
			var content = $("#contentText").text();
			if(content.replace(/\s/g,"") == ""){
				$("#contentText").html("点击此处，开始周报吧！");
				
			}	

		})

		$(".subWeekly").click(function(){

			var title = $(".tit_weekly").text();


			var content = $("#editor").val();

			if(content.replace(/\s/g,"") != null){
				console.log(content);
				postData.WriWeekly(token,title,content,urlHead);
			}
			
		})
	}
	postWeekly();

	function deleteTab(data){
		console.log(data);
		var weeklyLen = $(".weekly").length;
		console.log(weeklyLen);
		for(var i=0;i<weeklyLen;i++){
			for (var content in data.data[i]){
				$(".weekly").eq(i).html(data.data[i].content)
				console.log(data.data[i].content);
				break;
			}	
		}

	}




})