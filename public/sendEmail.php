<?php
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: https://matiastagliero.com");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        echo json_encode(["success" => false, "error" => "Faltan campos requeridos."]);
        exit;
    }
    $name     = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $lastName = isset($_POST['lastName']) ? htmlspecialchars(trim($_POST['lastName']), ENT_QUOTES, 'UTF-8') : '';
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $tel      = isset($_POST['tel']) ? htmlspecialchars(trim($_POST['tel']), ENT_QUOTES, 'UTF-8') : 'No especificado';
    $message  = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "error" => "Email inválido."]);
        exit;
    }
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["success" => false, "error" => "Los campos nombre, email y mensaje son obligatorios."]);
        exit;
    }
    $fullName = $lastName ? $name . ' ' . $lastName : $name;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hola@matiastagliero.com';
        $mail->Password   = 'COMPLETAR_PASSWORD_AQUI';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('hola@matiastagliero.com', 'Web Matías Tagliero');
        $mail->addAddress('hola@matiastagliero.com');
        $mail->addReplyTo($email, $fullName);

        $mail->Subject = "Nuevo mensaje de contacto - " . $fullName;
        $mail->Body    = "Has recibido un nuevo mensaje de contacto:\n\n"
                       . "Nombre: " . $fullName . "\n"
                       . "Email: " . $email . "\n"
                       . "Teléfono: " . $tel . "\n\n"
                       . "Mensaje:\n" . $message . "\n";

        $mail->send();
        echo json_encode(["success" => true, "message" => "Mensaje enviado correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "No se pudo enviar: " . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido."]);
}
?>