<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header('Location: ../../login.php');
    exit();
}

$views = "../";
include ("$views../actions/conexion.php");

$title = "Mis Solicitudes";
include ("../../includes/header.php");

// Preparar la consulta
$query = mysqli_prepare($con, "SELECT id, solicitud, folio, usuario, cliente, promocion, nocasting, noreal, puesto, descpuesto, escolaridad, nodias, dias, horarios, edad, sexo, zonas, tiendas, experiencia, fechacasting, fyhcasting, lugarcasting, fingreso, bono, coordinacion, sueldo, tdias FROM reqpersonal WHERE usuario = ?");
mysqli_stmt_bind_param($query, "s", $_SESSION['nombre_gmt']);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
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
                        <div class="card-header">
                            <h4 class="card-title">Solicitudes de <?php echo htmlspecialchars($_SESSION['nombre_gmt']); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Solicitud</th>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Promoción</th>
                                            <th>Puesto</th>
                                            <th>Fecha Casting</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['solicitud']); ?></td>
                                                <td><?php echo htmlspecialchars($row['folio']); ?></td>
                                                <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                                                <td><?php echo htmlspecialchars($row['promocion']); ?></td>
                                                <td><?php echo htmlspecialchars($row['puesto']); ?></td>
                                                <td><?php echo htmlspecialchars($row['fechacasting']); ?></td>
                                                <td>
                                                    <a href="ver_solicitud.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Ver</a>
                                                    <a href="editar_solicitud.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
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
</div>

<?php include ("../../includes/scripts.php"); ?>

</body>
</html>