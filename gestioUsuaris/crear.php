<?php
/**
 * Arxiu crear.php
 *
 * Conté el formulari per crear un nou usuari des de l'àrea d'Administrador.
 * 
 * @category   Vistes
 * @package    gestioUsuaris
 * @author     Isabel Léon
 */

/**
 * Requereix l'arxiu de conexió a la BBDD.
 *
 * Conté la configuració per establir la conexió a la BBDD utilitzant el métode MySQLi.
 * 
 * @see        database/connect.php
 */
require_once '../database/connect.php';

/**
 * Requereix l'arxiu per redirigir als usuaris.
 *
 * Conté les redireccions de l'usuari segons l'estat de la sessió.
 *
 * @see        ../redirect.php
 */
require '../redirect.php';

/**
 * Requereix l'arxiu helpers.
 *
 * Inclou funcions per llegir dades de la BBDD anomenades 'conseguirRols'
 * i 'conseguirAutoRestore' que s'inclouen dintre del formulari als inputs <select>
 *
 * @see        helpers.php
 */
require 'helpers.php';                   
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/admin.css" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <!-- NavBar Administrador -->
    <?php include '../includes/adminNavBar.php'; ?>

    <!-- Resposta que arriba de crear.js -->
    <div id="response"></div> 

    <!-- FORMULARI -->
    <form id="regForm">
        <div class="row mb-4">
            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" name="nom" class="form-control" id="nom" required>
            </div>
        </div>

        <div class="row mb-4">
            <label for="cognom" class="col-sm-2 col-form-label">Cognom</label>
            <div class="col-sm-10">
                <input type="text" name="cognom" class="form-control" id="cognom" required>
            </div>
        </div>

        <div class="row mb-4">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
        </div>

        <div class="row mb-4">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="password" aria-label="passHelp" required>
            </div>
            <div class="passHelp" id="passHelp">
                La contrasenya ha de tenir entre 8 i 16 caracters, contenir lletres, números i caracters especials.
            </div>
        </div>

        <!--  Input formulari PERMISOS -->
        <div class="row mb-4">
            <select name="rol_id" class="form-select col-sm-10" id="rol_id" required>
                <option selected>Permisos</option>

                <?php
                //Els rols s'obtenen de la Base de Dades amb la funció 'conseguirRols'
                $resultRols = conseguirRols($db);

                //Itera sobre els resultats si hi ha rols
                foreach ($resultRols as $rol) :
                ?>
                    <option value="<?= $rol['rol_id'] ?>">
                        <?= $rol['rol_nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input formulari AUTO_RESTORE  -->
        <div class="row mb-4">
            <select name="auto_restore" class="form-select col-sm-10" id="auto_restore">
                <option selected>Auto restore password</option>

                <?php
                //Els valors d'Auto Restore s'obtenen de la Base de Dades amb la funció 'conseguirAutoRestore'
                $resultRestore = conseguirAutoRestore($db);

                //Itera sobre els resultats si hi ha valors d'Auto Restore
                foreach ($resultRestore as $restore) :
                ?>
                    <option value="<?= $restore['auto_id']; ?>">
                        <?= $restore['auto_desc'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Crear</button>
        </div>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="crear.js"></script>

</body>

</html>