<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validar que el email sea de Gmail u Outlook
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@(gmail|outlook)\.com$/", $email)) {
        die("<div class='alert alert-danger'>Correo inválido. Solo se permiten cuentas Gmail u Outlook.</div>");
    }

    // Generar una nueva contraseña aleatoria
    $nueva_contraseña = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

    // Conectar con la base de datos
    $conexion = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");
    if ($conexion->connect_error) {
        die("<div class='alert alert-danger'>Error de conexión a la base de datos.</div>");
    }

    // Verificar si el correo existe en la base de datos
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Actualizar la contraseña en la base de datos
        $hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE usuarios SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Enviar el correo
        $mail = new PHPMailer(true);
        try {
            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'parqueaderogalletasegura@gmail.com'; // Tu correo
            $mail->Password = 'dcdl kbav slah rywh'; // Tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configurar destinatario y contenido
            $mail->setFrom('tuemail@gmail.com', 'Soporte Parqueadero');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body = "<p>Hola,</p>
                           <p>Tu nueva contraseña es: <strong>$nueva_contraseña</strong></p>
                           <p>Te recomendamos cambiarla después de iniciar sesión.</p>";

            if ($mail->send()) {
                echo "<div class='alert alert-success'>Se ha enviado un correo con tu nueva contraseña.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al enviar el correo.</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>El correo ingresado no está registrado.</div>";
    }

    $stmt->close();
    $conexion->close();
}
?>
