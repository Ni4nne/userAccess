<?php
/**
 * Arxiu resetModel.php
 *
 * Gestiona, comprova i permet restablir la contrasenya a l'usuari que tingui els permisos.
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

/**
 * Requereix l'arxiu 'autoload' de Composer.
 *
 * Gestiona la càrrega automàtica de classes al projecte.
 * 
 * @see        ../vendor/autoload.php
 */
require '../vendor/autoload.php';

if ($_POST) {

    /**
     * Recollir i assignar variable de l'email de l'usuari que vol restablir la seva contrasenya.
     * Utilitza l'operador ternari per gestionar la recollida de les dades i assignar els valors.
     * En cas que no estigui definida la variable s'assigna 'false' al seu valor.
     * Aplica la funció 'mysqli_real_escape_string' per escapar possibles caràcters especials 
     * i evitar injeccions SQL a les cadenes (email).
     * Aplica la funció 'trim', per eliminar espais en blanc als extrems de l'string.
     */
    $email_usuari = $_POST['email'] ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $sql = "SELECT id, nom, email, auto_restore FROM usuaris WHERE email='$email_usuari'";
    $result = mysqli_query($db, $sql);

    /**
     * Comprova que l'usuari disposa dels permisos per restablir la seva contrasenya.
     * 
     * Comprova si existeix el correu a la Base de Dades. En cas afirmatiu, comprova si l'usuari té permís per restablir
     * la contrasenya. Si es compleixen les dues condicions, mostra una resposta JSON d'èxit i envia un correu electrònic
     * amb l'enllaç per restablir. En cas que no tingui permís, mostra una alerta d'error.
     */
    if (!$result) {
        echo "Error en la consulta SQL: " . mysqli_error($db);
        echo json_encode(['status' => 'error', 'message' => 'Error a la Base de Dades.']);
        logEvent("S'ha produït un error en la consulta a la Base de Dades a l'intentar restablir la contrasenya.");
        die();
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo json_encode(['status' => 'error', 'message' => 'No es troba el correu a la Base de Dades.']);
        die();
    }

    if ($row['auto_restore'] != 1) {
        echo json_encode(['status' => 'error', 'message' => 'Contacta amb Administrador per restablir la teva contrasenya.']);
        die();
    }

    try {
        $token = generaToken();
        $guardado = guardaToken($db, $email_usuari, $token);
    
        if (!$guardado) {
            echo "Error al emmagatzemar el token a la Base de Dades: " . mysqli_error($db);
            echo json_encode(['status' => 'error', 'message' => 'Error al guardar el token a la Base de Dades.']);
            die();
        }
    
        enviaMail($email_usuari, $token);
        $_SESSION['user_name'] = $row['nom'];
        logEvent("Ha sol·licitat restablir la seva contrasenya.");
        echo json_encode(['status' => 'success', 'message' => 'Comprova el teu correu per restablir la contrasenya.']);

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        echo json_encode(['status' => 'success', 'message' => "S'ha produït un error en processar la sol·licitud."]);
    }

//Tancar la connexió a la BBDD
mysqli_close($db);
}
