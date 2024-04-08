$(document).ready(function () {     //Funció que s'executa quan el document està completament carregat
    $('#regForm').submit(function (e) {     //Captura l'event d'enviament del formulari regForm
        e.preventDefault();         //Evita la recàrrega de la página

        //Recull els valors introduïts al formulari registre.php
        var nom = $('#nom').val();
        var cognom = $('#cognom').val();
        var email = $('#email').val();
        var password = $('#password').val();

        //Sol.licitud AJAX que envia les dades per processar-les a regModel.php
        $.ajax({
            type: 'POST',           //Tipus de sol.licitud POST
            url: 'regModel.php',    //Arxiu que processa les dades
            data: { nom: nom, cognom: cognom, email: email, password: password },   //Dades que s'envien al servidor
            dataType: 'json',       //Tipus de dades que torna la resposta

            //Funció que s'executa si la resposta AJAX és correcta
            success: function (response) {

                //Si la resposta és correcta dirigeix l'usuari a vistas/home.php
                if (response.status === 'success') {
                    location.href = location.origin + '/userAccess/vistas/home.php';

                //Si la resposta és incorrecta, mostra alerta d'error
                } else {
                    $('#response').html('<p class="alert alert-danger text-center" role="alert">' + response.message + '</p>');
                    
                    setTimeout(function() {     //El missatge es mostra 3 segons i després s'esborra
                        $('#response').empty();
                    }, 3000);
                }
            },

            //Funció que s'executa en cas d'error amb la sol.licitud AJAX
            error: function (error) {
                console.log('Error sol.licitud AJAX en regModel.php:', error);
            }
        });
    });
});
