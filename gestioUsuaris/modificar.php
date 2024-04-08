<?php
/**
 * Arxiu modificar.php
 *
 * Mostra les dades actuals de l'usuari i permet a l'Administrador modificar-les des de l'àrea d'Administrador.
 * 
 * @category   Vistes
 * @package    gestioUsuaris
 * @author     Isabel Léon
 */

/**
 * Requereix l'arxiu de conexió a la Base de Dades.
 *
 * Conté la configuració per establir la conexió a la Base de Dades utilitzant el métode MySQLi.
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
 * Inclou funcions per llegir dades de la BBDD.
 *
 * @see        helpers.php
 */
require 'helpers.php';

/**
 * Llegeix a la BBDD les dades de l'usuari a partir de la seva ID que arriba per la url, i les mostra al formulari.
 */
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sql = "SELECT * FROM usuaris WHERE id=$txtID";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $actualitza = mysqli_fetch_assoc($result);
        $nom = $actualitza["nom"];
        $cognom = $actualitza["cognom"];
        $email = $actualitza["email"];
        $rolId = $actualitza["rol_id"];
        $auto_restore = $actualitza["auto_restore"];
    } else {
        echo "Error en la consulta: " . mysqli_error($db);
    }
}
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

    <!-- Resposta que arriba de modificar.js -->
    <div id="response"></div>

    <!-- FORMULARI -->
    <form id="modForm">
        <div class="row mb-4">
            <label for="txtID" class="col-sm-2 col-form-label">Id</label>
            <div class="col-sm-10">
                <input type="text" value="<?= $txtID; ?>" name="txtID" class="form-control" id="txtID" required readonly>
            </div>
        </div>

        <div class="row mb-4">
            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" value="<?= $nom; ?>" name="nom" class="form-control" id="nom">
            </div>
        </div>

        <div class="row mb-4">
            <label for="cognom" class="col-sm-2 col-form-label">Cognom</label>
            <div class="col-sm-10">
                <input type="text" value="<?= $cognom; ?>" name="cognom" class="form-control" id="cognom">
            </div>
        </div>

        <div class="row mb-4">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" value="<?= $email; ?>" name="email" class="form-control" id="email">
            </div>
        </div>

        <!--  Input formulari NOVA_PASSWORD -->
        <div class="row mb-4">
            <label for="password" class="col-sm-2 col-form-label">Nova contrasenya</label>
            <div class="col-sm-10">
                <input type="password" name="nova_password" class="form-control" id="nova_password" aria-label="passHelp">
            </div>
            <div class="passHelp" id="passHelp">
                La contrasenya ha de tenir entre 8 i 16 caracters, contenir lletres, números i caracters especials.
            </div>
        </div>

        <!--  Input formulario PERMISOS -->
        <div class="row mb-4">
            <select name="rol_id" class="form-select col-sm-10" id="rol_id">
                <option selected>Permisos</option>

                <?php
                $rols = conseguirRols($db);

                foreach ($rols as $rol) :
                    $selected = ($rolId == $rol['rol_id']) ? 'selected' : '';
                ?>
                    <option <?= $selected; ?> value="<?= $rol['rol_id']; ?>">
                        <?= $rol['rol_nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input formulario AUTO_RESTORE  -->
        <div class="row mb-4">
            <select name="auto_restore" class="form-select col-sm-10" id="auto_restore">
                <option selected>Auto restore password</option>

                <?php
                $autoRestoreValues = conseguirAutoRestore($db);

                foreach ($autoRestoreValues as $valor) :
                    $selected = ($auto_restore == $valor['auto_id']) ? 'selected' : '';
                ?>
                    <option <?= $selected; ?> value="<?= $valor['auto_id']; ?>">
                        <?= $valor['auto_desc'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Actualitzar</button>
        </div>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="modificar.js"></script>

</body>

</html>