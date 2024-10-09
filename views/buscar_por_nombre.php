<?php
session_start();
if(isset($_SESSION['login_gmt'])) {
    include("../actions/conexion.php");

    if(isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $query = "SELECT * FROM usuarios WHERE CONCAT(nombre, ' ', app, ' ', apm) LIKE ? LIMIT 10";
        $stmt = $con->prepare($query);
        $nombre = "%$nombre%";
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            echo "<h5>Resultados de búsqueda por nombre:</h5>";
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>Nombre</th><th>CURP</th><th>Teléfono</th><th>Acciones</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nombre'] . ' ' . $row['app'] . ' ' . $row['apm']) . "</td>";
                echo "<td>" . htmlspecialchars($row['curp']) . "</td>";
                echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                echo "<td><a href='personal/perfil.php?id=" . $row['id'] . "&curp=" . $row['curp'] . "&vista=index' class='btn btn-sm btn-info'>Ver perfil</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }

        $stmt->close();
    }
} else {
    echo "Acceso no autorizado.";
}
?>