<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Mensaje de Contacto - Pequeñosaurios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media only screen and (max-width: 620px) {
            .container {
                width: 100% !important;
                padding: 20px !important;
            }

            .content {
                padding: 24px !important;
            }

            h1, h2 {
                font-size: 20px !important;
            }

            p, a {
                font-size: 16px !important;
            }

            .button {
                padding: 12px 20px !important;
                font-size: 16px !important;
                display: block !important;
                width: 100% !important;
            }

            .logo {
                height: 48px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #fef2f2; font-family: 'Segoe UI', sans-serif; color: #374151;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fef2f2; padding: 40px 0;">
        <tr>
            <td align="center">
                <table class="container" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 600px;">
                    <!-- Header / Logo -->
                    <tr>
                        <td align="center" style="background-color: #f9a8d4; padding: 24px;">
                            <img class="logo" src="<?php echo e(asset('img/logo-pequeño.png')); ?>" alt="Pequeñosaurios Logo" style="height: 64px; margin-bottom: 8px;">
                            <h1 style="margin: 0; color: #fff; font-size: 24px;">Pequeñosaurios</h1>
                        </td>
                    </tr>

                    <!-- Cuerpo del mensaje -->
                    <tr>
                        <td class="content" style="padding: 32px;">
                            <h2 style="color: #be185d; margin-bottom: 16px;">Nuevo mensaje de contacto recibido</h2>
                            <p style="margin: 0 0 16px 0; font-size: 16px; line-height: 1.5;">
                                <strong>Nombre:</strong> <?php echo e($name ?? 'No proporcionado'); ?>

                            </p>
                            <p style="margin: 0 0 16px 0; font-size: 16px; line-height: 1.5;">
                                <strong>Email:</strong> <?php echo e($email ?? 'No proporcionado'); ?>

                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 16px; line-height: 1.5;">
                                <strong>Mensaje:</strong><br>
                                <?php echo e($messageContent ?? 'No hay mensaje'); ?>

                            </p>

                            <p style="font-size: 14px; color: #6b7280; margin-bottom: 0;">
                                Este mensaje fue enviado desde el formulario de contacto de <strong>Pequeñosaurios</strong>.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; text-align: center; padding: 24px; font-size: 12px; color: #9ca3af;">
                            &copy; <?php echo e(date('Y')); ?> Pequeñosaurios. Todos los derechos reservados.<br>
                            <a href="<?php echo e(url('/')); ?>" style="color: #f472b6; text-decoration: none;">www.Pequeñosaurios.com</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/emails/message.blade.php ENDPATH**/ ?>