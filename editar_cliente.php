<?php

// conexión 
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
$nombre = $apellido = $dni = "";
$clientId = isset($_GET['id']) ? $_GET['id'] : '';  #Agarra el ID del cliente de la URL

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
        // Manejar el error - Cliente no encontrado
        echo "Cliente no encontrado.";
    }
    $stmt->close();
}

// Procesar datos del formulario al recibirlos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanear entradas aquí
    $nombre = $_POST['nombres'];
    $apellido = $_POST['apellidos'];
    $dni = $_POST['dni'];

    // Actualizar datos del cliente
    $stmt = $conn->prepare("UPDATE Clientes SET nombres = ?, apellidos = ?, dni = ? WHERE idCliente = ?"); #preparas para llamar a las variables a actualizar en sql
    $stmt->bind_param("sssi", $nombre, $apellido, $dni, $clientId);   #aclaras cuantas son y quienes ( s s s i)
    if ($stmt->execute()) {
        // Redireccionar a la lista de clientes o mostrar mensaje de éxito
        echo "Cliente actualizado con éxito.";
        // header("Location: lista_clientes.php"); // Descomentar para redireccionar
    } else {
        // Manejar error en la actualización
        echo "Error al actualizar el cliente.";
    }
    $stmt->close();
}

// Cerrar conexión
$conn->close();
?>
                                                   <!---- VISTA ----->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <!-- Incluir CSS para Bootstrap, etc. -->
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
                        <!-- Inicio del formulario -->
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
                            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                        </form>
                        <!-- Fin del formulario -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
