<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header('Location: ../../login.php');
    exit();
}

$views = "../";
include ("$views../actions/conexion.php");

// Obtener las claves del ejecutivo actual
$query = $con->prepare("
    SELECT cc.codigo, cc.cliente, cc.perfil, cr.nombre as nombre_ejecutivo
    FROM codigos_clientes cc
    INNER JOIN credenciales cr ON FIND_IN_SET(cc.codigo, cr.clave)
    WHERE cr.ejecutivo = ?
    ORDER BY cc.codigo
");
$query->bind_param("i", $_SESSION['id_gmt']);
$query->execute();
$result = $query->get_result();

$title = "Mis Claves de Cliente-Proyecto";
include ("../../includes/header.php");
?>

<div class="page-wrapper">
    <div class="page-content-tab">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title"><?php echo $title; ?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="datatable_1">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Ejecutivo</th>
                                    <th>Perfil</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['codigo']); ?></td>
                                        <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombre_ejecutivo']); ?></td>
                                        <td><?php echo htmlspecialchars($row['perfil']); ?></td>
                                        <td>
                                            <a href="editar_ccp.php?codigo=<?php echo $row['codigo']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <a href="ver_detalles_ccp.php?codigo=<?php echo $row['codigo']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver detalles
                                            </a>
                                            <a href="https://wa.me/?text=<?php echo urlencode('Código de Cliente-Proyecto: ' . $row['codigo']); ?>" target="_blank" class="btn btn-sm btn-success">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include ("../../includes/footer.php"); ?>
</div>

<?php include ("../../includes/scripts.php"); ?>

<script>
$(document).ready(function() {
    $('#datatable_1').DataTable({
        "pageLength": 10,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "responsive": true,
        "order": [[ 0, "asc" ]],
        "dom": '<"top"lf>rt<"bottom"ip><"clear">'
    });
});
</script>

</body>
</html>