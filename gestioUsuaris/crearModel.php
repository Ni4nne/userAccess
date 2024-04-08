<?php
/**
 * Arxiu crearModel.php
 *
 * Gestiona, comprova i registra les dades d'un nou usuari des de l'àrea d'Administrador. 
 * 
 * @category   Model
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
 * Conté redireccions de l'usuari segons l'estat de la sessió.
 *
 * @see        ../redirect.php
 */
require '../redirect.php';

/**
 * Requereix l'arxiu helpers.
 *
 * Inclou funcions per verificar les dades de l'usuari i fer el registre a la BBDD.
 *
 * @see        helpers.php
 */
require 'helpers.php';

/**
 * Requereix l'arxiu filesystem.php, del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
require_once '../helpers/filesystem.php';


/**
 * Recollir i assignar les variables del formulari 'crear.php'
 * Utilitza l'operador ternari per gestionar la recollida de les dades.
 * En cas que no estigui definida la variable, assigna 'false' al seu valor.
 * Aplica (int) per convertir el valor de $_POST['rol_id'] a un tipus enter. 
 * Aplica 'mysqli_real_escape_string' per escapar possibles caràcters especials 
 * i evitar injeccions SQL a les cadenes (nom, cognom, email, password).
 * Aplica la funció 'trim', per eliminar espais en blanc als extrems de l'string.
 */
if ($_POST) {
    $rol = isset($_POST['rol_id']) ? (int)$_POST['rol_id'] : false;
    $nom = isset($_POST['nom']) ? mysqli_real_escape_string($db, trim($_POST['nom'])) : false;
    $cognom = isset($_POST['cognom']) ? mysqli_real_escape_string($db, trim($_POST['cognom'])) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;
    $auto_restore = isset($_POST['auto_restore']) ? (int)$_POST['auto_restore'] : false;

    verificaNom($nom, $cognom);

    verificaMail($email);

    verificaPass($password);

    existeixEmail($db, $email);

    if ($rol && $nom && $cognom && $email && $password && $auto_restore) {
        $registreCorrecte = registrarUsuari($db, $rol, $nom, $cognom, $email, $password, $auto_restore);
        if ($registreCorrecte) {
            //Registra l'acció a l'arxiu 'useraccess_log.txt'
            logEventAdminCrear($db, "Ha registrat un nou usuari a l'aplicació amb l'id ");
    
            echo json_encode(['status' => 'success', 'message' =>'Usuari registrat correctament.']);
        } else {
            //Registra l'acció a l'arxiu 'useraccess_log.txt'
            logEventAdminCrear($db, "S'ha produït un error al registrar un nou usuari.");

            echo json_encode(['status' => 'error', 'message' => 'Error al registrar usuari.']);
        }
    } else {
        //Registra l'acció a l'arxiu 'useraccess_log.txt'
        logEventAdminCrear($db,"S'ha produït un error al registrar un nou usuari.");

        //Si falten dades, mostra una alerta d'error
        echo json_encode(['status' => 'error', 'message' => 'Si us plau, completa tots els camps del formulari.']);
    }
    
//Tancar la connexió a la BBDD
mysqli_close($db);
}
