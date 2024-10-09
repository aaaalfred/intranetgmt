<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    $views = "../../";
    include("$views../actions/conexion.php");

    function quitar_acentos($cadena) {
        $no_permitidas = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','À','Ã','Ì','Ò','Ù','Ã™','Ã','Ãè','Ã¬','Ã²','Ã¹','ç','Ç','Ã¢','ê','Ã®','Ã´','Ã»','Ã‚','ÃŠ','ÃŽ','Ã','Ã›','ü','Ã¶','Ã–','Ã¯','Ã¤','«','Ò','Ã','ÃÄ','ÃË');
        $permitidas = array('a','e','i','o','u','A','E','I','O','U','n','N','A','E','I','O','U','a','e','i','o','u','c','C','a','e','i','o','u','A','E','I','O','U','u','o','O','i','a','e','U','I','A','E');
        return str_replace($no_permitidas, $permitidas, $cadena);
    }

    $query_usuarios = mysqli_query($con, "SELECT * FROM usuarios WHERE status_contrato = 'Proceso'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Generar Contratos</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body id="body">
    <!-- leftbar-tab-menu -->
    <?php include ("../../../actions/leftbar.php");?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php include ("../../../actions/topbar.php");?>
    <!-- Top Bar End -->

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content-tab">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Generar Contratos</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Contratos por Generar</h4>
                            </div>
                            <div class="card-body">
                                <form action="generar_contrato.php" method="post">
                                    <div class="table-responsive">
                                        <table class="table" id="datatable_1">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Teléfono</th>
                                                    <th>CURP</th>
                                                    <th>Fecha Alta</th>
                                                    <th>Cliente</th>
                                                    <th>Perfil</th>
                                                    <th>Estado</th>
                                                    <th>PDF</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                while ($fila = mysqli_fetch_array($query_usuarios)) {
                                                    $nombre = quitar_acentos($fila['nombre']);
                                                    $app = quitar_acentos($fila['app']);
                                                    $apm = quitar_acentos($fila['apm']);
                                                    $query_cliper = mysqli_query($con, "SELECT cliente, perfil FROM codigos_clientes WHERE codigo ='".substr($fila['clave_ejecutivo'], 0, 3)."'");
                                                    $filaqp = mysqli_fetch_array($query_cliper);

                                                    // Comprobar si existe el PDF del contrato usando el CURP
                                                    $nombre_pdf = 'Contrato_' . $fila['curp'] . '.pdf';
                                                    $ruta_pdf = __DIR__ . '/contratos_generados/' . $nombre_pdf;
                                                    $url_pdf = '/views/personal/contratos/contratos_generados/' . $nombre_pdf;
                                                    $pdf_link = file_exists($ruta_pdf) ? "<a href='$url_pdf' target='_blank'>Ver PDF</a>" : "No generado";
                                                ?>
                                                <tr>
                                                    <td><?php echo strtoupper($nombre." ".$app." ".$apm); ?></td>
                                                    <td>
                                                        <?php echo $fila["telefono"]; ?>
                                                        <a href="https://api.whatsapp.com/send?phone=<?php echo $fila["telefono"]; ?>" target="_blank">
                                                            <i class="fab fa-whatsapp text-success"></i>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $fila["curp"]; ?></td>
                                                    <td><?php echo $fila["fechaAlta"]; ?></td>
                                                    <td><?php echo $filaqp["cliente"]; ?></td>
                                                    <td><?php echo $filaqp["perfil"]; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($fila['autorizado_dos'] === null) {
                                                            echo '<span class="badge bg-warning">Pendiente</span>';
                                                        } elseif ($fila['autorizado_dos'] == 1) {
                                                            echo '<span class="badge bg-success">Generado</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $pdf_link; ?></td>
                                                    <td>
                                                        <input type="checkbox" name="selected_users[]" value="<?php echo $fila['id']; ?>">
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary">Generar Contratos Seleccionados</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <footer class="footer text-center text-sm-start">
                &copy; <script>
                    document.write(new Date().getFullYear())
                </script> Grupo Mctree
            </footer>
            <!-- end Footer -->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- jQuery  -->
    <script src="<?php echo $views;?>../assets/js/jquery.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/metismenu.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/waves.js"></script>
    <script src="<?php echo $views;?>../assets/js/feather.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/simplebar.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/moment.js"></script>
    <script src="<?php echo $views;?>../assets/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- App js -->
    <script src="<?php echo $views;?>../assets/js/app.js"></script>

</body>
</html>
<?php
} else {
    header('Location: ../../login.php');
}
?>