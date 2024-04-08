$(document).ready(function () {         //Funció que s'executa quan el document està completament carregat
    $('#regForm').submit(function (e) { //Captura l'event d'enviament del formulari regForm
        e.preventDefault();             //Evita la recàrrega de la página 

        //Recull els valors introduïts al formulari 'crear.php'
        var nom = $('#nom').val();
        var cognom = $('#cognom').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var rol_id = $('#rol_id').val();
        var auto_restore = $('#auto_restore').val();

        //Sol.licitud AJAX que enviarà les dades per processar-les a 'crearModel.php'
        $.ajax({
            type: 'POST',           //Tipus de sol.licitud POST
            url: 'crearModel.php',  //Arxiu que processa les dades
            data: { nom: nom, cognom: cognom, email: email, password: password, rol_id: rol_id, auto_restore: auto_restore }, //Dades que s'envien al servidor
            dataType: 'json',       //Tipus de dades que torna la resposta

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