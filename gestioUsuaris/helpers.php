<?php
/**
 * Arxiu helpers.php
 *
 * Conté funcions per llegir dades de la BBDD i verificar informació de l'usuari.
 * 
 * @category   Model
 * @package    gestioUsuaris
 * @author     Isabel Léon
 */


/**
 * Obtenir els rols des de la BBDD.
 *
 * Consulta la taula 'rols' per obtenir els valors ordenats per l'índex 'rol_id' de manera ascendent.
 *
 * @param mysqli $db - Conexió a la BBDD utilizant MySQLi.
 *
 * @return array - Retorna un array si la consulta és correcta i hi ha almenys un resultat.
 *                 En cas contrari, retorna un array buit.
 */
 function conseguirRols($db)
 {
    //Realitza consulta SQL a la BBDD per obtenir tots els rols ordenats per rol_id ascendent
     $rols = mysqli_query($db, "SELECT * FROM rols ORDER BY rol_id ASC;");
 
    //Inicia un array per emmagatzemar els resultats de la consulta 
     $resultRols = array();

    //Comprova si la consulta ha tingut èxit i hi ha almenys un resultat
     if ($rols && mysqli_num_rows($rols) >= 1) {

         // Si hi ha resultats, obtenim les dades com un array associatiu
         while ($row = mysqli_fetch_assoc($rols)) {
             $resultRols[] = $row;
         }
 
         // Retorna l'array amb els rols
         return $resultRols;
     }
 
     // Retorna un array buit si no hi ha resultats
     return $resultRols;
 }
 

/**
 * Obtenir valors d'Auto Restore des de la BBDD.
 *
 * Consulta la taula 'auto_restore' per obtenir els valors ordenats per l'índex auto_id de manera ascendent.
 * 
 * @param mysqli $db    - Conexió a la BBDD utilizant MySQLi.
 *
 * @return array - Retorna un array si la consulta és exitosa i hi ha almenys un resultat.
 *               En cas contrari, retorna un array buit.
 */
function conseguirAutoRestore($db)
{
    //Realitza consulta SQL a la BBDD per obtenir els valors d'Auto Restore ordenats per auto_id ascendent
    $auto = mysqli_query($db, "SELECT * FROM auto_restore ORDER BY auto_id ASC;");

    //Inicia un array per emmagatzemar els resultats de la consulta $auto
    $resultRestore = array();

    // Comprova si la consulta ha tingut èxit i hi ha almenys un resultat
    if ($auto && mysqli_num_rows($auto) >= 1) {
        
        // Si hi ha resultats, obtenim les dades com un array associatiu
        while ($row = mysqli_fetch_assoc($auto)) {
            $resultRestore[] = $row;
        }

        // Retorna l'array amb les configuracions d'Auto Restore
        return $resultRestore;
    }

    // Retorna un array buit si no hi ha resultats
    return $resultRestore;
}

/**
 * Verifica que nom i cognoms de l'usuari no tinguin números.
 *
 * @param string $nom       - Nom que es vol verificar.
 * @param string $cognom    - Cognom que es vol verificar.
 *
 * @return void - No retorna cap valor. Si els paràmetres contenen números, mostra un missatge d'error
 *              i finalitza l'execució del programa.
 */
function verificaNom($nom, $cognom) {
    if (!ctype_alpha($nom) || !ctype_alpha($cognom)) {
        echo json_encode(['status' => 'error', 'message' => 'El nom i cognom no poden contenir números.']);
        die();
    }
}

/**
 * Utilitza una expressió regular per verificar que la contrasenya de l'usuari compleixi els requeriments de seguretat.
 * La contrasenya ha de tenir entre 8 i 16 caràcters, almenys una majúscula, una minúscula, un número i un símbol especial.
 * 
 * @param string $password  - Contrasenya que es vol verificar.
 *
 * @return void - No retorna cap valor. Si no compleix els requeriments mostra un missatge d'error
 *              i finalitza l'execució del programa.
 */
function verificaPass($password) {
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/', $password)) {
        echo json_encode(['status' => 'error', 'message' => 'La contrasenya no compleix els requeriments.']);
        die();
    }
}

/**
 * Verifica que el correu electrònic sigui vàlid.
 *
 * @param string $email    - Correu electrònic que es vol verificar.
 *
 * @return void  - No retorna cap valor. Si no es vàlid, mostra un missatge d'error i finalitza
 *               l'execució del programa.
 */
function verificaMail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Email no vàlid.']);
        die();
    }
}

/**
 * Comprova si un correu electrònic ja existeix a la BBDD.
 *
 * @param mysqli $db     - Conexió a la BBDD utilizant MySQLi.
 * @param string $email  - Correu electrònic que es vol comprovar si ja està registrat.
 *
 * @return void  - No retorna cap valor. Si el correu ja existeix, mostra un missatge d'error
 *               i finalitza l'execució del programa.
 */
function existeixEmail($db, $email) {
    $buscarEmailDb = "SELECT * FROM usuaris WHERE email = '$email'";
    $resultat = mysqli_query($db, $buscarEmailDb);
    if (mysqli_num_rows($resultat) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El correu electrònic ja es troba registrat.']);
        die();
    }
}


/**
 * Comprova si un correu electrònic ja està en ús per un altre usuari a la BBDD.
 * S'utilitza per evitar que es registrin vàries comptes amb el mateix correu electrònic.
 *
 * @param mysqli $db        - Conexió a la BBDD utilizant MySQLi.
 * @param string $email     - Correu electrònic que es vol comprovar si ja està registrat.
 * @param int $txtID        - ID de l'usuari que s'ha d'excloure de la comprovació.
 *
 * @return void  - No retorna cap valor. Si el correu ja existeix a la Base de Dades, mostra un 
 *                 missatge d'error i finalitza l'execució del programa.               
 */
function existeixEmailExcepte($db, $email, $txtID) {
    $buscarEmailDb = "SELECT * FROM usuaris WHERE email = '$email' AND id != '$txtID'";
    $resultat = mysqli_query($db, $buscarEmailDb);
    if (mysqli_num_rows($resultat) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El correu electrònic ja es troba registrat.']);
        die();
    }
}

/**
 * Xifra la contrasenya amb la funció 'password_hash' utilitzant l'algoritme Bcrypt amb un cost de 4.
 * El cost és el nombre de rondes de xifrat que s'aplicaran, afectant la força de la clau hash.
 * Un cost més elevat incrementa la seguretat, però també pot afectar el rendiment.
 *
 * @param string $password  - Contrasenya que es vol xifrar.
 * @param int $cost         - Cost del xifrat a aplicar. Un valor més alt augmenta la seguretat, però pot 
 *                              afectar al rendiment.
 *
 * @return string           - Torna la contrasenya xifrada.
 */
function xifrarPass($password, $cost = 4) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
}

/**
 * Registra un nou usuari a la BBDD.
 *
 * @param mysqli $db            - Conexió a la BBDD utilizant MySQLi.
 * @param int $rol              - ID del rol de l'usuari.
 * @param string $nom           - Nom de l'usuari.
 * @param string $cognom        - Cognom de l'usuari.
 * @param string $email         - Correu electrònic de l'usuari.
 * @param string $password      - Contrasenya xifrada de l'usuari.
 * @param int $auto_restore     - ID del valor per auto-restore.
 *
 * @return bool - True si l'usuari es registra correctament, False si ha hagut error.
 */
function registrarUsuari($db, $rol, $nom, $cognom, $email, $password, $auto_restore) {
    $pass_segura = xifrarPass($password);
    $sql = "INSERT INTO usuaris (rol_id, nom, cognom, email, password, auto_restore) VALUES ( '$rol', '$nom', '$cognom', '$email', '$pass_segura', '$auto_restore')";
    $insert = mysqli_query($db, $sql);

    return $insert;
}

/**
 * Verifica que els camps del formulari no estiguin buits abans de modificar dades de l'usuari
 *
 * @param string $nom           - Nom de l'usuari.
 * @param string $cognom        - Cognom de l'usuari.
 * @param string $email         - Correu electrònic de l'usuari.
 * @param int $rol              - ID del rol de l'usuari.
 * @param int $auto_restore     - ID del valor per auto-restore.
 *
 * @return void No retorna cap valor. Si els camps estan buits, mostra un missatge d'error
 *              i finalitza l'execució del programa.
 */
function verificaCampsBuits($nom, $cognom, $email, $rol, $auto_restore) {
    if (empty($nom) || empty($cognom) || empty($email) || empty($rol) || empty($auto_restore)) {
        echo json_encode(['status' => 'error', 'message' => 'Si us plau, completa tots els camps.']);
        die();
    }
}