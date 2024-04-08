<?php
/**
 * Arxiu mailer.php
 *
 * Conté funcions i configuracions del servidor per l'enviament dels correus electrònics
 * i gestió de tokens per restablir la contrasenya de l'usuari.
 * 
 * @category   Gestió Usuaris
 * @package    useraccess
 * @author     Isabel Léon
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Genera un token per restablir la contrasenya.
 *
 * Genera un token únic utilitzant la funció `uniqid()` de PHP.
 * Aquest token s'utilitza per restablir la contrasenya de l'usuari.
 *
 * @return string   - Token generat.
 */
function generaToken(){
    return uniqid();
}

/**
 * Emmagatzema un token a la Base de Dades.
 *
 * Emmagatzema un token junt amb l'adreça de correu de l'usuari i la data d'expiració
 * a la taula `token` de la BBDD.
 *
 * @param mysqli $db            - Conexió a la BBDD utilizant MySQLi.
 * @param string $email_usuari  - Correu electrònic de l'usuari per associar amb el token.
 * @param string $token         - Token generat que s'emmagatzemará.
 * @return bool                 - True si el token s'emmagatzema correctament, False en cas d'error.
 */
function guardaToken($db, $email_usuari, $token) {

    $expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    $sql = "INSERT INTO token (email, token, expira) VALUES ('$email_usuari', '$token', '$expira')";
    $resultat = mysqli_query($db, $sql);

    if ($resultat) {
        return true; 
    } else {
        return false; 
    }
}


/**
 * Comproba si un token és vàlid.
 *
 * @param mysqli $db                - Conexió a la BBDD utilizant MySQLi.
 * @param  string $email_usuari     - Correu electrònic de l'usuari.
 * @param string $token             - Token per comprovar.
 * @return bool                     - Torna true si és vàlid. En cas contrari mostra un missatge d'error
 *                                  i finalitza l'execució del programa.
 */
function verificaToken($db, $email_usuari, $token){
    
    $token = mysqli_real_escape_string($db, $token);
    $email_usuari = mysqli_real_escape_string($db, $email_usuari);


    $sql = "SELECT id FROM token WHERE email = '$email_usuari' AND token = '$token' AND expira > NOW()";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'El token no és vàlid.']);
        die();
    }
}


/**
 * Funció que envia un correu electrònic quan l'usuari de l'aplicació sol·licita restablir la seva pròpia contrasenya.
 * 
 * @param  string $email_usuari     - Correu electrònic de l'usuari que sol·licita restabliment de la contrasenya.
 * @return void
 * @throws Exception     Excepció en cas d'error durant l'enviament del correu electrònic.
 */
function enviaMail($email_usuari, $token)
{
    try {

        $resetLink = "http://update.php?email=" . urlencode($email_usuari) . "&token=" . urlencode($token);

        $mail = new PHPMailer(true);

        //Configuració servidor SMTP
        $mail->isSMTP();                                          
        $mail->Host       = '';                     
        $mail->SMTPAuth   = '';                                 
        $mail->Username   = '';        
        $mail->Password   = '';                    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
        $mail->Port       = '';                                   

        //Destinatari
        $mail->addAddress($email_usuari); // Correu que arriba per $_POST

        //Codificació caracters
        $mail->CharSet = 'UTF-8';

        //Contingut del correu electrònic
        $mail->isHTML(true); //Establir format correu electrònic a HTML
        $mail->Subject = "Restablir contrasenya User Access";
        $mail->Body    = "Hem rebut una sol.licitud per restablir la seva contrasenya.<br>
                          Segueix el seguent link:  <a href='$resetLink'>$resetLink</a>";
                        
        $mail->AltBody = "Hem rebut una sol.licitud per restablir la seva contrasenya. Segueix el seguent link: ";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}

/**
 * Funció que envia un correu electrònic a l'usuari de l'aplicació per informar que la seva contrasenya ha sigut restablida 
 * per l'Administrador del sistema.
 *
 * @param  string $email    - Correu electrònic de l'usuari al que s'envia el missatge.
 * @return void
 * @throws Exception     Excepció en cas d'error durant l'enviament del correu electrònic.
 */
function enviaMailGestioUsuaris($email)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();                                          
        $mail->Host       = '';                     
        $mail->SMTPAuth   = '';                                 
        $mail->Username   = '';        
        $mail->Password   = '';                    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
        $mail->Port       = '';                                  

        //Destinatari
        $mail->addAddress($email); //Correu que arriba per $_POST

        //Codificació caracters
        $mail->CharSet = 'UTF-8';

        //Contingut del correu electrònic
        $mail->isHTML(true); //Establir format correu electrònic a HTML
        $mail->Subject = "Contrasenya restablida";
        $mail->Body    = "La seva contrasenya d'usuari ha sigut restablida.<br>
                          Si us plau, contacti amb l'Administrador per més informació.";
                        
        $mail->AltBody = "La seva contrasenya d'usuari ha sigut restablida. Si us plau, contacti amb l'Administrador per més informació.";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}