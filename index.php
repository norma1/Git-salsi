<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<title>Login</title>
	<script>
		$(document).ready(function()
		{
			$("#entrar").click(function()
			{
				var user= $("#user").val();
				var	pass= $("#password").val();
				$.post("core/Login/controller_login.php",{action:'get_user',user:user,password:pass}, 
				function(res)
				{
					//alert(user+" "+pass);
					$("#user_req").html(res);
				});
				
			});
		});

	

	</script>
</head>
<body>
		<form id="login" style="text-align:center">
			<div class="form-group" >
				<div>
			      <img src="img/logo.png" id="logo"></img>
			  	</div>
					<span class="glyphicon glyphicon-user" style="font-size: 2em; color: gray"></span>
			    	<input type="text" class="form-control" id="user" placeholder="Usuario" style="text-align:center">
			  	<div class="form-group">
			    	<label class="sr-only" for="pass">Contraseña</label>
			    	<input type="password" class="form-control" id="password" placeholder="Contraseña" style="text-align:center">
			  	</div>		
			  		<a id="entrar" class="btn btn-success" href="#!" style="width:100px; float: right;">Entrar</a>
			</div> 
		</form>
		<div id="user_req"></div>
</body>
</html>
