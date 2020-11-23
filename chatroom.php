<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Chatroom</title>
		
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="js/main.js"></script>

</head>
	<body>
	<nav class="navbar navbar-dark bg-dark justify-content-between">
		<a style="color:#fff;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-orient: horizontal;-webkit-box-direction: normal;-ms-flex-flow: row wrap;flex-flow: row wrap;-webkit-box-align: center;-ms-flex-align: center;align-items: center;" class="navbar-brand">CHATROOM 0.1</a>
		<form class="form-inline">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>
	</nav>
	
	<div class="wrapper">
		<div class="container">
			<div class="col-lg-12">
			<div id="chatbox" style="border-radius:5px;border:1px solid black; margin-top:20px; padding: 20px;">
				<?php

					require_once 'db.php';
					
					session_start();

					if(!isset($_SESSION['user_login']))	
					{
						header("location: index.php");
					}
					
					$id = $_SESSION['user_login'];
					
					$select_stmt = $db->prepare("SELECT * FROM users WHERE id=:uid");
					$select_stmt->execute(array(":uid"=>$id));
		
					$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
					
					if(isset($_SESSION['user_login']))
					{echo "<span style="."margin:5px;"."><b>Welcome</b>,".$row['username']."</span>";}
				?><a style="display:block; float:right;" href="logout.php">Logout</a>

				<div id ="chattext" style="display: flex;flex-direction: column-reverse; max-height:500px; overflow:auto; top:50px;border:1px solid black; margin-top:20px; padding: 20px;">
				</div>
			
				<div id="action" style="margin-top:20px;">
					<form style="width:auto;" action="chatroom_post.php" method="post">
						<input style="border:1px solid #000" class="form-control form-control-lg" name="usermsg" type="text" id="usermsg" />
						<input style="color: #fff;background-color: green;margin-top:10px;"class="form-control" name="submitmsg" type="submit"  id="submitmsg" value="Envoyer" />
					</form>
				</div>
			</div>		
		</div>
	</div>	
</div>

</body>
</html>