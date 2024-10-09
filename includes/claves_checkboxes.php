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
?>
    <div class="mb-3" >
        <div class="col-md-9">
            <div class="form-check" >
                <input class="form-check-input clave-checkbox" type="checkbox" value="<?php echo htmlspecialchars($valor); ?>" id="clave<?php echo htmlspecialchars($valor); ?>" name="claves[]">
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