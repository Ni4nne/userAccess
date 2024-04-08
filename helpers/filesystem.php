<?php
/**
 * Arxiu filesystem.php.
 *
 * Registra esdeveniments i accions, dintre l'arxiu 'useraccess_log.txt'. 
 * Consisteix a un missatge amb la data, hora, nom d'usuari i l'acció realitzada.
 *
 * @category   Registre esdeveniments
 * @package    useraccess
 * @author     Isabel Léon
 */

/**
 * Registra esdeveniments i accions de l'usuari.
 * 
 * @param string $message       - Missatge que es registrarà a l'arxiu 'useraccess_log.txt'.
 * @param string $username      - Nom d'usuari que realitza l'acció.
 * @return void
 *
 * @throws \RuntimeException    - Si no es pot obrir l'arxiu 'useraccess_log.txt'.
 */
function logEvent($message) {
    $logFile = __DIR__ . "/../logs/useraccess_log.txt";

    //Intenta obrir l'arxiu de registre
    $logFileHandle = fopen($logFile, "a");

    //Comprova si s'ha pogut obrir, sino llença una excepció
    if ($logFileHandle === false) {
        throw new \RuntimeException("Error: No s'ha pogut obrir l'arxiu.");
    }

    //Obtenir el nom de l'usuari que realitza l'acció
    $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuari Desconegut';

    //Formatejar les dades del registre
    $logData = date("d-m-Y H:i:s") . " - " . $username . ": " . $message . PHP_EOL;

    //Escriure les dades a l'arxiu
    fwrite($logFileHandle, $logData);

    //Tancar l'arxiu
    fclose($logFileHandle);
}

/**
 * Registra esdeveniments i accions de l'usuari no identificat a l'aplicació.
 * 
 * @param string $message       - Missatge que es registrarà a l'arxiu 'useraccess_log.txt'.
 * @param string $username      - Nom d'usuari que realitza l'acció.
 * @return void
 *
 * @throws \RuntimeException    - Si no es pot obrir l'arxiu 'useraccess_log.txt'.
 */
function logEventDanger($message) {
    $logFile = __DIR__ . "/../logs/useraccess_log.txt";

    //Intenta obrir l'arxiu de registre
    $logFileHandle = fopen($logFile, "a");

    //Comprova si s'ha pogut obrir, sino llença una excepció
    if ($logFileHandle === false) {
        throw new \RuntimeException("Error: No s'ha pogut obrir l'arxiu.");
    }

    //Obtenir el nom de l'usuari que realitza l'acció
    $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuari Desconegut';

    //Formatejar les dades del registre amb el missatge amb negreta
    $logData = date("d-m-Y H:i:s") . " - " . $username . ": <strong>" . $message . "</strong>" . PHP_EOL;

    //Escriure les dades a l'arxiu
    fwrite($logFileHandle, $logData);

    //Tancar l'arxiu
    fclose($logFileHandle);
}


/**
 * Registra accions realitzades per l'Administrador.
 *
 * Aquesta funció enregistra un event administratiu en el fitxer 'useraccess_log.txt', que inclou el
 * missatge de l'event i la ID de l'usuari sobre qui es realitza l'acció.
 * 
 * @param string $message           - Missatge que es registrarà a l'arxiu 'useraccess_log.txt'.
 * @param int|null $userId (Opcional)   - ID de l'usuari sobre la qual es realitza l'acció.
 * @throws \RuntimeException Si no es pot obrir el fitxer de registre.
 * @return void
 */
function logEventAdmin($message, $userId = null) {
    $logFile = __DIR__ . "/../logs/useraccess_log.txt";

    //Intenta obrir l'arxiu de registre
    $logFileHandle = fopen($logFile, "a");

    //Comprova si s'ha pogut obrir, sino llença una excepció
    if ($logFileHandle === false) {
        throw new \RuntimeException("Error: No s'ha pogut obrir l'arxiu.");
    }

    //Obtenir el nom de l'usuari Administrador que realitza l'acció
    $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuari Desconegut';

    //Afegir ID de l'usuari sobre qui es realitza l'acció
    if ($userId !== null) {
        $message .= " $userId.";
    }

    //Formatejar dades del registre
    $logData = date("d-m-Y H:i:s") . " - " . $username . ": " . $message . PHP_EOL;

    //Escriure dades a l'arxiu
    fwrite($logFileHandle, $logData);

    //Tancar arxiu
    fclose($logFileHandle);
}

/**
 * Aquesta funció enregistra un event administratiu en el fitxer 'useraccess_log.txt', llegint la ID 
 * del nou usuari enregistrat a l'aplicació.
 *
 * @param string $message       - Missatge que es registrarà a l'arxiu 'useraccess_log.txt'.
 * @throws \RuntimeException    - Si no es pot obrir l'arxiu de registre 'useraccess_log.txt'.
 * @return void
 */
function logEventAdminCrear($db, $message) {

        $result = mysqli_query($db, "SELECT id FROM usuaris ORDER BY id DESC LIMIT 1");

        if ($result) {

            $row = mysqli_fetch_assoc($result);
            $userId = $row['id'];
            
            logEventAdmin($message, $userId);
        } else {
            throw new \RuntimeException("Error a l'obtenir ID de l'usuari.");
        }
    }

?>
