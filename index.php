<?php

require_once 'db.php';

session_start();

if(isset($_SESSION["user_login"])){	//vérifier la condition que la connexion de l'utilisateur, si oui, on va retourner à la page chatroom.php
	header("location: chatroom.php");
}

if(isset($_REQUEST['btn_login']))	
{
	$username	=strip_tags($_REQUEST["txt_username_email"]);	
	$email		=strip_tags($_REQUEST["txt_username_email"]);	
	$password	=strip_tags($_REQUEST["txt_password"]);			
		
	if(empty($username)){						
		$errorMsg[]="Please enter username or email";	
	}
	else if(empty($email)){
		$errorMsg[]="Please enter username or email";	
	}
	else if(empty($password)){
		$errorMsg[]="Please enter password";	
	}
	else
	{
		try
		{
			$select_stmt=$db->prepare("SELECT * FROM users WHERE username=:uname OR email=:uemail"); //"select" sql query
			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email));	//executer query avec "bind" paramètre
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			
			if($select_stmt->rowCount() > 0)	//si le nombre de lignes est supérieur à 0
			{
				if($username==$row["username"] OR $email==$row["email"]) //si nom ou email d'utisalteur sont pareils dans bdd
				{
					if(password_verify($password, $row["password"])) 
					{
						$_SESSION["user_login"] = $row["id"];	//nom de la session est mtn : "user_login"
						$loginMsg = "Successfully Login...Please wait in sec!";	
						header("refresh:2; chatroom.php");			//actualiser 2 secondes après la redirection vers la page "chatroom.php"
					}
					else
					{
						$errorMsg[]="wrong password";
					}
				}
				else
				{
					$errorMsg[]="wrong username or email";
				}
			}
			else
			{
				$errorMsg[]="wrong username or email";
			}
		}
		catch(PDOException $e)
		{
			$e->getMessage();
		}		
	}
}
?>

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
		
			<?php
			if(isset($errorMsg))
			{
				foreach($errorMsg as $error)
				{
				?>
					<div class="alert alert-danger">
						<strong><?php echo $error; ?></strong>
					</div>
				<?php
				}
			}
			if(isset($loginMsg))
			{
			?>
				<div class="alert alert-success">
					<strong><?php echo $loginMsg; ?></strong>
				</div>
			<?php
			}
			?>   
			<h1 style="margin:50px;font-weight:700;"><center>S'IDENTIFIER</center></h1>
			<form method="post" class="form-horizontal">
				<div style="display:block; margin: 0 auto; max-width: 768px;">
				<div class="form-group">
				<label class="col-sm-12 control-label">Nom ou Email</label>
				<div class="col-sm-12">
				<input type="text" name="txt_username_email" class="form-control" placeholder="Votre nom ou email" />
				</div>
				</div>
					
				<div class="form-group">
				<label class="col-sm-12 control-label">Password</label>
				<div class="col-sm-12">
				<input type="password" name="txt_password" class="form-control" placeholder="Votre mot de passe" />
				</div>
				</div>
				
				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				<input type="submit" name="btn_login" class="btn btn-success" value="Login">
				</div>
				</div>
				
				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				You don't have a account register here? <a href="register.php">Créer un compte</a>		
				</div>
				</div>
				</div>
					
			</form>
			
			</div>
		
		</div>
			
	</div>
										
	</body>
</html>