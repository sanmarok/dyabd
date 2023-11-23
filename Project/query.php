<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "localhost";
    $username = "dbadmin";
    $password = ".admindb";
    $database = "grupo1";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión a la base de datos fallida: " . $conn->connect_error);
    }

    // Obtener el query pasado por POST
    $postData = json_decode(file_get_contents('php://input'), true);
    $query = isset($postData['query']) ? $postData['query'] : "";

    // Ejecutar el query
    $result = $conn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "No se encontraron datos o hubo un error en el query.";
    }

    $conn->close();
} else {
    echo "Solicitud no válida. Debe ser una solicitud POST.";
}
