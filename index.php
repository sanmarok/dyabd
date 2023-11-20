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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestor de base de datos</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark" style="margin-left: 0;">
            <!-- Left navbar links -->
            <ul class=" navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">Inicio</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left: 0">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- TABLE: LATEST ORDERS - Primera Tabla -->
                                <div class="card card-primary">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title p-auto">Pedidos recientes</h3>
                                        <a href="agregar_pedido.php" class="btn btn-success float-right">

                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID Pedido</th>
                                                        <th>Direccion</th>
                                                        <th>Estado</th>
                                                        <th>Cliente</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Realizar la consulta
                                                    $query = "SELECT * FROM `Pedidos` ORDER BY `fecha_pedido` DESC";
                                                    $result = $conn->query($query);

                                                    // Verificar si hay resultados
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row['idPedido'] . "</td>";
                                                            echo "<td>" . $row['direccion'] . "</td>";
                                                            $estado = $row['estado'];
                                                            $colorBadge = '';

                                                            switch ($estado) {
                                                                case 'Pendiente':
                                                                    $colorBadge = 'badge-warning';
                                                                    break;
                                                                case 'En Proceso':
                                                                    $colorBadge = 'badge-info';
                                                                    break;
                                                                case 'Entregado':
                                                                    $colorBadge = 'badge-success';
                                                                    break;
                                                                default:
                                                                    $colorBadge = 'badge-secondary';
                                                                    break;
                                                            }

                                                            echo "<td><span class='badge $colorBadge'>$estado</span></td>";

                                                            echo '<td class="text-center"><a href="perfil_cliente.php?id=' . $row['idCliente'] . '" class="mx-2"><i class="fas fa-eye text-success"></i></a>' . "</td>";
                                                            echo "<td class='text-center'>
                                                            <a href='perfil_pedido?id=" . $row['idPedido'] . "'><button class='btn btn-info mr-2'><i class='fas fa-search'></i></button></a>
                                                            <a href='editar_pedido?id=" . $row['idPedido'] . "'><button class='btn btn-danger mr-2'><i class='fas fa-edit'></i></button></a>
                                                            </td>";
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-6">
                                <!-- TABLE: LATEST ORDERS - Segunda Tabla -->
                                <div class="card card-primary">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title p-auto">Clientes</h3>
                                        <a href="agregar_cliente.php" class="btn btn-success float-right">

                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div>
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID Cliente</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                        <th>DNI</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Realizar la consulta a la tabla de Clientes
                                                    $queryClientes = "SELECT idCliente, nombres, apellidos, dni FROM Clientes";
                                                    $resultClientes = $conn->query($queryClientes);

                                                    // Verificar si hay resultados
                                                    if ($resultClientes->num_rows > 0) {
                                                        while ($rowClientes = $resultClientes->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $rowClientes['idCliente'] . "</td>";
                                                            echo "<td>" . $rowClientes['nombres'] . "</td>";
                                                            echo "<td>" . $rowClientes['apellidos'] . "</td>";
                                                            echo "<td>" . $rowClientes['dni'] . "</td>";
                                                            echo "<td class='text-center'>
                                                            <a href='perfil_cliente?id=" . $rowClientes['idCliente'] . "'><button class='btn btn-info mr-2'><i class='fas fa-search'></i></button></a>
                                                            <a href='editar_cliente?id=" . $rowClientes['idCliente'] . "'><button class='btn btn-danger mr-2'><i class='fas fa-edit'></i></button></a>
                                                            </td>";
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "No se encontraron resultados en la tabla de Clientes.";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table

                                        </div>
                                        <!-table-responsive -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                        </div>
                    </div><!--/. container-fluid -->
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
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->

    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>