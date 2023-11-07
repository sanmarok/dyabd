<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$database = "grupo1";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Conexión a la base de datos fallida: " . $conn->connect_error);
}

$query = "SELECT * FROM clientes";
$clientes = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestor de base de datos</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark" style="margin-left: 0;">
      <!-- Left navbar links -->
      <ul class=" navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Inicio</a>
        </li>
      </ul>
    </nav>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <li class="nav-item">
        <a href="#" class="nav-link">
          <p>
          </p>
        </a>
    </nav>

    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agregar Pedido</h1>
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
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Nuevo Pedido</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="idCliente">Clientes</label>
                    <select class="form-control" name="idCliente" id="idCliente">
                      <option value="">Seleccione un cliente</option>
                      <?php while ($cliente = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $cliente['idCliente']; ?>">
                          <?php echo $cliente['nombres'] . "" . $cliente['apellidos'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="direccion_pedido">Direccion</label>
                    <input type="text" class="form-control" name="direccion_pedido" id="direccion_pedido"
                      placeholder="Ingrese la direccion del pedido">
                  </div>
                  <div class="form-group">
                    <label for="fecha_pedido">Fecha</label>
                    <input type="date" class="form-control" name="fecha_pedido" id="fecha_pedido"
                      placeholder="Ingrese la fecha">
                  </div>
                  <div class="form-group">
                    <label for="estado_pedido">Estado</label>
                    <select type="list" class="form-control" name="estado_pedido" id="estado_pedido"
                      placeholder="Ingrese el estado del pedido">
                      <option value="Pendiente">Pendiente</option>
                      <option value="En proceso">En proceso</option>
                      <option value="Entregado">Entregado</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="detalle_pedido">Detalle</label>
                    <input type="text" class="form-control" name="detalle_pedido" id="detalle_pedido" placeholder="">
                  </div>
                </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit" id='submit'>Agregar</button>
                </div>
                <?php
                if (isset($_POST['submit'])) {
                  $direccion_pedido = $_POST['direccion_pedido'];
                  $fecha_pedido = $_POST['fecha_pedido'];
                  $estado_pedido = $_POST['estado_pedido'];
                  $detalle_pedido = $_POST['detalle_pedido'];
                  $idCliente = $_POST['idCliente'];

                  $query = "INSERT INTO pedidos(direccion, fecha_pedido,estado,detalle,IdCliente) 
                  VALUES ('$direccion_pedido','$fecha_pedido','$estado_pedido','$detalle_pedido','$idCliente')";
                  $stmt = $conn->prepare($query);
                  if ($stmt->execute()) {
                    echo '<script>
                      Swal.fire({
                        title: "Exito!",
                        text: "Se agrego exitosamente el cliente.",
                        icon: "success"
                      });
                      window.location: 
                    </script>';
                  } else {
                    echo '<script>
                      Swal.fire({
                        title: "Error",
                        text: "Hubo un error al intentar agregar al cliente.",
                        icon: "error"
                      });
                      </script>';
                    header("Location: http://localhost/dyabd/index.php");
                  }
                  $stmt->close();
                  $conn->close();
                }
                ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
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