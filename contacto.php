<?php include "shared/header.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $email = $_POST['email'] ?? '';
    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    
    if (!empty($nombre) && !empty($apellidos) && !empty($email) && !empty($mensaje)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'parqueaderogalletasegura@gmail.com';
            $mail->Password = 'dcdl kbav slah rywh'; // Usa una contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            $mail->setFrom($email, $nombre . ' ' . $apellidos);
            $mail->addAddress('parqueaderogalletasegura@gmail.com');
            $mail->Subject = "Nuevo mensaje de contacto: $asunto";
            $mail->Body = "Nombre: $nombre $apellidos\nEmail: $email\nAsunto: $asunto\nMensaje: $mensaje";
            
            $mail->send();
            $success = true;
        } catch (Exception $e) {
            $error = "Error al enviar el correo: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<main class="container my-5">
    <h1 class="text-center mb-4">Contacto</h1>
    <div class="row g-4">
        <div class="col-md-6">
            <form class="bg-light p-4 rounded shadow" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombres</label>
                    <input name="nombre" class="form-control" id="nombres" placeholder="Ingresa tu nombre" required>
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input name="apellidos" class="form-control" id="apellidos" placeholder="Ingresa tus apellidos"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com"
                        required>
                </div>
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto</label>
                    <select name="asunto" id="asunto" class="form-select">
                        <option selected>Opciones de Servicio al Cliente</option>
                        <option value="Reclamo">Reclamo</option>
                        <option value="Consulta">Consulta</option>
                        <option value="Creacion cuenta">Creación de cuenta</option>
                    </select>
                </div>
                <div id="notificacion" class="alert alert-info mt-3 d-none">
                    <strong>Para crear una cuenta, complete los siguientes campos:</strong>
                    <ul>
                        <li>Nombres</li>
                        <li>Primer Apellido</li>
                        <li>Segundo Apellido (Opcional)</li>
                        <li>Correo</li>
                        <li>Tipo de Vehículo</li>
                        <li>Placa del Vehículo</li>
                        <li>Teléfono</li>
                    </ul> 
                </div>
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea name="mensaje" class="form-control" id="mensaje" rows="4"
                        placeholder="Escribe tu mensaje aquí" required></textarea>
                </div>
                <div class="mb-3">
                    <input type="submit" value="Enviar" class="btn btn-primary w-100 py-2">
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <address class="bg-light p-4 rounded shadow">
                <h2 class="mb-3"><strong>La Galleta Segura</strong></h2>
                <p><i class="fa-solid fa-location-dot me-2"></i> Guadalupe, Enfrente a AutoMercado Guadalupe. San José,
                    Costa Rica</p>
                <p><i class="fa-solid fa-phone me-2"></i> <a href="tel:+50626612301"
                        class="text-decoration-none">2661-2301</a></p>
                <p><i class="fa-brands fa-whatsapp me-2"></i> <a target="_blank"
                        href="https://wa.me/+50688885555?text=Hola,%20estoy%20interesado%20"
                        class="text-decoration-none">8888-5555</a></p>
                <p><i class="fa-solid fa-envelope me-2"></i> <a href="mailto:galletaS@gmail.com"
                        class="text-decoration-none">galletaS@gmail.com</a></p>
            </address>
        </div>
    </div>
</main>

<?php if ($success): ?>
<!-- Modal de éxito -->
<div class="modal fade show" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true"
    style="display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Formulario enviado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¡Tu mensaje ha sido enviado correctamente!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
});
</script>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#asunto").change(function() {
        if ($(this).val() === "Creacion cuenta") {
            $("#notificacion").removeClass("d-none");
        } else {
            $("#notificacion").addClass("d-none");
        }
    });
});
</script>

<?php include "shared/footer.php"; ?>