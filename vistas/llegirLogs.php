<?php
/**
 * Arxiu llegirLogs.php
 *
 * Aquest arxiu conté una taula que mostra les dades recollides a 'logs/useraccess_log.txt'
 * Mostra una taula amb les accions que han realitzat els usuaris de l'aplicació, tant per 
 * part del propi l'Administrador com les realitzades per  la resta d'usuaris. 
 *
 * @category   Vistes
 * @package    useraccess
 * @author     Isabel Léon
 */ 

session_start();?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/admin.css" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css" />
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

</head>

<body>
    <!-- NavBar Administrador -->
    <?php include '../includes/adminNavBar.php'; ?>

    <?php
    //Llegeix el contingut de l'arxiu de registre dels logs
    $arxiu = file_get_contents("../logs/useraccess_log.txt");

    //Imprimeix la taula
    echo '<div class="card-body">';
    echo '<div class="table-responsive-sm">';
    echo '<table id="tableID" class="table table-hover">';
    echo '<thead class="thead-dark">';
    echo '<tr class="table-primary">';
    echo '<th scope="col">Data</th>';
    echo '<th scope="col">Hora</th>';
    echo '<th scope="col">Usuari</th>';
    echo '<th scope="col">Acció</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    //Defineix l'expressió regular per buscar la data, usuari i el missatge a cada línia
    $pattern = '/(\d{2}-\d{2}-\d{4}) (\d{2}:\d{2}:\d{2}) - ([^:]+): (.+)/';

    //Troba les coincidències al contingut de l'arxiu
    preg_match_all($pattern, $arxiu, $matches, PREG_SET_ORDER);

    //Itera cada coincidència
    foreach ($matches as $match) {
        //Imprimeix una fila de la taula amb les dades obtingudes
        echo "<tr>";
        echo "<td>{$match[1]}</td>"; // Data
        echo "<td>{$match[2]}</td>"; // Hora
        echo "<td>{$match[3]}</td>"; // Usuari
        echo "<td>{$match[4]}</td>"; // Missatge - Acció realitzada
        echo "</tr>";
    }

    //Fi de la taula
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
?>

