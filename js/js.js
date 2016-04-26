$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 

); 

// 下拉框联动
//
$(document).ready(function(){
	
	//
	
	$('#client_platform').change(function(){
		$.post("gain.php", { 
			clientid:$("#client_platform").val()
		},
		function (data, textStatus){
			$("#version_id").html(data); 
		}
		);
	});


	//

	$('#version_id').change(function(){
		$.post("gain.php", { 
			cpid:$("#client_platform").val(),
			platverid:$("#version_id").val()
		},
		function (data, textStatus){
			$("#platform_id").html(data); 
		}
		);
	});
	$('img[alt=高级模式]').toggle(function(){$("#high_td").show("slow");},function(){$("#high_td").hide("slow");});

});



$(document).ready(function(){
    $('#platform_id').change(function(){
			$.post("gain.php", { 
				funplatid:$("#platform_id").val(),
				funverid:$("#version_id").val() 
				},
				function (data, textStatus){
                        $("#function_id").html(data); 
                        $("#package-xianshi").html("请继续选择功能"); 
					}
			);
	   })
})
//$(document).ready(function(){
//	$('#version_id').change(function(){
//		alert();
//		$.ajax({
//			type:"POST",
//			url:"gain.php",
//			data:{platverid:$("#version_id").val()},
//			success:function(data,st){
//				$("#platform_id").html(data);
//				 
//			}
//		});
//	})

$(document).ready(function(){
    $('#function_id').change(function(){
			$.post("gain.php", { 
				valfunid:$("#function_id").val(),
				valplatid:$("#platform_id").val(),
				valverid:$("#version_id").val() 	},
				function (data, textStatus){
                        $("#package-xianshi").html(data); 
					}
			);
	   });
	$("tr.a").mouseover(function(){
		$(this).css("background","#CCC");		
	}).mouseout(function(){
		$(this).css("background","");

	});
});


function ch(){
		if(document.getElementById("android-sourceid").value==""){
			document.getElementById("tishi-android-sourceid").innerHTML = "<font color=red>*请按要求格式输入内容<br>列，格式如下：<br>vancl_android_001<br>vancl_android_003<br>vancl_android_00*<br>更多渠道号</font>";
			return false;
		}
		document.getElementById("tishi-android-sourceid").innerHTML = "<font color=green>请确认格式正确？并提交。</font>";
		return true;
	}

///////////////////////////////////////////////
//验证码
//function refurbish(){
//    var img = document.getElementByIdx("varImg");
//    img.src = "imgcode.php?" + Math.random();
//}
//-- end

	function checkpost(){
		if(loginform.username.value==""){
			alert("用户名不能为空!");
			loginform.username.focus();
			return false;
		}
		if(loginform.password.value==""){
			alert("密码不能为空!");
			loginform.password.focus();
			return false;
		}
		if(loginform.code.value==""){
			alert("请输入验证码...");
			loginform.code.focus();
			return false;
		}

	}
	function funSubmit(){
		if(document.getElementById("client_platform").value=="-1"){
			alert("请根据需要选择对应平台！");
			return false;	
		} 
		if(document.getElementById("version_id").value=="-1"){
			alert("请根据需要选择对应的版本号！");
			return false;	
		} 
		if(document.getElementById("platform_id").value=="-1"){
			alert("请根据需要选择对应环境！");
			return false;	
		}
		if(document.getElementById("function_id").value=="-1"){
			alert("请根据需要选择对应的特殊功能包？");
			return false;	
		}
		if(document.getElementById("orderA").value=="2" && document.getElementById("orderB").value=="2"  ){
			alert("请选择一种渠道提交模式:手动或自动");
			return false;
		}
		if(document.getElementById("orderA").value=="1"  ){
			if(document.getElementById("android-sourceid").value==""){
				alert("请输入渠道号！");
				return false;
			}

		}else if(document.getElementById("orderB").value=="0" ){
			if(document.getElementById("portion").value==""){
				alert("未输入有规则序列渠道部分?\r如：'vancl_android_'");
				return false;
			}
			if(document.getElementById("numberA").value==""){
				alert("未输入有序渠道开始部分\r如：从1~10?");
				return false;
			}
			if(document.getElementById("numberB").value==""){
				alert("未输入有序渠道结束部分\r如：从1~10??");
				return false;
			}
			if(document.getElementById("capacity").value=="" || document.getElementById("capacity").value=='0'){
				alert("未输入有序渠道部分长度 \r 如:输入3位，\r则最后会生成vancl_android_001~010，会在前面补0")
				return false;
			}
			var numberA=document.getElementById("numberA").value;
			var numberB=document.getElementById("numberB").value;
			if(numberA>=numberB){
				alert(" 1）如:只打一个渠道包，请选择无序;\r 2）从"+numberA+"打到"+numberB+"？你确认前面的数字比后面的小吗？");
				return false;
			}
			
		} 

		
//		if(document.getElementById("sourcecode").value==document.getElementById("hiddenid").value){
//			alert(aaaaaaaaaa);
//			return true;
//		}else{
//			alert("*验证码错误!");
//			alert(a);
//			return false;
//		}

	}
//	function funcchange(){
//		if(this.value.search(/[^\x00-\xff]/)){
//			alert("内容包含zhong");
//			return false;
//		}else{
//			return true;
//		}
//		
//	}
	function pinhe(){
		var f = document.getElementById("function_id").value;
		var p = document.getElementById("platform_id").value;
		var v = document.getElementById("version_id").value;
		var c=v+p+f;
		
	}
	function clickclear(msg){
		a = confirm(msg);
		if(a){
			 document.getElementById("android-sourceid").value="";
		}
			
//		androidsourceid.maillist.value="";
	return false;
	}
	
	function linkok(url,msg){
	    question = confirm(msg);
	    if (question){
	    window.location.href = url;
	    }
	}

	function maxlength3(node, maxcount) {
	    if (node.value.length > maxcount) {
	        node.value = node.value.substr(0, maxcount);
	    }
	}
	
	function souridshow()
	{ 
	document.getElementById("hidesourceid").style.display = "block";
	document.getElementById("showsourceid").style.display = "none";
	document.getElementById("orderA").value = "1";
	document.getElementById("orderB").value = "2";

	}
	function souridhide()
	{ 
	document.getElementById("hidesourceid").style.display = "none";
	document.getElementById("showsourceid").style.display = "block";
	document.getElementById("orderA").value = "2";
	document.getElementById("orderB").value = "0";
	}
//连接提示
	this.imagePreview = function(a){ 
		/* CONFIG */
		  
		   xOffset = 10;
		   yOffset = 30;
		   
		   // 可以自己设定偏移值
		  
		/* END CONFIG */
		$("a.preview").hover(function(e){
			var $alt = $(this).attr("alt");
		   $("body").append("<div id='preview'>"+$alt+"</div>");        
		   $("#preview")
		    .css("top",(e.pageY - xOffset) + "px")
		    .css("left",(e.pageX + yOffset) + "px")
		    .fadeIn("slow");      
		    },
		function(){
		   $("#preview").fadeOut("fast");
		    }); 
		$("a.preview").mouseout(function(){
			      $('#preview').remove();
			   }),
		$("a.preview").mousemove(function(e){
		   $("#preview")
		    .css("top",(e.pageY - xOffset) + "px")
		    .css("left",(e.pageX + yOffset) + "px");
		});   
		};
		// 页面加载完执行
		$(document).ready(function(){
		imagePreview();
		});
		
		$(document).ready(function(){
			$.ajaxSetup ({
			   	cache: false //关闭AJAX相应的缓存
			});
			$("img[class]").live("mouseover",function(){
				var id = $(this).attr("id");
				var datasum = $("#"+id).attr("data-sum");
				$.get( 'progress/'+id+'.progress',function(data,status){
					$("#bar"+id).attr("alt","Status:"+data+"/Total:"+datasum);
				});
			});
		});