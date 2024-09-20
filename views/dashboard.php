<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
	$views = "";
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
                            <a class="dropdown-item" href="#"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
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
				<iframe title="Contratos" width=100% height="900" src="https://app.powerbi.com/view?r=eyJrIjoiNjk5MWJhNGMtNWQxZC00ZDg4LTg3MWQtZTUyZGE0MjI4ZDBiIiwidCI6IjUzMjIxMjc5LTkzMWQtNGUwNy04OTBkLTlhOGE0NDgxMTM2NyJ9&pageName=ReportSectiona4b5a5dbc3301a0977b4" frameborder="0" allowFullScreen="true"></iframe>
            </div><!-- container -->
                 
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

    </body>
    <!--end body-->
</html>
<?php
}else {
    header('Location: login.php');
}
?>