<?php
/**
 * Arxiu que conté la barra de navegació de l'usuari registrat a l'aplicació.
 *
 * Conté el codi HTML per la barra de navegació de l'usuari registrat,
 * amb enllaços a diferents seccions de l'aplicació.
 *
 * @category   Vistes
 * @package    includes
 * @author     Isabel Léon
 */

$url_base = "http://localhost/userAccess/"; ?>

<!-- MENÚ DE NAVEGACIÓ USUARI-->
<nav class="navbar navbar-light" style="background-color: #e6e8ea;">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">Clients</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Comandes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Facturació</a>
        </li>
    </ul>

    <!-- Mostra el nom de l'usuari de la sessió-->
    <div class="container" id="container">
        <h3>Benvingut, <?= $_SESSION['user_name']; ?> </h3>
    </div>

    <!-- Tancar sessió d'usuari -->
    <div class="logout" id="logout">
        <i class="bi bi-x-circle"></i>
        <a href="../logout.php" class="logout" id="logout"> Tancar sessió </a>
    </div>
</nav>