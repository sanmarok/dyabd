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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Cliente</title>

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
              <h1>Editar Cliente</h1>
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
                  <h3 class="card-title">Actualizar Cliente</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="editar_cliente.php?id=<?php echo $clientId; ?>">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nombres">Nombre</label>
                      <input type="text" class="form-control" id="nombres" name="nombres"
                        value="<?php echo htmlspecialchars($nombre); ?>" placeholder="Ingrese el nombre" required>
                    </div>
                    <div class="form-group">
                      <label for="apellidos">Apellido</label>
                      <input type="text" class="form-control" id="apellidos" name="apellidos"
                        value="<?php echo htmlspecialchars($apellido); ?>" placeholder="Ingrese el apellido" required>
                    </div>
                    <div class="form-group">
                      <label for="dni">DNI</label>
                      <input type="text" class="form-control" id="dni" name="dni"
                        value="<?php echo htmlspecialchars($dni); ?>" placeholder="Ingrese el DNI" required>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Cliente</button>
                  </div>
                </form>
                <!-- Formulario para borrar cliente -->
                <form method="post" action="borrar_cliente.php">
                  <input type="hidden" name="idCliente" value="<?php echo $clientId; ?>">
                  <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('¿Estás seguro de que quieres borrar este cliente?');">Borrar Cliente</button>
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
