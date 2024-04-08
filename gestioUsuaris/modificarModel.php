<?php

/**
 * Arxiu modificarModel.php
 *
 * Gestiona, comprova i actualitza les dades dels usuaris des de l'àrea d'Administrador. 
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
 * Inclou funcions per verificar les dades de l'usuari i actualitzar-les a la BBDD.
 *
 * @see        helpers.php
 */
require 'helpers.php';

/**
 * Requereix l'arxiu filesystem.php, del directori 'helpers'
 *
 * Inclou funció 'logEvent' que registra les accions dels usuaris.
 *
 * @see        helpers/filesystem.php
 */
require_once '../helpers/filesystem.php';


/**
 * Requereix l'arxiu mailer.php
 *
 * Inclou la funció 'enviaMailGestioUsuaris($db, $email)' que envia un correu electrònic a l'usuari
 * quan l'Administrador canvia la seva contrasenya.
 *
 * @see        ../helpers/helpers.php
 */
require '../helpers/mailer.php';

/**
 * Requereix l'arxiu autoload, de Composer.
 *
 * Gestiona la càrrega automàtica de classes al projecte.
 * 
 * @see        ../vendor/autoload.php
 */
require '../vendor/autoload.php';

if ($_POST) {

    /**
     * Recollir i assignar les variables del formulari modificar.php
     * Utilitza l'operador ternari per gestionar la recollida de les dades.
     * En cas que no estigui definida la variable assigna 'false' al seu valor.
     * Aplica (int) per convertir el valor de $_POST['txtID'] a un tipus enter. 
     * Aplica 'mysqli_real_escape_string' per escapar possibles caràcters especials 
     * i evitar injeccions SQL a les cadenes (nom, cognom, email).
     * Aplica la funció 'trim', per eliminar espais en blanc als extrems de l'string.
     */
    $txtID = isset($_POST['txtID']) ? (int)$_POST['txtID'] : false;
    $nom = isset($_POST['nom']) ? mysqli_real_escape_string($db, trim($_POST['nom'])) : false;
    $cognom = isset($_POST['cognom']) ? mysqli_real_escape_string($db, trim($_POST['cognom'])) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $rol = isset($_POST['rol_id']) ? (int)$_POST['rol_id'] : false;
    $auto_restore = isset($_POST['auto_restore']) ? (int)$_POST['auto_restore'] : false;

    verificaCampsBuits($nom, $cognom, $email, $rol, $auto_restore);

    verificaNom($nom, $cognom);

    verificaMail($email);

    existeixEmailExcepte($db, $email, $txtID);

    /**
     * Si el camp nova contrasenya no és buit, utilitza una expressió regular per verificar que
     * compleixi els requeriments de seguretat. La contrasenya ha de tenir entre 8 i 16 caràcters, 
     * almenys una majúscula, una minúscula, un número i un símbol especial.
     *
     * @param string $nova_pass    - Contrasenya que es vol verificar.
     *
     * @return void No retorna cap valor. Si no compleix els requeriments mostra un missatge d'error
     *              i finalitza l'execució del programa.
     */
    if (!empty($_POST['nova_pass'])) {
        $nova_pass = $_POST["nova_pass"];
        verificaPass($nova_pass);

        $pass_segura = xifrarPass($nova_pass);
        $sqlUpdatePass = "UPDATE usuaris SET password='$pass_segura' WHERE id='$txtID'";
        $resultUpdatePass = mysqli_query($db, $sqlUpdatePass);

        if ($resultUpdatePass) {
            /**
             * Bloc 'try' que podria tornar una excepció. Si la resposta és correcta mostra alerta d'èxit.
             */
            try {
                enviaMailGestioUsuaris($email);

                //Registra l'acció a l'arxiu 'useraccess_log.txt'
                logEventAdmin("Ha restablit la contrasenya de l'usuari ", $txtID);

                echo json_encode(['status' => 'success', 'message' => "Contrasenya actualitzada. Enviant correu a l'usuari..."]);

                /**
                 * Bloc 'catch' que gestiona una excepció en cas que no es pugui enviar el correu electrònic per notificar el canvi de contrasenya.
                 */
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();

                //Registra l'acció a l'arxiu 'useraccess_log.txt'
                logEventAdmin("Error durant l'enviament del correu a l'usuari ", $txtID);
            }

            /**
             * Si la resposta és incorrecta mostra alerta d'error.
             */
        } else {
            //Registra l'acció a l'arxiu 'useraccess_log.txt'
            logEventAdmin("S'ha produït un error al modificar l'usuari ", $txtID);

            echo json_encode(['status' => 'error', 'message' => 'Error al modificar usuari.']);
        }
    } else {
        /**
         * Actualitza les dades de l'usuari amb els nous valors introduïts al formulari.
         */
        $sqlUpdate = "UPDATE usuaris SET nom='$nom', cognom='$cognom', email='$email', rol_id='$rol', auto_restore='$auto_restore' WHERE id='$txtID'";
        $resultUpdate = mysqli_query($db, $sqlUpdate);

        if ($resultUpdate) {

            //Registra l'acció a l'arxiu 'useraccess_log.txt'
            logEventAdmin("Ha actualitzat dades de l'usuari ", $txtID);

            echo json_encode(['status' => 'success', 'message' => 'Dades actualitzades.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al modificar usuari.']);
        }
    }

//Tancar la connexió a la BBDD
mysqli_close($db);
}
