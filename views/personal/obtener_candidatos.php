<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(isset($_SESSION['login_gmt']))
{
    include("../../actions/conexion.php");
    
    $registros_por_pagina = 20;
    $pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
    $offset = ($pagina_actual - 1) * $registros_por_pagina;

    // Recrear la lógica de filtros
    $query_claves = $_SESSION["clave_gmt"]; // Asumiendo que esto está disponible en la sesión
    $condicion_claves = "";
    $condicion_fechas = "";

    if(isset($_GET['filtro']) && $_GET['filtro'] == 'true') {
        if(!empty($_GET['codsel'])) {
            $claves_texto = implode(",", $_GET['codsel']);
            $condicion_claves = " AND clave_ejecutivo IN ('".$claves_texto."')";
        }
        
        if(!empty($_GET['date1']) && !empty($_GET['date2'])){
            $condicion_fechas = " AND fechaAlta BETWEEN '".$_GET['date1']."' AND DATE_ADD('".$_GET['date2']."', INTERVAL 1 DAY) ";
        }
    }

    $query = "SELECT usuarios.*, codigos_clientes.cliente, codigos_clientes.perfil 
              FROM usuarios 
              LEFT JOIN codigos_clientes ON SUBSTRING(usuarios.clave_ejecutivo, 1, 3) = codigos_clientes.codigo
              WHERE autorizado IS NULL 
              AND clave_ejecutivo IN ('".$query_claves."') 
              $condicion_claves $condicion_fechas 
              ORDER BY fechaAlta DESC 
              LIMIT $offset, $registros_por_pagina";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($con));
    }

    while ($fila = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>".strtoupper($fila['nombre']." ".$fila['app']." ".$fila['apm'])."</td>
            <td>".$fila["telefono"]."</td>
            <td>".$fila["curp"]."</td>
            <td>".$fila["fechaAlta"]."</td>
            <td>".$fila["cliente"]."</td>
            <td>".$fila["perfil"]."</td>
            <td>
                <a href='perfil.php?id=".$fila['id']."&curp=".$fila['curp']."&vista=candidatos'><i class='las la-pen text-secondary font-16'></i></a>
            </td>
        </tr>";
    }
} else {
    echo "No autorizado";
}
?>