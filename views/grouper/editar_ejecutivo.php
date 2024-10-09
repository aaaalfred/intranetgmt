<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header('Location: ../../login.php');
    exit();
}

$views = "../";
include ("$views../actions/conexion.php");

$query_ejecutivo = mysqli_prepare($con, "SELECT * FROM credenciales WHERE id = ?");
mysqli_stmt_bind_param($query_ejecutivo, "i", $_GET['id']);
mysqli_stmt_execute($query_ejecutivo);
$result = mysqli_stmt_get_result($query_ejecutivo);
$ejecutivo = mysqli_fetch_array($result);
mysqli_stmt_close($query_ejecutivo);

$claves_actuales = explode(',', $ejecutivo['clave']);

$title = "Editar Ejecutivo";
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
                <div class="col-lg-12">
                    <div class="card">
                        <form method="POST" action="actualizar_ejecutivo.php?id=<?php echo htmlspecialchars($_GET['id']); ?>" onsubmit="return validateForm()">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 row">
                                            <label for="nombre" class="col-sm-2 col-form-label text-end">Nombre</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($ejecutivo['nombre']); ?>" name="nombre" id="nombre" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="tipo" class="col-sm-2 col-form-label text-end">Tipo</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" name="tipo" id="tipo" required>
                                                    <?php
                                                    $tipos = ['A', 'B', 'GROUPER'];
                                                    foreach ($tipos as $tipo) {
                                                        $selected = ($ejecutivo['tipo'] == $tipo) ? 'selected' : '';
                                                        echo "<option value=\"$tipo\" $selected>$tipo</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="usuario" class="col-sm-2 col-form-label text-end">Usuario</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($ejecutivo['usuario']); ?>" name="usuario" id="usuario" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="password" class="col-sm-2 col-form-label text-end">Contraseña</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password" value="<?php echo htmlspecialchars($ejecutivo['password']); ?>" name="password" id="password" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="correo" class="col-sm-2 col-form-label text-end">Correo</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="email" value="<?php echo htmlspecialchars($ejecutivo['correo']); ?>" name="correo" id="correo" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="col-sm-8 col-form-label text-start">Marque las claves a añadir (al menos una es requerida): </label>
                                        </div>
                                        <?php
                                        $porciones = explode(",", $_SESSION['clave_gmt']); 
                                        foreach($porciones as $valor){
                                            $valor = trim($valor);
                                            if(!empty($valor)){
                                                $stmt = $con->prepare("SELECT * FROM codigos_clientes WHERE codigo = ?");
                                                $stmt->bind_param("s", $valor);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $fres = $result->fetch_assoc();
                                                if ($fres) {
                                                    $checked = in_array($valor, $claves_actuales) ? 'checked' : '';
                                        ?>
                                            <div class="mb-3" >
                                                <div class="col-md-9">
                                                    <div class="form-check" >
                                                        <input class="form-check-input clave-checkbox" type="checkbox" value="<?php echo htmlspecialchars($valor); ?>" id="clave<?php echo htmlspecialchars($valor); ?>" name="claves[]" <?php echo $checked; ?>>
                                                        <label class="form-check-label" for="clave<?php echo htmlspecialchars($valor); ?>">
                                                            <?php echo htmlspecialchars($valor." - ".$fres['cliente']." - ".$fres['proyecto']); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php  
                                                }
                                                $stmt->close();
                                            }
                                        } 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary" style="width: 30%;">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include ("../../includes/footer.php"); ?>
    </div>
</div>

<?php include ("../../includes/scripts.php"); ?>

<script>
function validateForm() {
    var checkboxes = document.getElementsByName('claves[]');
    var isChecked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            isChecked = true;
            break;
        }
    }
    if (!isChecked) {
        alert('Por favor, seleccione al menos una clave.');
        return false;
    }
    return true;
}
</script>

</body>
</html>