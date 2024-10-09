<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    $views = "../";
    
    include ("$views../actions/conexion.php");
    
    // Obtener el ID del ejecutivo
    $id_ejecutivo = $_GET['id'];
    
    // Obtener los datos del ejecutivo
    $query_ejecutivo = mysqli_prepare($con, "SELECT * FROM credenciales WHERE id = ?");
    mysqli_stmt_bind_param($query_ejecutivo, "i", $id_ejecutivo);
    mysqli_stmt_execute($query_ejecutivo);
    $result = mysqli_stmt_get_result($query_ejecutivo);
    $ejecutivo = mysqli_fetch_array($result);
    mysqli_stmt_close($query_ejecutivo);
    
    // Obtener las claves del ejecutivo
    $claves = explode(",", $ejecutivo['clave']);
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Consultar Claves del Ejecutivo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

        <!-- App css -->
        <link href="<?php echo $views;?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body id="body">
        <!-- leftbar-tab-menu -->
        <?php include ("../../actions/leftbar.php");?>
        <!-- end leftbar-tab-menu-->

        <!-- Top Bar Start -->
        <!-- ... (código del top bar) ... -->

        <div class="page-wrapper">
            <div class="page-content-tab">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Claves del Ejecutivo: <?php echo htmlspecialchars($ejecutivo['nombre']); ?></h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Cliente</th>
                                                <th>Proyecto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($claves as $clave): 
                                                $clave = trim($clave);
                                                if(!empty($clave)):
                                                    $query_clave = mysqli_prepare($con, "SELECT * FROM codigos_clientes WHERE codigo = ?");
                                                    mysqli_stmt_bind_param($query_clave, "s", $clave);
                                                    mysqli_stmt_execute($query_clave);
                                                    $result_clave = mysqli_stmt_get_result($query_clave);
                                                    $info_clave = mysqli_fetch_array($result_clave);
                                                    mysqli_stmt_close($query_clave);
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($clave); ?></td>
                                                <td><?php echo htmlspecialchars($info_clave['cliente']); ?></td>
                                                <td><?php echo htmlspecialchars($info_clave['perfil']); ?></td>
                                            </tr>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Start -->
            <footer class="footer text-center text-sm-start">
                <span class="text-muted d-none d-sm-inline-block float-end">
                &copy; <script>document.write(new Date().getFullYear())</script> Grupo Mctree
                </span>
            </footer>
            <!-- end Footer -->                
        </div>
    </div>

    <!-- Javascript  -->  
    <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $views;?>../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo $views;?>../assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/app.js"></script>
</body>
</html>
<?php
} else {
    header("Location: ../../login.php");
}
?>