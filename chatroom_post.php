<?php 

require "db.php";

session_start();

if(!isset($_SESSION["user_login"]))	//check condition user login not direct back to index.php page
{
    header("location: index.php");
}
else{
    $id = $_SESSION['user_login'];
					
	$select_stmt = $db->prepare("SELECT * FROM users WHERE id=:uid");
	$select_stmt->execute(array(":uid"=>$id));
		
    $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

    try {
    $my_date = date("d-m-Y H:i:s");
    $req = $db->prepare("INSERT INTO chat (userid,username,mess,time) VALUES(:nid,:n,:m,:t)");
    $req->execute(array(":nid"  => $id,
                        ":n"    => $row['username'],
                        ":m"    => $_POST['usermsg'],
                        ":t"    => $my_date));
    
    header('Location: chatroom.php');
    } catch(PDOException $e) {
        echo "E: " . "<br>" . $e->getMessage();
    }

    // try {
    //     // $my_date = date("d-m-Y H:i:s");
    //     $req = $db->prepare("INSERT INTO chat (nomid, nom, mess) VALUES(:nid, :n, :m)");

    //     $req->bindParam(':nid', $nomid);
    //     $req->bindParam(':n', $nom);
    //     $req->bindParam(':m', $mess);

    //     $nomid=$id;
    //     $nom=$row['username'];
    //     $mess=$_POST['usermsg'];

    //     $req->execute();

    //     // Redirection du visiteur vers la page du tchat
    //     header('Location: welcome.php');
    // } catch(PDOException $e) {
    //     echo "E: " . "<br>" . $e->getMessage();
    // }
}
?>

