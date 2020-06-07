<?php
session_start();
if($_SESSION['login'] == 'admin')
{
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);


// ----------- Affichage des produits -------------
$recup = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
$recup->execute();
$produit = $recup->fetchAll();

//------------- Affichage des visiteurs ------------

$recupVisiteur = $bdd->prepare("SELECT * FROM visiteur");
$recupVisiteur->execute();
$visiteurs = $recupVisiteur->fetchAll();

// ------------ Ajout d'un produit -------------
    $ref = $_POST['ref'];
    $nom = $_POST['nom'];
    $descriptif = $_POST['descriptif'];
    $type = $_POST['type'];
    $filename = $_FILES['file']['name'];
    $filetmpname = $_FILES['file']['tmp_name'];
    $folder = '../medias/';
    $extension = strtolower(substr(strrchr($filename,'.'),1));
    $newName = $ref.'.'.$extension;
    if(isset($_POST['ajout']))
    {
        if($fileError == 0)
        {
            if($extension == 'jpg')
            {
                move_uploaded_file($filetmpname, $folder.$newName);
                if(!empty($ref) && !empty($nom) && !empty($descriptif))
                {       
                    $reqref = $bdd->prepare("SELECT * FROM PRODUIT WHERE ref = ?");
                    $reqref->execute(array($ref));
                    $refexist = $reqref->rowCount();
                    if($refexist == 0)
                    {
                
                        $reflength = strlen($ref);
                        if($reflength === 5)
                        {
                            $req = $bdd->prepare("INSERT INTO PRODUIT (ref, nom, descriptif, type) VALUES ('$ref', '$nom', '$descriptif', '$type')");
                            $req->execute();
                            header('Refresh:0');
                        }
                        else
                        {
                            $erreur2 = "La référence de l'article doit faire 5 chiffres";
                        }
                    }
                    else
                    {
                        $erreur2 = "Cette référence existe déjà";
                    }
                }
                else
                {
                    $erreur2 = 'il manque des infos';
                }
            }
            else
            {
                $erreur2 = 'L\'image doit être au format jpeg';
            }
        }
        else
        {
            $erreur2 = "Une erreur est survenue";
        } 
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <link rel="stylesheet" href="../style/global.css">
    <script src="../script/admin.js" async></script>
    <link rel="stylesheet" href="../style/admin.css">
    <title>Page d'administration</title>
</head>
<body>
    <?php
    include '../includes/header.php'
    ?>
    <nav>
            <button id="ajoutProduit">Ajout produit</button>
            <button id="modificationProduit">Modification produit</button>
            <button id="gestionVisiteur">Gestion des visiteurs</button>
            <a href="pages_visitees.php"></a>
    </nav>
    <main>
        <h4>Afin de voir les modifications apparaitre, actualisez la page après les modifications apportées</h4>
        <section id="FormAjoutProduit">
            <h1>ajout</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="ref">Référence du produit</label>
                    <input type="number" id="ref" maxlength="5" name="ref"
                        value="<?php if(isset($ref)) {echo $ref;} ?>">
                </div>
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" maxlength="50" name="nom" value="<?php if(isset($nom)) {echo $nom;} ?>">
                </div>
                <div>
                    <label for="descriptif">Descriptif</label>
                    <textarea id="descriptif" name="descriptif" maxlength="255" row="6" cols="51"
                        value="<?php if(isset($descriptif)) {echo $descriptif;} ?>"></textarea>
                </div>
                <div>
                    <label for="type">Catégorie :</label>
                    <select name="type" id="type">
                        <option value="ballon">Ballon</option>
                        <option value="femme">Femme</option>
                        <option value="homme">Homme</option>
                    </select>
                </div>
                <div>
                    <label for="">File up</label>
                    <input type="file" name="file" value="déposez" required>
                </div>
                <input type="submit" name="ajout" value="ajouter un article">
            </form>
            <p>
                <?php
            if(isset($erreur2))
            {
                echo $erreur2;
            }
        ?>
            </p>
        </section>
        <section id="modifisProduits">
            <table>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Référence</th>
                    <th>Date de la denrière modification</th>
                    <th>Type</th>
                    <th>Modification</th>
                </tr>
                <?php foreach ($produit as $itemsProduit): ?>
                <tr>
                    <td id="nomProduit"><?= $itemsProduit['nom']?></td>
                    <td id="descrProduit"><?= $itemsProduit['descriptif']?></td>
                    <td id="refProduit"><?= $itemsProduit['ref']?></td>
                    <td id="dateProduit"><?= $itemsProduit['date']?></td>
                    <td id="typeProduit"><?= $itemsProduit['type']?></td>
                    <td>
                        <form action="" method="post">
                            <input type="submit" id="delete" name="supprimer<?= $itemsProduit['ref']?>"
                                value="Supprimer">
                            <?php
                           // ---------- Suppression des produits ----------
                            $refProduit = $itemsProduit['ref'];
                            if(isset($_POST['supprimer'.$itemsProduit['ref']]))
                            {
                                $supprimer = $bdd->prepare("DELETE FROM produit WHERE ref = :ref");
                                $supprimer->bindParam(':ref', $refProduit);
                                $supprimer->execute();
                                header("Refresh:0");
                            }
                            ?>
                        </form>
                        <a href="modificationProduit.php?ref=<?= $itemsProduit['ref']?>">Modifier</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
        <section id="visiteurs">
        <table>
                <tr>
                    <th>idp</th>
                    <th>Login</th>
                    <th>Mail</th>
                    <th>Nom</th>
                    <th>Numero</th>
                    <th>Rue</th>
                    <th>Code postal</th>
                    <th>Ville</th>
                    <th>N°carte bancaire</th>
                </tr>
                <?php foreach ($visiteurs as $infoVisiteur): ?>
                <tr>
                    <td><?= $infoVisiteur['idp']?></td>
                    <td><?= $infoVisiteur['login']?></td>
                    <td><?= $infoVisiteur['mail']?></td>
                    <td><?= $infoVisiteur['nom']?></td>
                    <td><?= $infoVisiteur['numero']?></td>
                    <td><?= $infoVisiteur['rue']?></td>
                    <td><?= $infoVisiteur['cp']?></td>
                    <td><?= $infoVisiteur['ville']?></td>
                    <td><?= $infoVisiteur['cb']?></td>
                    <td>
                        <form action="" method="post">
                            <input type="submit" id="deleteVisiteur" name="supprimerVisiteur<?= $infoVisiteur['idp']?>"
                                value="Supprimer">
                            <?php
                           // ---------- Suppression des produits ----------
                            $idp = $infoVisiteur['idp'];
                            if(isset($_POST['supprimerVisiteur'.$infoVisiteur['idp']]))
                            {
                                $supprimerVisiteur = $bdd->prepare("DELETE FROM visiteur WHERE idp = :idp");
                                $supprimerVisiteur->bindParam(':idp', $idp);
                                $supprimerVisiteur->execute();
                                $supprimerPanier = $bdd->prepare("DELETE FROM contenir WHERE idp = :idp");
                                $supprimerPanier->bindParam(':idp', $idp);
                                $supprimerPanier->execute();
                                $supprimerVisiter = $bdd->prepare("DELETE FROM visiter WHERE login = :login");
                                $supprimerVisiter->bindParam(':login', $login);
                                $supprimerVisiter->execute();
                                header('refresh:0');
                            }
                            ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
</body>
</html>
<?php
}
else
{
 header('Location: ../index.php');
}