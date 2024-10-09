<?php
session_start();

if (isset($_SESSION['login_gmt'])) {
    $views = "../";
    include("$views../actions/conexion.php");

    // Obtener y sanitizar las claves del usuario
    $clave_gmt = $_SESSION['clave_gmt'] ?? '';
    $clave_array = array_filter(array_map('trim', explode(',', $clave_gmt)));

    if (count($clave_array) > 0) {
        // Crear placeholders para la consulta preparada
        $placeholders = implode(',', array_fill(0, count($clave_array), '?'));

        // Preparar la consulta
        $sql = "SELECT * FROM codigos_clientes WHERE codigo IN ($placeholders)";
        $stmt = $con->prepare($sql);

        // Vincular los parámetros
        $types = str_repeat('s', count($clave_array));
        $stmt->bind_param($types, ...$clave_array);

        // Ejecutar la consulta
        $stmt->execute();
        $query_clientes = $stmt->get_result();
    } else {
        // Manejar el caso en que no hay claves disponibles
        $query_clientes = [];
    }
    ?>
    <!DOCTYPE html>
    <html lang="es" dir="ltr">
        <head>
            <meta charset="utf-8" />
            <title>Candidatos</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <!-- Favicon -->
            <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">

            <!-- Estilos CSS -->
            <link href="<?php echo $views;?>../assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo $views;?>../assets/libs/vanillajs-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
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
            <!-- Barra lateral -->
            <?php include ("../../actions/leftbar.php");?>
            <!-- Barra superior -->
            <?php include ("../../actions/topbar.php");?>

            <div class="page-wrapper">
                <div class="page-content-tab">
                    <div class="container-fluid">
                        <!-- Contenido principal -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <!-- Encabezado de la tarjeta -->
                                    <div class="card-header">
                                        <h4 class="card-title">Candidatos</h4>
                                    </div>
                                    <!-- Filtros -->
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Filtros</h4>
                                                    <p class="text-muted mb-0">Busca entre rango de fechas</p>
                                                </div>
                                                <form id="filtro-form">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <label class="mb-3">Selecciona un rango de fechas</label>
                                                                <div class="input-group" id="DateRange">
                                                                    <input type="date" class="form-control" name="date1" placeholder="Inicial" aria-label="FechaInicial">
                                                                    <span class="input-group-text"> a </span>
                                                                    <input type="date" class="form-control" name="date2" placeholder="Final" aria-label="FechaFinal">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="mb-3">Selecciona un cliente</label>
                                                                <select class="input-group" id="multiSelect" name="codsel[]" multiple>
                                                                <?php while ($filac = $query_clientes->fetch_assoc()) { ?>
                                                                    <option value="<?php echo htmlspecialchars($filac['codigo']); ?>"><?php echo htmlspecialchars($filac['codigo']." - ".$filac['cliente']." - ".$filac['perfil']); ?></option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <button class="btn btn-primary" type="submit">Filtrar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Búsqueda por CURP</h4>
                                                    <p class="text-muted mb-0">Ingresa la CURP del candidato</p>
                                                </div>
                                                <form method="POST" action="buscarcurp.php">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <label class="mb-3">CURP</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" name="bcurp" id="bcurp">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <button class="btn btn-primary" type="submit">Buscar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Contenedor de los candidatos -->
                                    <div class="card-body">
                                        <div id="candidatos-container">
                                            <!-- Aquí se cargarán los datos de los candidatos -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie de página -->
                    <footer class="footer text-center text-sm-start">
                        &copy; <script>
                            document.write(new Date().getFullYear())
                        </script> Grupo Mctree
                    </footer>
                </div>
            </div>

            <!-- Scripts JavaScript -->
            <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="<?php echo $views;?>../assets/libs/simplebar/simplebar.min.js"></script>
            <script src="<?php echo $views;?>../assets/libs/feather-icons/feather.min.js"></script>
            <script src="<?php echo $views;?>../assets/libs/simple-datatables/umd/simple-datatables.js"></script>
            <script src="<?php echo $views;?>../assets/libs/vanillajs-datepicker/js/datepicker-full.min.js"></script>
            <script src="<?php echo $views;?>../assets/js/pages/datatable.init.js"></script>
            <script src="<?php echo $views;?>../assets/js/app.js"></script>
            <script src="<?php echo $views;?>../assets/libs/mobius1-selectr/selectr.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
            $(document).ready(function() {
                new Selectr("#multiSelect", { multiple: true });

                loadCandidatos();

                function loadCandidatos(filtros = {}) {
                    displaySkeletonLoader();

                    $.ajax({
                        url: 'get_candidatos.php',
                        method: 'POST',
                        data: filtros,
                        dataType: 'json',
                        success: function(data) {
                            displayCandidatos(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar candidatos:", error);
                            $('#candidatos-container').html('<p class="text-danger">Error al cargar los datos. Por favor, intente de nuevo.</p>');
                        }
                    });
                }

                function displaySkeletonLoader() {
                    var html = '<table class="table" id="datatable_1">';
                    html += '<thead class="thead-light">';
                    html += '<tr><th>Nombre</th><th>Teléfono</th><th>CURP</th><th>Fecha Alta</th><th>Cliente</th><th>Perfil</th><th>Ver</th></tr>';
                    html += '</thead><tbody>';

                    for (var i = 0; i < 10; i++) {
                        html += '<tr>';
                        for (var j = 0; j < 7; j++) {
                            html += '<td><div class="skeleton-loader skeleton-row"></div></td>';
                        }
                        html += '</tr>';
                    }

                    html += '</tbody></table>';
                    $('#candidatos-container').html(html);
                }

                function displayCandidatos(candidatos) {
                    var html = '<table class="table" id="datatable_1">';
                    html += '<thead class="thead-light">';
                    html += '<tr><th>Nombre</th><th>Teléfono</th><th>CURP</th><th>Cliente</th><th>Proyecto</th><th>Perfil</th><th>Acciones</th></tr>';
                    html += '</thead><tbody>';

                    if (candidatos.length === 0) {
                        html += '<tr><td colspan="7" class="text-center">No se encontraron candidatos</td></tr>';
                    } else {
                        candidatos.forEach(function(candidato) {
                            html += '<tr>';
                            html += '<td>' + candidato.nombre + '</td>';
                            html += '<td>' + candidato.telefono + ' <a href="https://wa.me/' + formatPhoneNumber(candidato.telefono) + '" target="_blank"><i class="fab fa-whatsapp text-success" style="font-size: 1.2em;"></i></a></td>';
                            html += '<td>' + candidato.curp + '</td>';
                            html += '<td>' + candidato.cliente + '</td>';
                            html += '<td>' + candidato.proyecto + '</td>';
                            html += '<td>' + candidato.perfil + '</td>';
                            html += '<td><a href="perfil.php?id=' + candidato.id + '&curp=' + candidato.curp + '&vista=candidatos"><i class="las la-pen text-secondary font-16"></i></a></td>';
                            html += '</tr>';
                        });
                    }

                    html += '</tbody></table>';
                    $('#candidatos-container').html(html);

                    // Inicializar o actualizar el DataTable
                    if (window.dataTable) {
                        dataTable.destroy();
                    }
                    window.dataTable = new simpleDatatables.DataTable("#datatable_1");
                }

                function formatPhoneNumber(phoneNumber) {
                    var cleaned = ('' + phoneNumber).replace(/\D/g, '');

                    if (cleaned.length === 10) {
                        cleaned = '52' + cleaned;
                    } else if (cleaned.length === 11 && cleaned[0] === '1') {
                        cleaned = '52' + cleaned.slice(1);
                    }

                    return cleaned;
                }

                $('#filtro-form').on('submit', function(e) {
                    e.preventDefault();
                    var filtros = $(this).serialize();
                    loadCandidatos(filtros);
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
