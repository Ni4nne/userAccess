<?php
/**
 * Arxiu logout.php
 *
 * Tanca la sessió actual, i després dirigeix a 'index.php'.
 *
 * @category    Autenticació
 * @package     useraccess
 * @author      Isabel León
 */

/**
 * Requereix l'arxiu filesystem.php del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
require 'helpers/filesystem.php';  

session_start();

if(isset($_SESSION['user_name'])){
    //Registrar l'acció a l'arxiu 'useraccess_log.txt'
    logEvent("Ha finalitzat la sessió.");
    session_destroy();
}

header('Location: index.php');
?>
