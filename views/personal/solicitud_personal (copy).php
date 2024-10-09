<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    $views = "../";

    include ("$views../actions/conexion.php");

    $query_clientes =("SELECT id, pre, nombre FROM cliente order by nombre;");
    $clientes= mysqli_query ($con, $query_clientes);

    $query_proyectos = "SELECT proyecto, clave, cliente, perfil FROM cuentas WHERE idEjecutivo = '" . $_SESSION['id_gmt'] . "' ORDER BY proyecto;";
    $proyectos = mysqli_query($con, $query_proyectos);

    $coordinacion =("SELECT *FROM coordinacion;");
    $qcoor= mysqli_query ($con, $coordinacion);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Solicitud de personal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

        <link href="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="<?php echo $views;?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <style>
            .clave-highlight {
                font-size: 1.2em;
                font-weight: bold;
                padding: 10px;
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                margin-bottom: 20px;
            }
        </style>
    </head>

    <body id="body">
        <!-- leftbar-tab-menu -->
        <?php include ("../../actions/leftbar.php");?>
        <!-- end leftbar-tab-menu-->

        <!-- Top Bar Start -->
        <div class="topbar">            
            <!-- Navbar -->
            <nav class="navbar-custom" id="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-end mb-0">
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $views;?>../assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                                <div>
                                    <small class="d-none d-md-block font-11"><?php echo $_SESSION['rol_gmt']; ?></small>
                                    <span class="d-none d-md-block fw-semibold font-12"> <?php echo $_SESSION['nombre_gmt']; ?> <i
                                            class="mdi mdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?php echo $views; ?>perfil/perfil.php"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Perfil</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="<?php echo $views; ?>../actions/logout.php"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
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

        <div class="page-wrapper">

            <!-- Page Content-->
            <div class="page-content-tab">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form method="POST" action="insertar_spersonal.php">
                                <div class="card-header">
                                    <h4 class="card-title">Solicitud de personal</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Campo Clave -->
                                    <div class="row justify-content-center mb-4">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="clave" class="form-label">Clave</label>
                                                <select class="form-select clave-highlight" id="clave" name="clave" style="width: 100%;">
                                                    <option></option>
                                                    <?php 
                                                    mysqli_data_seek($proyectos, 0);
                                                    while ($fila_proyecto = mysqli_fetch_array($proyectos))
                                                    {
                                                        echo "<option value='".$fila_proyecto["clave"]."' 
                                                            data-cliente='".$fila_proyecto["cliente"]."'
                                                            data-proyecto='".$fila_proyecto["proyecto"]."'
                                                            data-perfil='".$fila_proyecto["perfil"]."'>"
                                                            .$fila_proyecto["cliente"]." - "
                                                            .$fila_proyecto["proyecto"]." - "
                                                            .$fila_proyecto["clave"]." - "
                                                            .$fila_proyecto["perfil"]
                                                            ."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bloque de Proyecto -->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-title">Proyecto</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label class="col-form-label text-end">Cliente</label>
                                                            <input type="text" class="form-control" id="cliente" name="cliente" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="promocion" class="col-form-label text-end">Promoción</label>
                                                            <input class="form-control" type="text" name="promocion" id="promocion" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="perfil" class="col-form-label text-end">Perfil</label>
                                                            <input class="form-control" type="text" name="perfil" id="perfil" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bloque de Contrato -->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-title">Contrato</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="sueldo" class="col-form-label text-end">Sueldo mensual bruto (30 días)</label>
                                                            <input class="form-control" type="number" step="0.01" name="sueldo" id="sueldo">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="f_ingreso" class="col-form-label text-end">Fecha de ingreso</label>
                                                            <input class="form-control" type="date" name="f_ingreso" id="f_ingreso">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="terminoplan" class="col-form-label text-end">Termino de plan</label>
                                                            <input class="form-control" type="date" name="terminoplan" id="terminoplan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bloque de Reclutamiento -->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="card-title">Reclutamiento</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="npersonal_casting" class="col-form-label text-end">No. Personal para casting</label>
                                                            <input class="form-control" type="number" name="npersonal_casting" id="npersonal_casting">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="npersonal_requerido" class="col-form-label text-end">No. Personal requerido</label>
                                                            <input class="form-control" type="number" name="npersonal_requerido" id="npersonal_requerido">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="descripcion" class="col-form-label text-end">Descripción del puesto</label>
                                                            <input class="form-control" type="text" name="descripcion" id="descripcion">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="escolaridad" class="col-form-label text-end">Escolaridad</label>
                                                            <input class="form-control" type="text" name="escolaridad" id="escolaridad">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="tdias" class="col-form-label text-end">Total días a laborar por semana</label>
                                                            <input class="form-control" type="number" name="tdias" id="tdias" min="1" max="6">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="dias" class="col-form-label text-end">Días a laborar por semana</label>
                                                            <input class="form-control" type="text" name="dias" id="dias">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="bono" class="col-form-label text-end">Sueldo mensual con bonos</label>
                                                            <input class="form-control" type="number" step="0.01" name="bono" id="bono">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="horarios" class="col-form-label text-end">Horarios</label>
                                                            <input class="form-control" type="text" name="horarios" id="horarios">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label class="col-form-label text-end">Experiencia con movil</label>
                                                            <select class="form-select" name="exp_movil" aria-label="Default select example">
                                                                <option selected>No necesario</option>
                                                                <option>Si</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="edad" class="col-form-label text-end">Edad</label>
                                                            <input class="form-control" type="text" name="edad" id="edad">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label class="col-form-label text-end">Sexo</label>
                                                            <select class="form-select" name="sexo" aria-label="Default select example">
                                                                <option selected>Masculino</option>
                                                                <option>Femenino</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="zonas" class="col-form-label text-end">Zonas</label>
                                                            <input class="form-control" type="text" name="zonas" id="zonas">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="tiendas" class="col-form-label text-end">Tiendas</label>
                                                            <input class="form-control" type="text" name="tiendas" id="tiendas">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="experiencia" class="col-form-label text-end">Experiencia</label>
                                                            <input class="form-control" type="text" name="experiencia" id="experiencia">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="f_entrevista" class="col-form-label text-end">Fecha de entrevista</label>
                                                            <input class="form-control" type="date" name="f_entrevista" id="f_entrevista">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="h_entrevista" class="col-form-label text-end">Hora de entrevista</label>
                                                            <input class="form-control" type="time" name="h_entrevista" id="h_entrevista">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="l_entrevista" class="col-form-label text-end">Lugar de entrevista</label>
                                                            <input class="form-control" type="text" name="l_entrevista" id="l_entrevista">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="requerimientos" class="col-form-label text-end">Requerimientos particulares</label>
                                                            <input class="form-control" type="text" name="requerimientos" id="requerimientos">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-10">
                                                            <label for="comentarios" class="col-form-label text-end">Comentarios</label>
                                                            <input class="form-control" type="text" name="comentarios" id="comentarios">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end card-body-->
                                <div align="center">
                                    <div class="">
                                        <div class="col-sm-6">
                                            <label class="col-form-label text-end" for="coordinacion">COORDINACION</label>
                                            <select name="coordinacion" id="coordinacion" class="form-control">
                                                <?php while ($filacoor = mysqli_fetch_array ($qcoor) )
                                                {
                                                echo "<option value='".$filacoor["correo"]."'>".$filacoor["nombre"]."(".$filacoor["correo"].") </option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn  btn-primary " style="width: 30%;">Enviar</button>
                                </div>
                                <br><br>
                            </form>
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!-- container -->

            <!-- Footer Start -->
            <footer class="footer text-center text-sm-start">
                <span class="text-muted d-none d-sm-inline-block float-end">
                    &copy; <script>
                        document.write(new Date().getFullYear())
                    </script> Grupo Mctree
                </span>
            </footer>
            <!-- end Footer -->                
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Javascript  -->  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $views;?>../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo $views;?>../assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo $views;?>../assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/pages/analytics-index.init.js"></script>
    <script src="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/app.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#clave').select2({
                placeholder: "Buscar y seleccionar clave",
                allowClear: true
            });

            $('#clave').on('select2:select', function (e) {
                var data = e.params.data;
                var $option = $(e.params.data.element);
                var cliente = $option.data('cliente');
                var proyecto = $option.data('proyecto');
                var perfil = $option.data('perfil');
                document.getElementById('cliente').value = cliente;
                document.getElementById('promocion').value = proyecto;
                document.getElementById('perfil').value = perfil;
            });
        });
    </script>

</body>
</html>
<?php
} else {
    header("Location: ../../login.php");
}
?>