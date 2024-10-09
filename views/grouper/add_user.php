<?php
session_start();
if(!isset($_SESSION['login_gmt'])) {
    header("Location: ../../login.php");
    exit();
}

$views = "../";
include ("$views../actions/conexion.php");

$title = "Agregar ejecutivo";
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
                        <form method="POST" action="insertar_ejecutivo.php" onsubmit="return validateForm()">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php include("../../includes/form_fields.php"); ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?php include("../../includes/claves_checkboxes.php"); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary" style="width: 30%;">Crear usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include ("../../includes/footer.php"); ?>
    </div>
</div>

<!-- Modal para mensaje de validación -->
<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validationModalLabel">Atención</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Por favor, seleccione al menos una clave.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include ("../../includes/scripts.php"); ?>

<script>
function validateForm() {
    var checkboxes = document.getElementsByClassName('clave-checkbox');
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }
    if (!checked) {
        var validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
        validationModal.show();
        return false;
    }
    return true;
}
</script>

</body>
</html>