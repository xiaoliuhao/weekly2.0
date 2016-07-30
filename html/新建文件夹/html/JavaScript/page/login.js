(function() {

    var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

    // Main
    initHeader();
    initAnimation();
    addListeners();

    function initHeader() {
        width = $(window).width();
        height = $(window).height();
        target = {x: width/2, y: height/2};

        largeHeader = document.getElementById('large-header');
        largeHeader.style.height = height+'px';

        canvas = document.getElementById('demo-canvas');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        // create points
        points = [];
        for(var x = 0; x < width; x = x + width/20) {
            for(var y = 0; y < height; y = y + height/20) {
                var px = x + Math.random()*width/20;
                var py = y + Math.random()*height/20;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
            points[i].circle = c;
        }
    }

    // Event handling
    function addListeners() {
        if(!('ontouchstart' in window)) {
            window.addEventListener('mousemove', mouseMove);
        }
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function mouseMove(e) {
        var posx = posy = 0;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        target.x = posx;
        target.y = posy;
    }

    function scrollCheck() {
        if(document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
    }

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height+'px';
        canvas.width = width;
        canvas.height = height;
    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.6;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.draw();
            }
        }
        requestAnimationFrame(animate);
    }

    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba(156,217,249,'+ p.active+')';
            ctx.stroke();
        }
    }

    function Circle(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(156,217,249,'+ _this.active+')';
            ctx.fill();
        };
    }

    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }

    function tabTurn(){
        $(".in").click(function(){
            console.log("hello");
            $(".signUp").css("display","none");
            $(".signIn").css("display","block");
           
        });
        $(".up").click(function(){
            console.log("hello");
            $(".signIn").css("display","none");
            $(".signUp").css("display","block");
        })
    }

    tabTurn();
    var data = {
        getInData : function(){

            var $userInput = $(".username");
            var $pass = $(".password");
            $userInput.blur(function(){
                var userLen = $userInput.val().length;

                console.log(userLen);
                if(userLen>0 && userLen<6){
                    $(".tipIn").html("账号长度不小于6位")
                                .css("display","block");
                    $pass.attr("disabled","true");
                    $("#login-button").attr("disabled",true);
                }else{
                    $(".tipIn").css("display","none");
                    $pass.attr("disabled",false);
                    $("#login-button").attr("disabled",false);
                }
            });

            var url = "http://115.159.54.210/weekly/index.php/login/check_login";
            
            $("#login-button").click(function(){
                event.preventDefault();
                var uid = $userInput.val();
                var password = hex_sha1(hex_md5($(".password").val()));
                console.log(password);
                var data = {
                    uid : uid,
                    password : password
                };
                sign.signUp(data,url);
            })
        },
        getUpData : function(){

            var $newUser = $(".newUsername");
            var $pass1 = $(".newPassword_1");
            var $pass2 = $(".newPassword_2");

            $newUser.blur(function(){
                var newLen = $newUser.val().length;
                if(newLen > 0 && newLen < 6){
                    $(".tipUp").html("用户名长度不小于6")
                                .css("display","block");
                    $(".newPass").attr("disabled",true);
                    $("#new-login").attr("disabled",true);          
                }else{
                    $(".tipUp").css("display","none");
                    $(".newPass").attr("disabled",false);
                    $("#new-login").attr("disabled",false);  
                }
            });
            $pass1.blur(function(){
                var passLen = $pass1.val().length;
                if(passLen >0 && passLen < 6){
                    $(".tipUp").html("密码长度不小于6")
                                .css("display","block");
                    $pass2.attr("disabled",true);
                }else{
                    $(".tipUp").css("display","none");
                    $pass2.attr("disabled",false);
                }
            });

            $("#new-login").click(function(){
                event.preventDefault();
                var pass_1 = hex_sha1(hex_md5($(".newPassword_1").val()));
                var pass_2 = hex_sha1(hex_md5($(".newPassword_2").val()));
                var url = "http://115.159.54.210/weekly/index.php/login/register";
                var uid = $(".newUsername").val();
                var data = {
                    uid : uid,
                    password : pass_1,
                    password2 : pass_2
                }
                if(pass_1 == pass_2){
                    if(uid.length!=0 && $(".newPassword_1").val().length != 0)
                    {
                        sign.signUp(data,url);
                        console.log(data);
                    }
                }
                else{
                    $(".tipUp").html("两次密码不一致")
                                .css("display","block");
                }
            });

        },
        getPhoto : function(){
            
            var url = "http://115.159.54.210/weekly/index.php/login/get_photo";
            
            console.log(data);
            $(".username").blur(function(){
                var uid = $(".username").val();
                var data = {
                    uid : uid
                };
                if( $.trim(uid).length != 0){
                    sign.signUp(data,url);
                }
                console.log(data);
            })
        }
    }
    data.getInData();
    data.getUpData();
    data.getPhoto();
    var sign = {
        signUp:function(data,url){
            $.ajax({
                type: "POST",
                data: data,
                url: url,
                dataType:"JSON",
                async:false,
                success: function(data){
                    console.log(data);
                    if(data.data.flag == "获取头像" && data.data.photo != null){
                        $(".headPic").attr("src",data.data.photo);
                    }else if(data.data.flag == "登录"){
                        if(data.status == 203){
                            $(".tipIn").html(data.message)
                                        .css("display","block");


                        }else if(data.status == 200){
                            $(".form").fadeOut(500);
                            $(".tab").fadeOut(500);
                            $(".sign").addClass("form-success");
                            //document.cookie = "name=" + escape(data.data.name)+";"+"photo="+escape(data.data.photo)+";"+"uid="+escape(data.data.uid)+";"+"token="+escape(data.data.token)+";"+"path=/";
                            //document.cookie="userId=828;path=/";
                            // document.cookie="username=hunk;path=/";
                            // console.log(document.cookie);   
                            sessionStorage.setItem("token",data.data.token);
                            sessionStorage.setItem("uid",data.data.uid);
                            sessionStorage.setItem("photo",data.data.photo);
                            sessionStorage.setItem("name",data.data.name);
                            var token = sessionStorage.getItem("token");
                            console.log(token);
                            var new_element=document.createElement("script");
                            new_element.setAttribute("type","text/javascript");
                            new_element.setAttribute("src","../JavaScript/page/setting.js");
                            document.body.appendChild(new_element);
                            setTimeout(function(){
                                 location.href="../html/angular-stripped.html"
                             },1000);
                        }
                            
                    }else if(data.data.flag == "注册"){
                        if(data.status == 203){
                            $(".tipUp").html(data.message)
                                .css("display","block");
                        }else if(data.status == 202){
                            $(".tipUp").html(data.message)
                                .css("display","block");
                        }else if(data.status == 200){
                            $(".tipUp").html("注册成功")
                                .css("display","block");
                                setTimeout(window.reload(),1000);
                        }
                    }

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
    }

    
    var verCenter = {

        lineHeight : function(){
            var height = $(".lead").height();
            console.log(height);
            $(".lead").children("span").css("line-height",height+"px");
        }

    }
    verCenter.lineHeight();

    function getToken(){
        return token;
    }

    
})();