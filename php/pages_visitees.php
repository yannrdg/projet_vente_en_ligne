<?php
session_start();
if($_SESSION['login'] == 'admin')
{
    include 'config.php';
    $bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/global.css">
        <title>Pages visitées</title>
    </head>
    <body>
    <?php
        include '../includes/header.php';
    ?> 
    <main>
        <table>
            <tr>
                <th>Login visiteur</th>
                <th>Nbr visites index.php</th>
                <th>Nbr visites homme.php</th>
                <th>Nbr visites femme.php</th>
                <th>Nbr visites ballon.php</th>
            </tr>
        <?php
        //------------- Récupération des logins de la page visiter ------------
        $recupVisiteurs = $bdd->prepare("SELECT DISTINCT login FROM visiter");
        $recupVisiteurs->execute();
        $visiteurs = $recupVisiteurs->fetchAll();
        
        foreach($visiteurs as $loginVisiteur):
        ?>
            <tr>
                <td>
                <?php echo $login = $loginVisiteur['login']; ?>
                </td>
                <td>
                <?php
                    //------------- Récupération, dans la table visiter, des informations sur la page index.php (idpage = 0) ------------
                    $index = 0;
                    $recupIndex = $bdd->prepare("SELECT login, COUNT(idpage) AS 'index' FROM visiter WHERE idpage = :index AND login = :login GROUP BY login");
                    $recupIndex->bindParam(':index', $index);
                    $recupIndex->bindParam(':login', $login);
                    $recupIndex->execute();
                    $infosIndex = $recupIndex->fetchAll();
                    foreach($infosIndex as $nbrIndex):
                        echo $nbrIndex['index'];
                    endforeach;
                ?>
                </td>
                <td>
                <?php
                    //------------- Récupération, dans la table visiter, des informations sur la page homme.php (idpage = 1) ------------
                    $homme = 1;
                    $recupHomme = $bdd->prepare("SELECT login, COUNT(idpage) AS 'homme' FROM visiter WHERE idpage = :homme AND login = :login GROUP BY login");
                    $recupHomme->bindParam(':homme', $homme);
                    $recupHomme->bindParam(':login', $login);
                    $recupHomme->execute();
                    $infosHomme = $recupHomme->fetchAll();
                    foreach($infosHomme as $nbrHomme):
                        echo $nbrHomme['homme'];
                    endforeach;
                ?>
                </td>   
                <td>
                <?php
                    //------------- Récupération, dans la table visiter, des informations sur la page femme.php (idpage = 2) ------------
                    $femme = 2;
                    $recupFemme = $bdd->prepare("SELECT login, COUNT(idpage) AS 'femme' FROM visiter WHERE idpage = :femme AND login = :login GROUP BY login");
                    $recupFemme->bindParam(':femme', $femme);
                    $recupFemme->bindParam(':login', $login);
                    $recupFemme->execute();
                    $infosFemme = $recupFemme->fetchAll();
                    foreach($infosFemme as $nbrFemme):
                        echo $nbrFemme['femme'];
                    endforeach;
                ?>
                </td>
                <td>
                <?php
                    //------------- Récupération, dans la table visiter, des informations sur la page ballon.php (idpage = 3) ------------
                    $ballon = 3;
                    $recupBallon = $bdd->prepare("SELECT login, COUNT(idpage) AS 'ballon' FROM visiter WHERE idpage = :ballon AND login = :login GROUP BY login");
                    $recupBallon->bindParam(':ballon', $ballon);
                    $recupBallon->bindParam(':login', $login);
                    $recupBallon->execute();
                    $infosBallon = $recupBallon->fetchAll();
                    foreach($infosBallon as $nbrBallon):
                        echo $nbrBallon['ballon'];
                    endforeach;
                ?>
                </td>           
            </tr>
        <?php
        endforeach;
        ?>
        </table>
    
    </main>
    <?php
        include '../includes/footer.php';
    ?> 
    </body>
    </html>
<?php
}
else
{
    header('Location: index.php');
}