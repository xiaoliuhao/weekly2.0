$(function(){
	var token = sessionStorage.getItem("token");
	var uid = sessionStorage.getItem("uid");
	var name = sessionStorage.getItem("name");
	var photo = sessionStorage.getItem("photo");

	var location = window.location.href;
	var gid = location.split("gid=")[1];

	var urlHead = "http://115.159.54.210/weekly/index.php";

	var postData = {
		allmate :function(gid,urlHead){
			var url = urlHead + "/group/members?gid="+gid;
			var type = "get";
			getData(url,type);
		}
	}

	var getData = function (url,type) {
		$.ajax({
			type:type,
			dataType:"JSON",
			url:url,
			//data:data,
			asyn:false,
			success: function(data){
				console.log(data);
				var mateTemplate = Handlebars.compile($("#mate-template").html());
				$("#mateLi").append(mateTemplate(data.data))
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

	postData.allmate(gid,urlHead);


})