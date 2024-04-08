<?php
/**
 * Arxiu redirect.php
 *
 * Aquest arxiu conté l'script de redirecció de l'usuari.
 * Si no hi ha cap sessió activa, dirigeix a la pàgina 'index.php'
 * Si l'usuari te un rol diferent a 1 (administrador) dirigeix a l'àrea d'usuari.
 *
 * @category   Redirecció
 * @package    useraccess
 * @author     Isabel León
 */

/**
 * Requereix l'arxiu filesystem.php, del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
require 'helpers/filesystem.php';  

$url_base = "http://localhost/userAccess/";

if (!isset($_SESSION["user_name"])) {
    logEventDanger("Tentativa d'accés no autoritzat a l'aplicació.");

    header("Location:".$url_base."index.php");
}

if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] != 1) {
    header("Location:".$url_base."vistas/usuari.php");
}