<?php
/**
 * Arxiu que conté la barra de navegació de l'usuari Administrador de l'aplicació.
 *
 * Conté el codi HTML per la barra de navegació de l'administrador,
 * amb enllaços a diferents seccions de l'aplicació.
 *
 * @category   Vistes
 * @package    includes
 * @author     Isabel Léon
 */

$url_base = "http://localhost/userAccess/"; ?>

<!-- MENÚ DE NAVEGACIÓ ADMINISTRADOR-->
<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">Proveïdors</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= $url_base; ?>vistas/admin.php">Gestió Usuaris</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= $url_base; ?>vistas/llegirLogs.php">Registre logs</a>
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