<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "grupo1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Checar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST['idCliente'];

    // Eliminar primero todos los pedidos asociados al cliente
    $stmt = $conn->prepare("DELETE FROM pedidos WHERE idCliente = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $stmt->close();

    // Ahora intentar eliminar el cliente
    $stmt = $conn->prepare("DELETE FROM clientes WHERE idCliente = ?");
    $stmt->bind_param("i", $clientId);
    if ($stmt->execute()) {
        echo "Cliente eliminado con éxito.";
        // header("Location: lista_clientes.php"); // Redireccionar a la lista de clientes
    } else {
        echo "Error al eliminar el cliente.";
    }
    $stmt->close();
}

?>

