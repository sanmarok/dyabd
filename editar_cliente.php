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
$nombre = $apellido = $dni = "";
$clientId = isset($_GET['id']) ? $_GET['id'] : '';  // Obtener el ID del cliente de la URL

// Obtener datos del cliente si el ID es válido
if ($clientId) {
    $stmt = $conn->prepare("SELECT * FROM Clientes WHERE idCliente = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombres'];
        $apellido = $row['apellidos'];
        $dni = $row['dni'];
    } else {
        echo "Cliente no encontrado.";
    }
    $stmt->close();
}

// Procesar datos del formulario al recibirlos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $dni = $_POST['dni'];

    // Actualizar datos del cliente
    $stmt = $conn->prepare("UPDATE Clientes SET nombres = ?, apellidos = ?, dni = ? WHERE idCliente = ?");
    $stmt->bind_param("sssi", $nombre, $apellido, $dni, $clientId);
    if ($stmt->execute()) {
        echo "Cliente actualizado con éxito.";
        // header("Location: lista_clientes.php"); // Descomentar para redireccionar
    } else {
        echo "Error al actualizar el cliente.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Editar Cliente</h3>
                    </div>
                    <div class="card-body">
                        <!-- Formulario para actualizar cliente -->
                        <form method="post" action="editar_cliente.php?id=<?php echo $clientId; ?>">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" name="nombres" id="nombres" value="<?php echo htmlspecialchars($nombre); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($apellido); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control" name="dni" id="dni" value="<?php echo htmlspecialchars($dni); ?>" required>
                            </div>
                            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Cliente</button>
                        </form>
                        <!-- Formulario para borrar cliente -->
                        <form method="post" action="borrar_cliente.php">
                            <input type="hidden" name="idCliente" value="<?php echo $clientId; ?>">
                            <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('¿Estás seguro de que quieres borrar este cliente?');">Borrar Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap
