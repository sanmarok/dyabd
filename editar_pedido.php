<?php
// conexion
$servername = "localhost";
$username = "dbadmin";
$password = ".admindb";
$database = "grupo1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// testeo conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$estado = $direccion = $detalle =  "";
$pedidoId = isset($_GET['id']) ? $_GET['id'] : '';

// Obtener datos del pedido por idd
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];
    $detalle = $_POST['detalle'];

    $stmt = $conn->prepare("UPDATE Pedidos SET direccion = ?, estado = ?, detalle = ? WHERE idPedido = ?");  #preparas para actualizar estos datos de la table
    $stmt->bind_param("sssi", $direccion, $estado, $detalle, $pedidoId);   #numero de variables llamadas 3 string y 1 integer (s s s i)
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
                                    <!-- Añade más estados según sea necesario -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
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
