<?php
/**
 * Arxiu reset.php
 *
 * Conté el formulari perque els usuaris puguin sol.licitar l'enllaç
 * per restablir la seva contrasenya.
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
    <title> Restablir contrasenya </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/reset.css" />
    
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <div id="reset" class="reset">
        <h3> Restablir contrasenya </h3>

        <!-- Resposta que arriba de reset.js -->
        <div id="response"></div> 

        <!-- FORMULARI -->
        <form id="resetForm">
        <div class="row mb-2">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Recuperar</button>
            </div>
        </form>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="reset.js"></script>
</body>

</html>