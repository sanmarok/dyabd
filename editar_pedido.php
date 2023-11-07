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

// Inicializar variables
$estado = $direccion = $detalle = "";
$pedidoId = isset($_GET['id']) ? $_GET['id'] : '';

// Obtener datos del pedido si el ID es válido
if ($pedidoId) {
    $stmt = $conn->prepare("SELECT * FROM Pedidos WHERE idPedido = ?");
    $stmt->bind_param("i", $pedidoId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $direccion = $row['direccion'];
        $estado = $row['estado'];
        $detalle = $row['detalle'];
    } else {
        echo "Pedido no encontrado.";
    }
    $stmt->close();
}

// Procesar datos del formulario al recibirlos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];
    $detalle = $_POST['detalle'];

    $stmt = $conn->prepare("UPDATE Pedidos SET direccion = ?, estado = ?, detalle = ? WHERE idPedido = ?");
    $stmt->bind_param("sssi", $direccion, $estado, $detalle, $pedidoId);
    if ($stmt->execute()) {
        echo "Pedido actualizado con éxito.";
        // header("Location: lista_pedidos.php"); // Descomentar para redireccionar
    } else {
        echo "Error al actualizar el pedido.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Editar Pedido</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="editar_pedido.php?id=<?php echo $pedidoId; ?>">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo htmlspecialchars($direccion); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="detalle">Detalle</label>
                                <input type="text" class="form-control" name="detalle" id="detalle" value="<?php echo htmlspecialchars($detalle); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" name="estado" id="estado" required>
                                    <option value="Pendiente" <?php echo $estado == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="Enviado" <?php echo $estado == 'Enviado' ? 'selected' : ''; ?>>Enviado</option>
                                    <option value="Entregado" <?php echo $estado == 'Entregado' ? 'selected' : ''; ?>>Entregado</option>
                                </select>
                            </div>
                            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Pedido</button>
                        </form>
                        <!-- Botón para eliminar pedido -->
                        <form method="post" action="borrar_pedido.php">
                            <input type="hidden" name="idPedido" value="<?php echo $pedidoId; ?>">
                            <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('¿Estás seguro de que quieres borrar este pedido?');">Borrar Pedido</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
