<?php
/**
 * Arxiu admin.php
 *
 * Aquest arxiu conté la vista de l'àrea d'Administrador de l'Aplicació.
 * Mostra una taula amb tots els usuaris registrats i permet editar, 
 * modificar, esborrar els usuaris i les seves dades.
 *
 * @category   Vistes
 * @package    useraccess
 * @author     Isabel Léon
 */

/**
 * Requereix l'arxiu de conexió a la BBDD.
 *
 * Aquest arxiu conté la configuració necessària per establir la conexió a la BBDD
 * utilitzant el métode MySQLi.
 *
 * @see        database/connect.php
 */
require_once '../database/connect.php';

/**
 * Requereix l'arxiu per redirigir als usuaris.
 *
 * Aquest arxiu conté les redireccions de l'usuari segons l'estat de la sessió.
 *
 * @see        ../redirect.php
 */
require '../redirect.php';

/**
 * Requereix l'arxiu filesystem.php, del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
require_once '../helpers/filesystem.php';


/**
 * Elimina un usuari de la Base de Dades segons l'ID proporcionat.
 * 
 * Gestiona una sol.licitud GET que inclou el paràmetre 'txtID'
 * Quan existeix aquest paràmetre 'txtID', s'utilitza per fer una consulta SQL a la taula 'usuaris'
 * i elimina l'usuari amb aquest l'ID.
 *
 * @param mysqli $db        - Conexió a la BBDD utilizant MySQLi.
 * @param string $txtID     - ID de l'usuari que es vol esborrar.
 *
 * @return void - Aquest bloc no retorna cap valor.
 */
function eliminaUsuari($db, $txtID)
{
    $sql = "DELETE FROM usuaris WHERE id=$txtID";
    $result = mysqli_query($db, $sql);
}
//Crida a la funció
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    eliminaUsuari($db, $txtID);
    //Registra l'acció a l'arxiu 'useraccess_log.txt'
    logEvent("Ha eliminat l'usuari amb l'id $txtID.");
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css" />
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

</head>

<body>
    <!-- NavBar Administrador -->
    <?php include '../includes/adminNavBar.php'; ?>

    <div class="card">
        <div class="card-header">
            <a name="" id="" class="btn btn-primary" href="../gestioUsuaris/crear.php" role="button">Crear usuari</a>
        </div>

        <!-- TAULA usuaris -->
        <?php
        $sql = "SELECT usuaris.*, rols.rol_nom as rol_descripcion, auto_restore.auto_desc as auto_descripcion
        FROM usuaris
        INNER JOIN rols ON usuaris.rol_id = rols.rol_id
        INNER JOIN auto_restore ON usuaris.auto_restore = auto_restore.auto_id
        ORDER BY usuaris.id ASC";

        $resultatUsuaris = $db->query($sql);

        if ($resultatUsuaris->num_rows > 0) {

            echo '
            <div class="card-body">
            <div class="table-responsive-sm">
                <table id="tableID" class="table table-hover">
                    <thead class="thead-dark">
                        <tr class="table-primary">
                            <th scope="col">Usuari id</th>
                            <th scope="col">Rol id</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Cognom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Auto Restore</th>
                            <th scope="col">Gestionar</th>
                            </tr>
                            </thead>
                            <tbody>';

            while ($row = $resultatUsuaris->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row['rol_descripcion'] . '</td>
                        <td>' . $row["nom"] . '</td>
                        <td>' . $row["cognom"] . '</td>
                        <td>' . $row["email"] . '</td>
                        <td>' . $row["auto_descripcion"] . '</td>
                        <td> 
                        <a class="btn btn-primary" href="../gestioUsuaris/modificar.php?txtID=' . $row['id'] . '" role="button">Editar</a>
                        <a class="btn btn-danger" href="admin.php?txtID=' . $row['id'] . '" role="button">Eliminar</a>
                        </td>
                        </tr>';
            }

            echo '</tbody>
                    </table>';
        } ?>

    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>