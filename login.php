<?php
/**
 * Arxiu login.php
 *
 * Gestiona i comprova les dades rebudes des del formulari 'index.php'
 * Comprova que correu i contrasenya siguin válids.
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
require_once 'database/connect.php';

/**
 * Requereix l'arxiu helpers del directori gestioUsuaris.
 *
 * Inclou funcions per verificar les dades de l'usuari i fer el registre a la BBDD.
 *
 * @see        helpers.php
 */
require 'gestioUsuaris/helpers.php';


/**
 * Requereix l'arxiu filesystem.php del directori helpers
 *
 * Inclou funció 'logEvent' que registra les accions dels ususaris.
 *
 * @see        helpers/filesystem.php
 */
require 'helpers/filesystem.php';   

if ($_POST) {
    
/** 
 * Recollir i assignar les variables del formulari 'index.php'
 * Utilitza l'operador ternari per gestionar la recollida de les dades.
 * En cas que no estigui definida la variable s'assigna "false" al seu valor.
 * Aplica la funció 'mysqli_real_escape_string' per escapar possibles caràcters especials 
 * i evitar injeccions SQL a les cadenes (email, password).
 * Aplica la funció 'trim', per eliminar espais en blanc als extrems de l'string
 */
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;
    $sql = "SELECT rol_id, nom, email, password FROM usuaris WHERE email = '$email'";
    $result = mysqli_query($db, $sql);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {

            /**
             * Verifica la contrasenya utilizant 'password_verify' i estableix la sessió de l'usuari.
             * 
             * Comprova si la contrasenya introduïda coincideix amb l'emmagatzemada a la BBDD.
             * En cas afirmatiu, crea la sessió global 'user_name' i assigna el 'rol_id' a la sessió.
             * Mostra una resposta JSON d'èxit. En cas contrari, mostra una alerta d'error.
             */
            if (password_verify($password, $row['password'])) {     //Comprovar password  
                $_SESSION['user_name'] = $row['nom'];               //Assigna nom d'usuari a la sessió  
                $_SESSION['rol_id'] = $row['rol_id'];               //Assigna rol_id a la sessió

                //Registrar l'acció a l'arxiu 'useraccess_log.txt'
                logEvent("Ha iniciat sessió.");
                
                $response = array('status' => 'success');
                echo json_encode($response);

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Contrasenya incorrecta.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No es troba el correu.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en la base de dades.']);
    }

//Tancar la connexió a la BBDD
mysqli_close($db);
}
