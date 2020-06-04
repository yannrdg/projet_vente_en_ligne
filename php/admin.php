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
                            header('Location: ../index.php');
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
    <header>
        <nav>
            <button id="ajoutProduit">Ajout produit</button>
            <button id="modificationProduit">Modification produit</button>
        </nav>
    </header>
    <main>
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
                    <th>Date</th>
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
                            <input type="submit" id="update" name="modifier<?= $itemsProduit['ref']?>" value="Modifier">
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