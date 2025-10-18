<!-- Config file for mail -->
<?php 

use PHPMailer\PHPMailer\PHPMailer;

require ('mail/phpmailer/src/Exception.php');
require ('mail/phpmailer/src/PHPMailer.php');
require ('mail/phpmailer/src/SMTP.php');

    if(isset($_POST['submit']))
    {
        // Obtiene los valores de los campos del formulario
        $email = $_POST['correo'];       // Correo electrónico del destinatario
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        //$archivo = $_POST['archivo'];
        //init data
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Username = "ap18018@ues.edu.sv"; // Replace with your mail id
        $mail->Password = "szol zoxn doql wfss"; //Replace with your mail pass
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
        $mail->SMTPAutoTLS = false;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   

        //Recipients
        $mail->setFrom('ap18018@ues.edu.sv', 'MecanicaExpert Form');
        $mail->addAddress($email, 'MECANICA EXPERT | Taller Mecanico');      // Add a recipient
        $mail->addReplyTo('ap18018@ues.edu.sv', 'MECANICA EXPERT');  //add replay to email

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message . '</b>';

        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
            $mail->addAttachment($_FILES['archivo']['tmp_name'], $_FILES['archivo']['name']);
        }

        //Info Message
        if (!$mail->send()) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
            echo '<p id="res">'.$error.'</p>';
        }
        else {
            echo '<p id="res">Gracias Por Esperar! El correo se ha enviado con exito.✅ </p>';
        }
    }
    else{
        echo '<p id="res">Por favor Ingresa datos correctos!. </p>';
    }
?>