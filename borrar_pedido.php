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

// Verifica si se ha enviado el ID del pedido mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idPedido'])) {
    $pedidoId = $_POST['idPedido'];

    // Preparar la sentencia SQL para borrar el pedido
    $stmt = $conn->prepare("DELETE FROM Pedidos WHERE idPedido = ?");
    $stmt->bind_param("i", $pedidoId); // 'i' indica que la variable es de tipo entero

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Pedido eliminado con éxito.";
    
    } else {
        echo "Error al eliminar el pedido: " . $conn->error;
    }

    // Cerrar la sentencia preparada
    $stmt->close();
} else {
    echo "Error: No se ha proporcionado un ID de pedido válido.";
}

// Cerrar conexión
$conn->close();
?>
