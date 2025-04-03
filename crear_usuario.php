<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
// Variable para mostrar mensajes de error
$error = "";
$success = false;

// Función para generar una contraseña aleatoria
define('LENGTH', 8);
function generarContrasena($length = LENGTH) {
    return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
}

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombres = $_POST['nombres'] ?? '';
    $primer_apellido = $_POST['primer_apellido'] ?? '';
    $segundo_apellido = $_POST['segundo_apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $tipo_vehiculo = $_POST['tipo_vehiculo'] ?? '';
    $placa = $_POST['placa'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    // Validar correo
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@(gmail|outlook)\\.com$/", $email)) {
        $error = "Correo inválido. Solo se permiten cuentas Gmail u Outlook.";
    } elseif (empty($nombres) || empty($primer_apellido) || empty($tipo_vehiculo) || empty($placa) || empty($telefono)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $password = generarContrasena();
        
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia esto según tu proveedor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'parqueaderogalletasegura@gmail.com'; // Tu correo
            $mail->Password = 'dcdl kbav slah rywh'; // Tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('arqueaderogalletasegura@gmail.com', 'Soporte');
            $mail->addAddress($email);
            $mail->Subject = 'Registro Exitoso';
            $mail->Body = "Hola $nombres,\n\nTu cuenta ha sido creada con éxito.\nTu contraseña es: $password\n\nPor favor, cambia tu contraseña después de iniciar sesión.";

            $mail->send();
            $success = true;
        } catch (Exception $e) {
            $error = "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/crear_usuario.css">
</head>
<body>
  <section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
                  <form action="" method="POST">
                    <p>Por favor, ingrese los siguientes datos:</p>
                    <div class="form-outline mb-2">
                      <input type="text" name="nombres" class="form-control" placeholder="Nombres" required>
                    </div>
                    <div class="form-outline mb-2">
                      <input type="text" name="primer_apellido" class="form-control" placeholder="Primer apellido" required>
                    </div>
                    <div class="form-outline mb-2">
                      <input type="text" name="segundo_apellido" class="form-control" placeholder="Segundo apellido">
                    </div>
                    <div class="form-outline mb-2">
                      <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                    </div>
                    <div class="form-outline mb-2">
                      <select name="tipo_vehiculo" class="form-select" required>
                        <option value="" disabled selected>Tipo de Vehículo</option>
                        <option value="Automóvil">Automóvil</option>
                        <option value="Moto">Moto</option>
                        <option value="Camioneta">Pesado</option>
                      </select>
                    </div>
                    <div class="form-outline mb-2">
                      <input type="text" name="placa" class="form-control" placeholder="Placa del Vehículo" required>
                    </div>
                    <div class="form-outline mb-2">
                      <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
                    </div>
                    <div class="text-center pt-1 mb-3 pb-1">
                      <button class="btn btn-primary btn-block fa-lg mb-3" type="submit">Crear Cuenta</button>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">¿Ya tienes una cuenta?</p>
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                      <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                    </div>
                  </form>
                  <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center">
                <div class="text-center px-3 py-4 p-md-5 mx-md-4">
                  <img src="img/Logo.png" class="img-fluid" alt="Logo" style="width: 100%; max-width: 400px;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>
    <div class="modal fade" id="correoEnviadoModal" tabindex="-1" aria-labelledby="correoEnviadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="correoEnviadoModalLabel">Correo Enviado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          Se ha enviado un correo electrónico con la contraseña de acceso al sistema.
        </div>
        <div class="modal-footer">
          <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <?php if ($success): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('correoEnviadoModal'));
        myModal.show();
      });
    </script>
  <?php endif; ?>

</body>
</html>
