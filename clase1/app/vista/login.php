<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../modelo/conexion.php';

$datos = json_decode(file_get_contents("php://input"));

$correo = $datos->correoEmpleado;
$password = $datos->passwordEmpleado;

$consulta = $conexion->prepare("SELECT * FROM empleados WHERE correoEmpleado = ? AND passwordEmpleado = ?");
$consulta->bind_param("ss", $correo, $password);
$consulta->execute();
$resultado = $consulta->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $token = bin2hex(random_bytes(16));
    echo json_encode([
        "mensaje" => "Inicio de sesión exitoso",
        "token" => $token,
        "idEmpleado" => $fila["idEmpleado"],
        "nombreEmpleado" => $fila["nombreEmpleado"]
    ]);
} else {
    echo json_encode(["mensaje" => "Correo o contraseña incorrectos"]);
}
?>
