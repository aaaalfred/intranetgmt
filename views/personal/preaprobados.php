<?php
session_start();
if(isset($_SESSION['login_gmt']))
{
    $views = "../";

    include("$views../actions/conexion.php");

    $query_clientes = mysqli_query($con, "SELECT * FROM codigos_clientes WHERE codigo IN (".$_SESSION['clave_gmt'].");");
    $query_reqpersonal = mysqli_query($con, "SELECT id, promocion, puesto FROM reqpersonal WHERE usuario = '".$_SESSION['nombre_gmt']."'");
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Preaprobados</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

        <link href="<?php echo $views;?>../assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="<?php echo $views;?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $views;?>../assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <style>
            .skeleton-loader {
                animation: loading 1.5s infinite;
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                border-radius: 4px;
            }
            .skeleton-row {
                height: 20px;
                margin-bottom: 10px;
            }
            @keyframes loading {
                0% {
                    background-position: 200% 0;
                }
                100% {
                    background-position: -200% 0;
                }
            }
        </style>
    </head>

    <body id="body">
        <!-- leftbar-tab-menu -->
        <?php include ("../../actions/leftbar.php");?>
        <!-- end leftbar-tab-menu-->

        <!-- Top Bar Start -->
        <?php include ("../../actions/topbar.php");?>
        <!-- Top Bar End -->

        <div class="page-wrapper">
            <div class="page-content-tab">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Preaprobados</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Preaprobados</h4>
                                </div>
                                <div class="card-body">
                                    <form id="filtro-form">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Selecciona un cliente</label>
                                                <select class="form-select" id="multiSelect" name="codsel[]" multiple>
                                                    <?php while ($filac = mysqli_fetch_array($query_clientes)) { ?>
                                                        <option value="<?php echo htmlspecialchars($filac['codigo']); ?>"><?php echo htmlspecialchars($filac['codigo']." - ".$filac['cliente']." - ".$filac['perfil']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 align-self-end">
                                                <button class="btn btn-primary" type="submit">Filtrar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form method="post" action="actualizar_solicitudes.php" enctype="multipart/form-data">
                                        <div id="preaprobados-container">
                                            <!-- Aquí se cargarán los datos de los preaprobados -->
                                        </div>
                                        <div class="mt-3">
                                            <select name="reqpersonal_id" class="form-select" style="width: auto; display: inline-block; margin-right: 10px;">
                                                <option value="">Seleccionar requisición</option>
                                                <?php
                                                mysqli_data_seek($query_reqpersonal, 0);
                                                while ($fila_req = mysqli_fetch_array($query_reqpersonal)) {
                                                    $req_info = $fila_req['id'] . ' - ' . $fila_req['promocion'] . ' - ' . $fila_req['puesto'];
                                                    echo '<option value="' . $fila_req['id'] . '">' . htmlspecialchars($req_info) . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <button class="btn btn-primary" type="submit">Asignar Folio</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Start Footer-->
                <footer class="footer text-center text-sm-start">
                    &copy; <script>
                        document.write(new Date().getFullYear())
                    </script> Grupo Mctree
                </footer>
                <!--end footer-->
            </div>
        </div>

        <!-- Javascript  -->  
        <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/feather-icons/feather.min.js"></script>
        <script src="<?php echo $views;?>../assets/js/app.js"></script>
        <script src="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="<?php echo $views;?>../assets/libs/simple-datatables/umd/simple-datatables.js"></script>

        <script>
        $(document).ready(function() {
            new Selectr("#multiSelect", { multiple: true });

            let dataTable;

            function initDataTable() {
                // Verificar si dataTable ya existe y está inicializado
                if (dataTable && dataTable.initialized) {
                    dataTable.destroy();
                }

                // Esperar a que el DOM se actualice antes de inicializar el DataTable
                setTimeout(() => {
                    dataTable = new simpleDatatables.DataTable("#datatable_1", {
                        perPage: 10,
                        perPageSelect: [5, 10, 15, 20, 25],
                        labels: {
                            placeholder: "Buscar...",
                            perPage: "{select} registros por página",
                            noRows: "No se encontraron registros",
                            info: "Mostrando {start} a {end} de {rows} registros",
                        },
                    });
                }, 0);
            }

            function loadPreaprobados(filtros = {}) {
                displaySkeletonLoader();

                $.ajax({
                    url: 'get_preaprobados.php',
                    method: 'POST',
                    data: filtros,
                    dataType: 'json',
                    success: function(data) {
                        if (data.error) {
                            console.error("Error:", data.error);
                            $('#preaprobados-container').html('<p class="text-danger">' + data.error + '</p>');
                        } else {
                            displayPreaprobados(data);
                            initDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al cargar preaprobados:", error);
                        $('#preaprobados-container').html('<p class="text-danger">Error al cargar los datos. Por favor, intente de nuevo.</p>');
                    }
                });
            }

            function displaySkeletonLoader() {
                var html = '<table class="table" id="datatable_1">';
                html += '<thead class="thead-light">';
                html += '<tr><th>Nombre</th><th>Teléfono</th><th>CURP</th><th>Fecha Alta</th><th>Cliente</th><th>Clave</th><th>Perfil</th><th>Ver</th><th>Seleccionar</th></tr>';
                html += '</thead><tbody>';

                for (var i = 0; i < 10; i++) {
                    html += '<tr>';
                    for (var j = 0; j < 9; j++) {
                        html += '<td><div class="skeleton-loader skeleton-row"></div></td>';
                    }
                    html += '</tr>';
                }

                html += '</tbody></table>';
                $('#preaprobados-container').html(html);
            }

            function displayPreaprobados(preaprobados) {
                var html = '<table class="table" id="datatable_1">';
                html += '<thead class="thead-light">';
                html += '<tr><th>Nombre</th><th>Teléfono</th><th>CURP</th><th>Fecha Alta</th><th>Cliente</th><th>Clave</th><th>Perfil</th><th>Ver</th><th><input type="checkbox" id="select_all" /></th></tr>';
                html += '</thead><tbody>';

                if (preaprobados.length === 0) {
                    html += '<tr><td colspan="9" class="text-center">No se encontraron preaprobados</td></tr>';
                } else {
                    preaprobados.forEach(function(preaprobado) {
                        html += '<tr>';
                        html += '<td>' + preaprobado.nombre + '</td>';
                        html += '<td>' + preaprobado.telefono + '</td>';
                        html += '<td>' + preaprobado.curp + '</td>';
                        html += '<td>' + preaprobado.fechaAlta + '</td>';
                        html += '<td>' + preaprobado.cliente + '</td>';
                        html += '<td>' + preaprobado.clave_ejecutivo + '</td>';
                        html += '<td>' + preaprobado.perfil + '</td>';
                        html += '<td><a href="perfil.php?id=' + preaprobado.id + '&curp=' + preaprobado.curp + '&vista=preaprobados"><i class="las la-pen text-secondary font-16"></i></a></td>';
                        html += '<td><input type="checkbox" name="selected_users[]" value="' + preaprobado.id + '" /></td>';
                        html += '</tr>';
                    });
                }

                html += '</tbody></table>';
                $('#preaprobados-container').html(html);

                // Agregar funcionalidad al checkbox "select_all"
                $('#select_all').on('click', function() {
                    $('input[name="selected_users[]"]').prop('checked', this.checked);
                });
            }

            $('#filtro-form').on('submit', function(e) {
                e.preventDefault();
                var filtros = $(this).serialize();
                loadPreaprobados(filtros);
            });

            // Carga inicial de preaprobados
            loadPreaprobados();
        });
        </script>
    </body>
</html>
<?php
} else {
    header('Location: login.php');
}
?>