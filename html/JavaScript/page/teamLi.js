$(function(){
	var token = sessionStorage.getItem("token");
	var uid = sessionStorage.getItem("uid");
	var name = sessionStorage.getItem("name");
	var photo = sessionStorage.getItem("photo");
	var urlHead = "http://115.159.54.210/weekly/index.php";

	var postData = {
		teamLi:function(urlHead){
			var url = urlHead + "/group/all";
			var teamLi = getData(url);/*返回的数据不懂*/
			console.log(teamLi);
		}
	}

	var getData = function (url) {
		$.ajax({
			//type:type,
			dataType:"JSON",
			url:url,
			//data:data,
			asyn:false,
			success: function(data){
				console.log(data);
				var teamTemplate = Handlebars.compile($("#teamLi-template").html());
				$("#teamLiTemplate").append(teamTemplate(data.data));
				
			},
			error: function(jqXHR,textStatus,errorThrown){
				 console.log(jqXHR.status);
                 console.log(jqXHR.readyState);
                 console.log(jqXHR.statusText);
                 console.log(textStatus);
                 console.log(errorThrown);
			}
		})
	}

	postData.teamLi(urlHead)

})