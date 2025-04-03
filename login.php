<?php
session_start();

// Variable para mostrar mensajes de error
$error = "";

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validar que el email sea de Gmail u Outlook
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@(gmail|outlook)\.com$/", $email)) {
        $error = "Correo inválido. Solo se permiten cuentas Gmail u Outlook.";
    } else {
        // Aquí puedes agregar lógica para enviar un correo de recuperación (no implementado)
        $error = "Si el correo está registrado, se enviará un enlace para restablecer la contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css"> <!-- Tu archivo CSS personalizado -->
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
                                    <div class="text-center">
                                        <img src="img/Logo.png" style="width: 185px;" alt="logo">
                                    </div>

                                    <!-- FORMULARIO DE LOGIN -->
                                    <form action="" method="POST">
                                        <p>Ingrese su correo electrónico</p>
                                        <div class="form-outline mb-2">
                                            <input type="email" name="email" class="form-control" placeholder="Email"
                                                required />
                                        </div>

                                        <p>Contraseña</p>
                                        <div class="form-outline mb-2">
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Digite su contraseña" required />
                                        </div>

                                        <div class="text-center pt-1 mb-3 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg mb-3" type="submit">
                                                Ingresar
                                            </button>
                                            <a class="text-muted d-block" href="#" data-bs-toggle="modal"
                                                data-bs-target="#recuperarModal">¿Olvidaste tu contraseña?</a>
                                            <a class="text-muted d-block" href="index.php" ">Volver al sito Principal</a>

                                        </div>
                                    </form>

                                    <!-- MENSAJE DE ERROR -->
                                    <?php if (!empty($error)): ?>
                                    <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?>
                                    </p>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Bienvenido a nuestro sistema de parqueadero</h4>
                                    <p class="small mb-0">Accede de manera segura con tu cuenta y aprovecha todas las
                                        funcionalidades.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de recuperación de contraseña -->
    <div class="modal fade" id="recuperarModal" tabindex="-1" aria-labelledby="recuperarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recuperarModalLabel">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="recuperarForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Ingresa tu correo electrónico" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Recuperar Contraseña</button>
                        </div>
                    </form>
                    <div id="mensajeRecuperacion" class="mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para manejar el envío por AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#recuperarForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "recuperar.php",
                data: $(this).serialize(),
                success: function(response) {
                    $("#mensajeRecuperacion").html(response);
                }
            });
        });
    });
    </script>


    <!-- Scripts de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>