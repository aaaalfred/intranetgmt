<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    $views = "";
    include ("../actions/conexion.php");

    // Consulta para contar el total de solicitudes de personal
    $query_count = "SELECT COUNT(*) as total FROM reqpersonal";
    $result_count = mysqli_query($con, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_solicitudes = $row_count['total'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Inicio</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.png">

        <!-- App css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body id="body">
        <!-- leftbar-tab-menu -->
        <?php include ("../actions/leftbar.php");?>
        <!-- end leftbar-tab-menu-->

        <!-- Top Bar Start -->
        <!-- Top Bar Start -->
        <div class="topbar">            
            <!-- Navbar -->
            <nav class="navbar-custom" id="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-end mb-0">
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <img src="../assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                                <div>
                                    <small class="d-none d-md-block font-11"><?php echo $_SESSION['rol_gmt']; ?></small>
                                    <span class="d-none d-md-block fw-semibold font-12"> <?php echo $_SESSION['nombre_gmt']; ?> <i
                                            class="mdi mdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Perfil</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="../actions/logout.php"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
                        </div>
                    </li><!--end topbar-profile-->
                </ul><!--end topbar-nav-->
                <ul class="list-unstyled topbar-nav mb-0">                        
                    <li>
                        <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                            <i class="ti ti-menu-2"></i>
                        </button>
                    </li>                      
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->
        <!-- Top Bar End -->

        <div class="page-wrapper">

            <!-- Page Content-->
            <div class="page-content-tab">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Panel de Control</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-8">
                                            <h2 class="m-0"><?php echo $total_solicitudes; ?></h2>
                                            <p class="mb-0 text-muted">Total Solicitudes de Personal</p>
                                        </div>
                                        <div class="col-4 text-end">
                                            <i class="ti ti-file-description text-primary" style="font-size: 2.5em;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Buscar Personal</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese Nombre" autocomplete="off">
                                    </div>
                                    <div id="resultados-nombre" class="mt-4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                        <iframe width="500" height="450" src="https://lookerstudio.google.com/embed/reporting/d000869c-a253-4c46-a154-e1a6577bb967/page/u51DE" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
                                        </div>
                                    
                                        </div>
                                        </div>
                                        </div>
                    </div>
                </div>
                <!--Start Footer-->
                <!-- Footer Start -->
                <footer class="footer text-center text-sm-start">
                    <span class="text-muted d-none d-sm-inline-block float-end">
                    &copy; <script>
                        document.write(new Date().getFullYear())
                    </script> Grupo Mctree
                    </span>
                </footer>
                <!-- end Footer -->                
                <!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        <!-- Javascript  -->  
        <!-- vendor js -->
        
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>

        <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="../assets/js/pages/analytics-index.init.js"></script>
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            var typingTimer;
            var doneTypingInterval = 300; // Espera 300ms después de que el usuario deja de escribir

            $('#nombre').on('input', function() {
                clearTimeout(typingTimer);
                if ($('#nombre').val()) {
                    typingTimer = setTimeout(buscarPorNombre, doneTypingInterval);
                } else {
                    $('#resultados-nombre').html('');
                }
            });

            function buscarPorNombre() {
                var nombre = $('#nombre').val();
                $.ajax({
                    url: 'buscar_por_nombre.php',
                    method: 'POST',
                    data: { nombre: nombre },
                    success: function(response) {
                        $('#resultados-nombre').html(response);
                    },
                    error: function() {
                        $('#resultados-nombre').html('<p>Error al buscar.</p>');
                    }
                });
            }
        });
        </script>
    </body>
    <!--end body-->
</html>
<?php
}else {
    header('Location: login.php');
}
?>