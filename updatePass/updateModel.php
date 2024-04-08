<?php
/**
 * Arxiu updateModel.php
 *
 * Gestiona, comprova i actualitza la contrasenya de l'usuari a la Base de Dades.
 * 
 * @category   Model
 * @package    useraccess
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
 * Requereix l'arxiu helpers.
 *
 * Inclou funcions per verificar les dades de l'usuari i actualitzar-les a la BBDD.
 *
 * @see        helpers.php
 */
require '../gestioUsuaris/helpers.php';


/**
 * Requereix l'arxiu mailer.php, del directori helpers
 *
 * Inclou la funció 'enviaMail($db, $email_usuari)' que envia un correu electrònic a l'usuari
 * amb l'enllaç per restablir la contrasenya.
 *
 * @see        ../helpers/helpers.php
 */
require '../helpers/mailer.php';

/**
 * Requereix l'arxiu filesystem.php, del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
require '../helpers/filesystem.php';


if ($_POST) {

    $email_usuari = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : false;
    $token = isset($_POST['token']) ? mysqli_real_escape_string($db, $_POST['token']) : false;
    $nova_pass = isset($_POST['nova_pass']) ? mysqli_real_escape_string($db, $_POST['nova_pass']) : false;

    verificaToken($db, $email_usuari, $token);

    verificaPass($nova_pass);

        //Busca el nom de l'usuari per aplicar-lo al missatge del log
        $sqlNom = "SELECT nom FROM usuaris WHERE email='$email_usuari'";
        $resultNom = mysqli_query($db, $sqlNom);
        if ($row = mysqli_fetch_assoc($resultNom)) {
            $_SESSION['user_name'] = $row['nom'];
        }

        $pass_segura = xifrarPass($nova_pass);

        try {
            $sql = "UPDATE usuaris SET password = '$pass_segura' WHERE email = '$email_usuari'";
            $actualitzar = mysqli_query($db, $sql);

            if ($actualitzar) {
                //Registrar l'acció a l'arxiu 'useraccess_log.txt'
                logEvent("Ha restablit correctament la seva contrasenya.");
                echo json_encode(['status' => 'success', 'message' => 'Contrasenya actualitzada.']);

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en la consulta SQL: ' . mysqli_error($db)]);
            }

        } catch (Exception $e) {
            //Registrar l'acció a l'arxiu 'useraccess_log.txt'
            logEvent("S'ha produït un error al restablir la seva contrasenya.");
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }

//Tancar la connexió a la BBDD
mysqli_close($db);
}
