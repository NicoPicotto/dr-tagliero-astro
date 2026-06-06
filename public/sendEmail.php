<?php
header("Access-Control-Allow-Origin: https://www.matiastagliero.com");
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

    $to      = "hola@matiastagliero.com";
    $subject = "Nuevo mensaje de contacto - " . $fullName;

    $body  = "Has recibido un nuevo mensaje de contacto:\n\n";
    $body .= "Nombre: " . $fullName . "\n";
    $body .= "Email: " . $email . "\n";
    $body .= "Teléfono: " . $tel . "\n\n";
    $body .= "Mensaje:\n" . $message . "\n";

    $headers  = "From: noreply@matiastagliero.com\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["success" => true, "message" => "Mensaje enviado correctamente."]);
    } else {
        echo json_encode(["success" => false, "error" => "No se pudo enviar el mensaje. Intentá nuevamente."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido."]);
}
?>
