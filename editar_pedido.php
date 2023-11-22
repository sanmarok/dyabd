<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "dbadmin";
$password = ".admindb";
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Pedido</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark" style="margin-left: 0;">
      <!-- Left navbar links -->
      <ul class=" navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Inicio</a>
        </li>
      </ul>
    </nav>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Editar Pedido</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center align-items-center" style="min-height: 65vh;">
        <!-- Use an inline style for margin-left -->
            <div class="col-md-6" style="margin-right: 280px;">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Actualizar Pedido</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="editar_pedido.php?id=<?php echo $pedidoId; ?>">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="direccion">Dirección</label>
                      <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="detalle">Detalle</label>
                      <input type="text" class="form-control" id="detalle" name="detalle" value="<?php echo htmlspecialchars($detalle); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="estado">Estado</label>
                      <select class="form-control" id="estado" name="estado" required>
                        <option value="Pendiente" <?php echo $estado == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="Enviado" <?php echo $estado == 'Enviado' ? 'selected' : ''; ?>>Enviado</option>
                        <option value="Entregado" <?php echo $estado == 'Entregado' ? 'selected' : ''; ?>>Entregado</option>
                      </select>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Pedido</button>
                  </div>
                </form>
                <!-- Botón para eliminar pedido -->
                <form method="post" action="borrar_pedido.php">
                  <input type="hidden" name="idPedido" value="<?php echo $pedidoId; ?>">
                  <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('¿Estás seguro de que quieres borrar este pedido?');">Borrar Pedido</button>
                </form>
              </div>
              <!-- /.card -->
            </div>
            <!--/.col (left) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
