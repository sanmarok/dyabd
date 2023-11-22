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
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->
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
              <h1>Agregar Cliente</h1>
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
                  <h3 class="card-title">Nuevo Cliente</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nombre_cliente">Nombre</label>
                      <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                        placeholder="Ingrese el nombre" required>
                    </div>
                    <div class="form-group">
                      <label for="apellido_cliente">Apellido</label>
                      <input type="text" class="form-control" id="apellido_cliente" name="apellido_cliente"
                        placeholder="Ingrese el apellido" required>
                    </div>
                    <div class="form-group">
                      <label for="dni_cliente">DNI</label>
                      <input type="number" class="form-control" id="dni_cliente" name="dni_cliente"
                        placeholder="Ingrese el DNI (sin puntos ni espacios)" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Telefono</label>
                      <input type="number" class="form-control" id="telefono_cliente" name="telefono_cliente"
                        placeholder="(Codigo de Area)Numero" required>
                    </div>
                    <div class="form-group">
                      <label for="email_cliente">Email</label>
                      <input type="email" class="form-control" id="email_cliente" name="email_cliente"
                        placeholder="Ingrese el email" required>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id='submit' name='submit'>Agregar</button>
                  </div>

                  <?php
                  if (isset($_POST['submit'])) {
                    $nombre_cliente = $_POST['nombre_cliente'];
                    $apellido_cliente = $_POST['apellido_cliente'];
                    $dni_cliente = $_POST['dni_cliente'];
                    $telefono_cliente = $_POST['telefono_cliente'];
                    $email_cliente = $_POST['email_cliente'];
                    $fecha_registro = date("Y-m-d");

                    $query = "INSERT INTO clientes(nombres,apellidos,dni,telefono,email,fecha_registro) 
                    VALUES ('$nombre_cliente','$apellido_cliente','$dni_cliente','$telefono_cliente','$email_cliente','$fecha_registro')";
                    $stmt = $conn->prepare($query);

                    if ($stmt->execute()) {
                      echo '<script>
                      Swal.fire({
                        title: "Exito!",
                        text: "Se agrego exitosamente el cliente.",
                        icon: "success"
                      });
                      </script>';
                    } else {
                      echo '<script>
                      Swal.fire({
                        title: "Error",
                        text: "Hubo un error al intentar agregar al cliente.",
                        icon: "error"
                        });
                      </script>';
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