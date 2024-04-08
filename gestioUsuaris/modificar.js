$(document).ready(function () {             //Funció que s'executa quan el document està completament carregat
    $('#modForm').submit(function (e) {     //Captura l'event d'enviament del formulari modForm
        e.preventDefault();                 //Evita la recàrrega de la página

        //Recull els valors introduïts al formulari modificar.php
        var txtID = $('#txtID').val();      
        var nom = $('#nom').val();
        var cognom = $('#cognom').val();
        var email = $('#email').val();
        var nova_pass = $('#nova_password').val();
        var rol_id = $('#rol_id').val();
        var auto_restore = $('#auto_restore').val();

        //Sol.licitud AJAX que enviarà les dades per processar-les a modificarModel.php
        $.ajax({
            type: 'POST',               //Tipus de sol.licitud POST
            url: 'modificarModel.php',  //Arxiu que processa les dades
            data: { txtID: txtID, nom: nom, cognom: cognom, email: email, nova_pass: nova_pass, rol_id: rol_id, auto_restore: auto_restore },   //Dades que s'envien al servidor
            dataType: 'json',   //Tipus de dades que torna la resposta

            //Funció que s'executa si la resposta AJAX és correcta
            success: function (response) {
                
                //Si la resposta és correcta mostra alerta d'èxit
                if (response.status === 'success') {
                    $('#response').html('<p class="alert alert-success text-center" role="alert">' + response.message + '</p>');
                    
                    setTimeout(function() {
                        $('#response').empty();
                        //Anida temporitzador per redirigir despres d'esborrar el missatge
                        setTimeout(function() {
                            window.location.href = '../vistas/admin.php';
                        }, 0);  //S'executa despres d'esborrar el missatge
                    }, 3000);

                //Si la resposta és incorrecta, mostra alerta d'error
                } else {
                    $('#response').html('<p class="alert alert-danger text-center" role="alert">' + response.message + '</p>');
                    
                    setTimeout(function() {     //El missatge es mostra 3 segons i després s'esborra
                    location.reload();   
                    }, 3000);
                }
            },
            
            //Funció que s'executa en cas d'error amb la sol.licitud AJAX
            error: function (error) {
                console.log('Error sol.licitud AJAX en modificarModel.php:', error);
            }
        });
    });
});