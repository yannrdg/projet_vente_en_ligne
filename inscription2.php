<?php
    
    $login = $_POST["login"];
    $mdp = $_POST["mdp"];
    $mail = $_POST["mail"];
    $nom = $_POST["nom"];
    $numero = $_POST["numero"];
    $rue = $_POST["rue"];
    $cp = $_POST["cp"];
    $ville = $_POST["ville"];
    $cb = $_POST["cb"];
    
    try{
        //On se connecte à la BDD
        $dbco = new PDO("mysql:host=localhost;dbname=projet", 'root', 'root');
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        //On insère les données reçues
        $sth = $dbco->prepare("
            INSERT INTO VISITEUR(login, mdp, mail, nom, numero, rue, cp, ville, cb)
            VALUES(:login, :mdp, :mail, :nom, :numero, :rue, :cp, :ville, :cb)");
        $sth->bindParam(':login',$login);
        $sth->bindParam(':mdp',$mdp);
        $sth->bindParam(':mail',$mail);
        $sth->bindParam(':nom',$nom);
        $sth->bindParam(':numero',$numero);
        $sth->bindParam(':rue',$rue);
        $sth->bindParam(':cp',$cp);
        $sth->bindParam(':ville',$ville);
        $sth->bindParam(':cb',$cb);
        $sth->execute();
        
        //On renvoie l'utilisateur vers la page de remerciement
       header("Location:inscription.php");
    }
    catch(PDOException $e){
        echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
    }
?>