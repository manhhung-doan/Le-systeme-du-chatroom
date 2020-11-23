<?php

require_once 'db.php';
try
{
    if(isset($_POST['display'])){
    $reponse = $db->query('SELECT * FROM chat ORDER BY ID DESC LIMIT 0, 1000');

    while ($donnees = $reponse->fetch())
    {
        echo '<p>[' . htmlspecialchars($donnees['time']) . '] <strong>' . htmlspecialchars($donnees['username']) . '</strong> : ' . htmlspecialchars($donnees['mess']) . '</p>';
    }

    $reponse->closeCursor();}
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
?>