<?php
/**
 * Arxiu regModel.php
 *
 * Gestiona, comprova i registra les dades dels nous usuaris.
 * 
 * @category   Model
 * @package    useraccess
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
 * Requereix l'arxiu helpers del directori gestioUsuaris.
 *
 * Inclou funcions per verificar les dades de l'usuari i fer el registre a la BBDD.
 *
 * @see        helpers.php
 */
require '../gestioUsuaris/helpers.php';

/**
 * Requereix l'arxiu filesystem.php del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels ususaris.
 *
 * @see        helpers/filesystem.php
 */
require '../helpers/filesystem.php'; 

if ($_POST) {
    
    /**
     * Recollir i assignar variables del formulari 'registre.php'
     * Utilitza l'operador ternari per gestionar la recollida de les dades.
     * En cas que no estigui definida la variable, assigna 'false' al seu valor.
     * Aplica la funció 'mysqli_real_escape_string' per escapar possibles caràcters especials 
     * i evitar injeccions SQL a les cadenes (nom, cognom, email, password).
     * Aplica la funció 'trim', per eliminar espais en blanc als extrems de l'string
     */
    $nom = isset($_POST['nom']) ? mysqli_real_escape_string($db, trim($_POST['nom'])) : false;
    $cognom = isset($_POST['cognom']) ? mysqli_real_escape_string($db, trim($_POST['cognom'])) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

    verificaNom($nom, $cognom);

    existeixEmail($db, $email);

    verificaPass($password);

    if ($nom && $cognom && $email && $password) {

        $pass_segura = xifrarPass($password);

        /**Insertar usuari a la BBDD. 
         * Per defecte: rol_id = 2, usuari_registrat.
         * Per defecte: auto_restore = 2, no es tenen permisos per restablir password.
         */
        $sql = "INSERT INTO usuaris (rol_id, nom, cognom, email, password, auto_restore) VALUES (2, '$nom', '$cognom', '$email', '$pass_segura', 2)";
        $insert_result = mysqli_query($db, $sql);

        if ($insert_result) {
            $_SESSION['user_name'] = $nom; 
            $_SESSION['rol_id'] = 2;
            //Registrar l'acció a l'arxiu 'useraccess_log.txt'
            logEvent("S'ha registrat a l'aplicació.");

            echo json_encode(['status' => 'success']);
        } else {
            //Registrar l'acció a l'arxiu 'useraccess_log.txt'
            logEvent("S'ha produït un error durant el registre.");

            echo json_encode(['status' => 'error', 'message' => 'Error al registrar usuari.']);
        }

    } else {
        //Registrar l'acció a l'arxiu 'useraccess_log.txt'
        logEvent("S'ha produït un error durant el registre.");

        //Si falten dades, mostra alerta d'error.
        echo json_encode(['status' => 'error', 'message' => 'Dades incompletes o incorrectes.']);
    }

//Tancar la connexió a la BBDD
mysqli_close($db);
}
