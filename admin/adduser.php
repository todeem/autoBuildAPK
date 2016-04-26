<?php
include("./header.php");
$arr=$classuser_m->user_shell($_SESSION[uid], $_SESSION[user_shell],3,$_SESSION[times],$_SESSION[mail]);
$query=mysql_query("select * from user_admin");
$permission=mysql_query("select * from permission ORDER BY `id` ASC "); 

?>
 <style type="text/css">
 <!--
.hr0{ height:1px;border:none;border-top:1px dashed #ccc;}

</style>


<script>
$(document).ready(function(){
	    $(":submit").click(function(){
	    var list= $('input:radio[name="permission"]:checked').val();
	    if(list==null){
            alert("请选择权限!");
            return false;
        }
    	var name=$("#addname").attr("value");
    	if(name==""){
    		alert("所需添加用户名不能为空!");
			return false;
    	}
    	var mail=$("#addmail").attr("value");
    	if(mail==""){
    		alert("所需添加用户邮箱不能为空!");
			return false;
    	}
	    });
	    $("#addname").change(function(){
			var __addname= $(this).attr("value"),
			__prompt=$("#prompt");
			
			$.post("postmysql.php", 
					{ 
				add:"adduser",
				user:__addname
					},
					function (data){
						__prompt.html(data);  
					}
			);
			
		    });
		$("#addmail").change(function(){
			var __addmail= $(this).attr("value"),
			__prompt=$("#prompt");
			$.post("postmysql.php", 
					{ 
				add:"addmail",
				mail:__addmail
					},
					function (data){
						__prompt.html(data);  
					}
			);
		    });
});
</script>

<div class="divline">

<div id="left">



</div>
<div class="hide" id="envhide">添加用户<img class="imghide" id="a" src="../image/hide.gif" align="right" alt="显示隐藏"><br></div> 
<div class="left" id="colation" name="colation" >
<table align="center" id="myTable" class="tablesorter" style="font-size:14px;width:100%;">
<thead>
	<tr >
		<th style=\"text-align: center;\" scope=\"col\">ID</th>
		<th style=\"text-align: center;\" scope=\"col\">用户名</th>
		<th style=\"text-align: center;\" scope=\"col\">邮箱</th>
		<th style=\"text-align: center;\" scope=\"col\">权限</th>
		<th style=\"text-align: center;\" scope=\"col\">权限描述</th>
	</tr>
</thead>
<tbody>
<?php 
while ($row=mysql_fetch_array($query)){
	$Psql=mysql_query("select * from permission where value='$row[ugid]'");
	$Prow=mysql_fetch_array($Psql);
	echo "<tr id=\"a\"><td  style=\"text-align: center;\"> $row[uid]</td>
	<td style=\"text-align: center;\">$row[username]</td>
	<td style=\"text-align: center;\">$row[email]</td>
	<td style=\"text-align: center;\">$Prow[name]</td>
	<td style=\"text-align: center;\">$Prow[comment]</td>
	</tr>";
}

?>
</tbody>
		<tr>
		<th colspan="9" style="font-weight:normal"></th>
	</tr>
</table>
</div>
<br/>
<div class="upleft" id="adduser" >
<form action="success.php" method="post" name="form">
用户名：<input type="text" class="ver" name="addname" id="addname"  placeholder="请输入需增加的用户名称" onchange="if (this.value.search(/^[a-zA-Z0-9\.]*$/g)== -1){alert('抱歉，只能含有 a-zA-Z0-9_.'); this.value = ''; this.focus(); }">
邮箱：<input type="text" class="ver" name="addmail" id="addmail"  placeholder="请输入该用户邮箱地址"  onchange="if (this.value.search(/^[a-zA-Z0-9-_\.]+@([a-z0-9]+\.)+[a-z]{1,5}$/g)== -1){alert('抱歉，请输入正确的邮件地址'); this.focus(); }">
<br /><span style="border: 0px solid #ccc;" id="prompt"></span><hr class="hr0" />权限：
<?php 
while ($permissionRow=mysql_fetch_array($permission)){
	echo "<input type=\"radio\" name=\"permission\" id=\"$permissionRow[value]\" value=\"$permissionRow[value]\" title=\"$permissionRow[comment]\">[ <a href=\"javascript:void(0);\" title=\"$permissionRow[comment]\"><u>$permissionRow[name]</u></a> ] ";
}
?>
<hr class="hr0" />
<input type="submit" value="添加">
</form>
</div>
<div style="clear:both;"></div>
</div>


<?php 

	
include('../foot.php');


?>