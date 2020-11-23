<?php

require_once "db.php";

if(isset($_REQUEST['btn_register'])) //nom de button: "btn_register"
{
	$username	= strip_tags($_REQUEST['txt_username']);	//nom de textbox : "txt_email"
	$email		= strip_tags($_REQUEST['txt_email']);		//nom de textbox : "txt_email"
	$password	= strip_tags($_REQUEST['txt_password']);	//nom de textbox : "txt_password"
		
	if(empty($username)){
		$errorMsg[]="Please enter username";	//vérifier la zone de texte du nom d'utilisateur est vide ou pas 
	}
	else if(empty($email)){
		$errorMsg[]="Please enter email";	//vérifier la zone de texte du email d'utilisateur est vide ou pas 
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorMsg[]="Please enter a valid email address";	//vérifier le bon format pour email
	}
	else if(empty($password)){
		$errorMsg[]="Please enter password";	//vérifier la zone de texte du mdp d'utilisateur est vide ou pas 
	}
	else if(strlen($password) < 6){
		$errorMsg[] = "Password must be atleast 6 characters";	//doit comporter 6 caractères
	}
	else
	{	
		try
		{	
			$select_stmt=$db->prepare("SELECT username, email FROM users
										WHERE username=:uname OR email=:uemail"); // choisir sql query
			
			$select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email)); //executer query 
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	
			
			if($row["username"]==$username){
				$errorMsg[]="Désolé, le nom d'utilisateur existe déjà";	//La vérification du nom d'utilisateur, existe déjà ou pas 
			}
			else if($row["email"]==$email){
				$errorMsg[]="Désolé, l'e-mail existe déjà";	// La vérification de l'e-mail, existe déjà ou pas
			}
			else if(!isset($errorMsg)) //check no "$errorMsg" show then continue
			{
				$new_password = password_hash($password, PASSWORD_DEFAULT); //crypter le mot de passe en utilisant password_hash()
				
				$insert_stmt=$db->prepare("INSERT INTO users (username,email,password) VALUES
																(:uname,:uemail,:upassword)"); 		//insérer db					
				
				if($insert_stmt->execute(array(	':uname'	=>$username, 
												':uemail'	=>$email, 
												':upassword'=>$new_password))){
													
					$registerMsg="Register Successfully!";
					header("Location:chatroom.php");
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
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
						<strong>WRONG ! <?php echo $error; ?></strong>
					</div>
				<?php
				}
			}
			if(isset($registerMsg))
			{
			?>
				<div class="alert alert-success">
					<strong><?php echo $registerMsg; ?></strong>
				</div>
			<?php
			}
			?>   
				<h1 style="margin:50px;font-weight:700;"><center>S'INSCRIRE</center></h1>
				<form method="post" class="form-horizontal">
					<div style="display:block; margin: 0 auto; max-width: 768px;">
					
					<div class="form-group">
					<label class="col-sm-12 control-label">Nom d'utilisateur</label>
					<div class="col-sm-12">
					<input type="text" name="txt_username" class="form-control" placeholder="Votre nom" />
					</div>
					</div>
					
					<div class="form-group">
					<label class="col-sm-12 control-label">Email</label>
					<div class="col-sm-12">
					<input type="text" name="txt_email" class="form-control" placeholder="Votre email" />
					</div>
					</div>
						
					<div class="form-group">
					<label class="col-sm-12 control-label">Mot de passe</label>
					<div class="col-sm-12">
					<input type="password" name="txt_password" class="form-control" placeholder="Votre mot de passe" />
					</div>
					</div>
						
					<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9 m-t-15">
					<input type="submit"  name="btn_register" class="btn btn-primary " value="Register">
					</div>
					</div>
					
					<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9 m-t-15">
						You have a account register here? <a href="index.php">Compte de connexion</a>		
					</div>
					</div>
					</div>
						
				</form>
			
			</div>
		
		</div>
			
	</div>
										
	</body>
</html>