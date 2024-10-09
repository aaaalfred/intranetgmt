<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header('Location: ../../login.php');
    exit();
}

$views = "../";
include ("$views../actions/conexion.php");

// Función para obtener el último código y generar el siguiente
function getNextCode($con) {
    $result = $con->query("SELECT MAX(CAST(clave AS UNSIGNED)) as max_code FROM cuentas");
    $row = $result->fetch_assoc();
    $lastCode = $row['max_code'];

    if ($lastCode === null) {
        return "001";
    } else {
        $nextCode = intval($lastCode) + 1;
        return str_pad($nextCode, 3, "0", STR_PAD_LEFT);
    }
}

$newCode = getNextCode($con);

// Obtener los clientes activos
$clientes_activos = $con->query("SELECT nombre FROM cliente WHERE activos = 'SI'");

// Obtener los ejecutivos
$query_ejecutivos = $con->prepare("SELECT nombre, id FROM credenciales WHERE ejecutivo = ?");
$query_ejecutivos->bind_param("i", $_SESSION['id_gmt']);
$query_ejecutivos->execute();
$result_ejecutivos = $query_ejecutivos->get_result();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST['cliente'];
    $proyecto = $_POST['proyecto'];
    $ejecutivo_id = $_POST['ejecutivo'];
    $clave = $_POST['codigo'];
    $perfil = $_POST['perfil'];

    // Obtener el nombre del ejecutivo basado en el ID seleccionado
    $stmt = $con->prepare("SELECT nombre FROM credenciales WHERE id = ?");
    $stmt->bind_param("i", $ejecutivo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ejecutivo_nombre = $result->fetch_assoc()['nombre'];
    $stmt->close();

    // Iniciar transacción
    $con->begin_transaction();

    try {
        // Insertar en cuentas
        $stmt = $con->prepare("INSERT INTO cuentas (clave, cliente, ejecutivo, perfil, proyecto, idEjecutivo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $clave, $cliente, $ejecutivo_nombre, $perfil, $proyecto, $ejecutivo_id);
        $stmt->execute();
        $stmt->close();

        // Insertar en logs_codigos
        $stmt = $con->prepare("INSERT INTO logs_codigos (codigo) VALUES (?)");
        $stmt->bind_param("s", $clave);
        $stmt->execute();
        $stmt->close();

        // Si todo está bien, confirmar la transacción
        $con->commit();
        $mensaje = "Registro guardado exitosamente. Código: " . $clave;
        $newCode = getNextCode($con); // Obtener el siguiente código para el próximo registro
    } catch (Exception $e) {
        // Si algo sale mal, deshacer la transacción
        $con->rollback();
        $mensaje = "Error al guardar el registro: " . $e->getMessage();
    }
}

$title = "Crear Cliente-Proyecto";
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

            <?php if(isset($mensaje)): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensaje; ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3 row">
                                    <label for="codigo" class="col-sm-2 col-form-label text-end">Clave</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="codigo" id="codigo" value="<?php echo $newCode; ?>" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="cliente" class="col-sm-2 col-form-label text-end">Cliente</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" name="cliente" id="cliente" required>
                                            <option value="" disabled selected>Seleccione un cliente</option>
                                            <?php while($cliente = $clientes_activos->fetch_assoc()): ?>
                                                <option value="<?php echo htmlspecialchars($cliente['nombre']); ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="ejecutivo" class="col-sm-2 col-form-label text-end">Ejecutivo</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" name="ejecutivo" id="ejecutivo" required>
                                            <option value="" disabled selected>Seleccione un ejecutivo</option>
                                            <?php while($ejecutivo = $result_ejecutivos->fetch_assoc()): ?>
                                                <option value="<?php echo $ejecutivo['id']; ?>"><?php echo htmlspecialchars($ejecutivo['nombre']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="perfil" class="col-sm-2 col-form-label text-end">Perfil</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="perfil" id="perfil" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="proyecto" class="col-sm-2 col-form-label text-end">Proyecto</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="proyecto" id="proyecto" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 ms-auto">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include ("../../includes/footer.php"); ?>
</div>

<?php include ("../../includes/scripts.php"); ?>

<script>
$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            }
        }
    });
});
</script>

</body>
</html>