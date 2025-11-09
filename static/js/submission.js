$(document).ready(function() {
    $("#submit").click(function(e) {
        e.preventDefault();
        
        var correo = $("#correo").val(); 
        var subject = $("#subject").val();
        var message = $("#message").val();
        var archivo = $("#archivo")[0].files[0];
        var button = $("#submit").val();
       // 2️⃣ Creamos el FormData (puedes agregar variables una por una)
    var formData = new FormData();
    formData.append("correo", correo);
    formData.append("subject", subject);
    formData.append("message", message);
    formData.append("archivo", archivo); // adjunto
    formData.append("submit", button);

        //validation 
        if (subject == '' || message == '') { //if you are use other form validation scripts remove the if statement 
            alert("Por Favor completa todos los campos requeridos.");
        }
        // AJAX Code To Submit Form.
        else {
            $('#loader').show();
            $.ajax({
                type: "POST",
                url: "send-mailer.php",
                data: formData,
                contentType: false,  // necesario para enviar archivos
                processData: false,  // necesario para enviar archivos
                cache: false,
                success: function(result) {
                    $('#loader').hide();
                    $('#response').html(result).fadeIn();
                    $("#contact_form")[0].reset();
                    $('#response').fadeOut(3000).delay(400);


                }
            });
        }
        return false;
    });
});