$(document).ready(function () {     //Funció que s'executa quan el document està completament carregat
    $('#updateForm').submit(function (e) { //Captura l'event d'enviament del formulari updateForm
        e.preventDefault();     //Evita la recàrrega de la página

        //Recull els valors introduïts al formulari update.php
        var email_usuari = $('#email').val();
        var token = $('#token').val();
        var nova_pass = $('#nova_pass').val();
        
        //Sol.licitud AJAX que enviarà les dades per processar-les a updateModel.php
        $.ajax({
            type: 'POST',            //Tipus de sol.licitud POST 
            url: 'updateModel.php',  //Arxiu que processa les dades
            data: { email: email_usuari, token: token, nova_pass: nova_pass },  //Dades que s'envien al servidor
            dataType: 'json',       //Tipus de dades que torna la resposta

            //Funció que s'executa si la resposta AJAX és correcta
            success: function (response) {

                //Si la resposta és correcta mostra alerta d'èxit
                if (response.status === 'success') {
                    $('#response').html('<p class="alert alert-success text-center" role="alert">' + response.message + '</p>');
                    
                    setTimeout(function() {
                        location.href = '../index.php';
                    }, 3000);
                
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
                console.log('Error solicitud AJAX en updateModel.php:', error);
            }
        });
    });
});