<?php
/**
 * Arxiu registre.php
 *
 * Permet a l'usuari registrar-se a l'Aplicació. 
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
    <title> Registre d'usuaris </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/registre.css" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <!-- Resposta que arriba de registre.js -->
    <div id="response"></div>

    <!-- FORMULARI -->
    <div id="registre" class="registre">
        <h3> Registre Usuaris </h3>

        <form id="regForm">
            <div class="row mb-4">
                <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" name="nom" class="form-control" id="nom" required>
                </div>
            </div>

            <div class="row mb-4">
                <label for="cognom" class="col-sm-2 col-form-label">Cognom</label>
                <div class="col-sm-10">
                    <input type="text" name="cognom" class="form-control" id="cognom" required>
                </div>
            </div>

            <div class="row mb-4">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="password" aria-label="passHelp" required>
                </div>
                <div class="passHelp text-center" id="passHelp">
                    La contrasenya ha de tenir entre 8 i 16 caracters, contenir lletres, números i caracters especials.
                </div>
            </div>

            <div class="text-center mb-3">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>

            <div class="text-center">
                <a href="../index.php"> Log in</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="registre.js"></script>
</body>

</html>