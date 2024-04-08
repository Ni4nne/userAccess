<?php
/**
 * Arxiu index.php
 *
 * Aquest arxiu conté la vista inicial de l'aplicació amb el formulari
 * perque puguin accedir els usuaris registrats. 
 * Conté enllaços per registrar un nou usuari i per restablir la contrasenya
 *
 * @category   Vistes
 * @package    useraccess
 * @author     Isabel Léon
 */
 ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title> Accés Usuaris </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <div id="login" class="login">
        <h3> Accés Usuaris</h3>

        <!-- Resposta que arriba de login.js -->
        <div id="response"></div> 

        <!-- FORMULARI -->
        <form id="loginForm">
            <div class="row mb-4">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
            </div>

            <div class="row mb-4">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="password" aria-label="passHelp" required>
                </div>

                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>

                <div class="text-center mb-3">
                    <a href="resetPass/reset.php"> Has oblidat la teva contrasenya?</a><br>
                    <a href="registre/registre.php"> Crear nou compte</a>
                </div>

        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="login.js"></script>
</body>

</html>