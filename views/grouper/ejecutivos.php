<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header('Location: ../../login.php');
    exit();
}

$views = "../";
include ("$views../actions/conexion.php");

$query_ejecutivos = mysqli_prepare($con, "SELECT * FROM credenciales WHERE ejecutivo = ? AND tipo != 'GROUPER'");
mysqli_stmt_bind_param($query_ejecutivos, "i", $_SESSION['id_gmt']);
mysqli_stmt_execute($query_ejecutivos);
$result = mysqli_stmt_get_result($query_ejecutivos);

$title = "Ejecutivos";
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
                <?php while ($fila = mysqli_fetch_array($result)): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card ejecutivo-card">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column">
                                    <h5 class="m-0"><?php echo htmlspecialchars($fila['nombre']); ?></h5>
                                    <p class="mb-1 text-muted"><?php echo htmlspecialchars($fila['rol'])," ",  htmlspecialchars($fila['tipo']); ?></p>
                                    <p class="mb-2 text-muted small">Usuario: <?php echo htmlspecialchars($fila['usuario']); ?></p>
                                    <div class="mt-auto">
                                        <a href="editar_ejecutivo.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-outline-primary me-1"><i class="las la-pen"></i> Editar</a>
                                        <a href="consultar_claves.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-outline-info"><i class="las la-search"></i> Claves</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <a href="add_user.php" class="btn btn-primary">Crear usuario</a>
                </div>
            </div>
        </div>
        
        <?php include ("../../includes/footer.php"); ?>
    </div>
</div>

<?php include ("../../includes/scripts.php"); ?>

</body>
</html>