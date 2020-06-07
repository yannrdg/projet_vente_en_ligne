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
    <title>Pages visitées</title>
</head>
<body>
<?php
    include '../includes/header.php';
?>  
</body>
</html>
<?php
}
else
{
    header('Location: index.php');
}