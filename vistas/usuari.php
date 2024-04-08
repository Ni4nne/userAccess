<?php
/**
 * Arxiu usuari.php
 *
 * Aquest arxiu conté la vista de l'àrea d'usuari.
 *
 * @category   Vistes
 * @package    useraccess
 * @author     Isabel Léon
 */

/**
 * Requereix l'arxiu filesystem.php, del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
include '../helpers/filesystem.php';

session_start();
$url_base = "http://localhost/userAccess/"; 

if (!isset($_SESSION["user_name"])) {
    logEventDanger("Tentativa d'accés no autoritzat a l'aplicació.");

    header("Location:".$url_base."index.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/admin.css" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <!-- NavBar Usuari -->
    <?php include '../includes/userNavBar.php'; ?>

</body>

</html>