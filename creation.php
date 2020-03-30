<?php
    try{
        //On se connecte à la BDD
        $dbco = new PDO("mysql:host=localhost;dbname=test",'root', 'root');
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        //On crée une table form
        $form = "CREATE TABLE form(
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            prenom TEXT,
            mail TEXT,
            age INT,
            sexe TEXT,
            pays TEXT)";
        $dbco->exec($form);
    }
    catch(PDOException $e){
        echo 'Erreur : '.$e->getMessage();
    }
?>