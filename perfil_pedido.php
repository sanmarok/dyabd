<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "dbadmin";
$password = ".admindb";
$database = "grupo1";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión a la base de datos fallida: " . $conn->connect_error);
}

// Verifica si se proporcionó un ID de pedido válido
if (isset($_GET['id'])) {
    $pedido_id = $_GET['id'];

    // Realiza una consulta SQL para obtener los datos del pedido con el ID proporcionado
    $query = "SELECT * FROM Pedidos WHERE idPedido = ?";
    $stmt = $conn->prepare($query);
    
    // Vincula el parámetro
    $stmt->bind_param("i", $pedido_id);
    
    // Ejecuta la consulta
    $stmt->execute();
    
    // Obtiene el resultado
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se encontraron resultados, recuperar los datos del pedido
        $row = $result->fetch_assoc();
        $direccion_pedido = $row['direccion'];
        $fecha_pedido = $row['fecha_pedido'];
        $estado_pedido = $row['estado'];
        $detalle_pedido = $row['detalle'];
        $cliente_id = $row['idCliente'];
    } else {
        echo "No se encontraron resultados para el ID de pedido proporcionado.";
    }
} else {
    echo "No se proporcionó un ID de pedido válido.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestor de base de datos</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
      <ul class="navbar-nav">
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
              <h1>Datos del Pedido</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- Pedido data -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Información del Pedido</h3>
                </div>
                <div class="card-body">
                  <!-- Pedido data here -->
                  <div class="form-group">
                    <label for="direccion_pedido">Dirección</label>
                    <input type="text" class="form-control" id="direccion_pedido" value="<?php echo $direccion_pedido; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="fecha_pedido">Fecha de Pedido</label>
                    <input type="text" class="form-control" id="fecha_pedido" value="<?php echo $fecha_pedido; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="estado_pedido">Estado</label>
                    <input type="text" class="form-control" id="estado_pedido" value="<?php echo $estado_pedido; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="detalle_pedido">Detalle</label>
                    <input type="text" class="form-control" id="detalle_pedido" value="<?php echo $detalle_pedido; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="cliente_id">ID del Cliente</label>
                    <input type="text" class="form-control" id="cliente_id" value="<?php echo $cliente_id; ?>" disabled>
                  </div>

                  <!-- Resto de tu contenido HTML aquí -->

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

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
  <!-- bs-custom-file-input -->
  <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page specific script -->

</body>
</html>

