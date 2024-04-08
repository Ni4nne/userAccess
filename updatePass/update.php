<?php
/**
 * Arxiu update.php
 *
 * Conté el formulari perque l'usuari pugui actualitzar la seva contrasenya.
 *
 * @category   Vistes
 * @package    useraccess
 * @author     Isabel Léon
 */

 if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email_usuari = $_GET['email'];
 }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title> Actualitzar contrasenya </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <div id="update" class="update">
        <h3> Actualitzar contrasenya </h3>

        <!-- Resposta que arriba de update.js -->
        <div id="response"></div> 

        <!-- FORMULARI -->
        <form id="updateForm">


            <!-- Camps ocults del formulari -->
            <input type="hidden" value="<?= $email_usuari; ?>" name="email" id="email">
            <input type="hidden" value="<?= $token; ?>" name="token" id="token">

            <div class="row mb-4">
                <label for="password" class="col-sm-2 col-form-label"> Nova Password</label>
                <div class="col-sm-10">
                    <input type="password" name="nova_pass" class="form-control" id="nova_pass" aria-label="passHelp" required>
            </div>
            <div class="passHelp text-center" id="passHelp">
                    La contrasenya ha de tenir entre 8 i 16 caracters, contenir lletres, números i caracters especials.
            </div>

                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary">Actualitzar</button>
                </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="update.js"></script>
</body>

</html>