<?php
error_reporting(0);
session_start();
if(isset($_SESSION['login_gmt']))
{
    $views = "../";
    include("$views../actions/conexion.php");

    function quitar_acentos($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿ';
        $modificadas = 'aaaaaaaceeeeiiiidoooooouuuuybsaaaaaaaceeeeiiiidoooooouuuyyby';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        return utf8_encode($cadena);
    }

    $resultados = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['curp'])) {
        $curp = $_POST['curp'];
        $query = "SELECT * FROM usuarios WHERE curp LIKE ?";
        $stmt = $con->prepare($query);
        $curp = "%$curp%";
        $stmt->bind_param("s", $curp);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Buscador de Registros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo $views;?>../assets/images/favicon.png">
    <link href="<?php echo $views;?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $views;?>../assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include ("../../actions/leftbar.php");?>
    <?php include ("../../actions/topbar.php");?>

    <div class="page-wrapper">
        <div class="page-content-tab">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Buscador de Registros</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="curp" class="form-label">Buscar por CURP</label>
                                        <input type="text" class="form-control" id="curp" name="curp" placeholder="Ingrese CURP">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Buscar por CURP</button>
                                </form>

                                <div class="mt-4">
                                    <label for="nombre" class="form-label">Buscar por Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese Nombre" autocomplete="off">
                                </div>

                                <div id="resultados-nombre" class="mt-4"></div>

                                <?php if (!empty($resultados)): ?>
                                    <h5 class="mt-4">Resultados de búsqueda por CURP:</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>CURP</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($resultados as $fila): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($fila['nombre'] . ' ' . $fila['app'] . ' ' . $fila['apm']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['curp']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
                                                    <td>
                                                        <a href="perfil.php?id=<?php echo $fila['id']; ?>&curp=<?php echo $fila['curp']; ?>&vista=buscador" class="btn btn-sm btn-info">Ver perfil</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                                    <p class="mt-4">No se encontraron resultados.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center text-sm-start">
                &copy; <script>document.write(new Date().getFullYear())</script> Grupo Mctree
            </footer>
        </div>
    </div>

    <script src="<?php echo $views;?>../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $views;?>../assets/js/app.js"></script>
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
</html>
<?php
} else {
    header("Location: ../../login.php");
}
?>